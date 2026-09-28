<?php
/**
 * LeitorSQL - Le o dump MySQL e extrai tabelas, colunas, PKs e FKs.
 *
 * Fluxo:
 *   1. Recebe o arquivo via POST (index.php).
 *   2. move_uploaded_file() para a pasta "sql/".
 *   3. processarTabelas() le o conteudo com regex.
 *   4. Dispara os geradores de Model, View, Control, DAO e Conexao.
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once("ClassesModel.php");
require_once("ClassesView.php");
require_once("ClassesControl.php");
require_once("ClassesDAO.php");
require_once("ClassesConexao.php");

class LeitorSQL
{
    private string $conteudo;
    private array  $tabelas = [];
    private array  $relacionamentos = [];
    private string $banco = '';
    private string $host  = '';

    /**
     * Le o arquivo SQL e dispara o processamento.
     */
    public function receberArquivoSQL(string $arquivo)
    {
        if (!file_exists($arquivo)) {
            throw new Exception("Arquivo nao encontrado.");
        }
        $this->conteudo = file_get_contents($arquivo);
        $this->processarTabelas();
    }

    /**
     * Extrai tabelas, colunas, PKs e FKs do dump.
     *
     * Regex principal (CREATE TABLE):
     *   /CREATE TABLE\s+`([^`]+)`\s*\((.*?)\)\s*ENGINE=/s
     *   - `([^`]+)`        -> nome da tabela entre crases
     *   - \((.*?)\)        -> conteudo entre parenteses (non-greedy)
     *   - /s               -> faz o "." casar tambem com quebras de linha
     *
     * Regex de PRIMARY KEY:
     *   /ALTER TABLE `(.+?)`(.*?)ADD PRIMARY KEY \(`(.+?)`\)/s
     *
     * Regex de FOREIGN KEY:
     *   /ALTER TABLE `([^`]+)`\s+ADD CONSTRAINT `[^`]+`\s+FOREIGN KEY
     *    \(`([^`]+)`\)\s+REFERENCES `([^`]+)` \(`([^`]+)`\)/
     */
    private function processarTabelas(): void
    {
        $hostMatches = [];
        $bancoMatches = [];

        // Cabecalho do dump: -- Host: localhost
        preg_match('/--\s*Host:\s*([^\r\n]+)/', $this->conteudo, $hostMatches);
        // Banco de dados: `nome_do_banco`
        preg_match('/Banco de dados:\s*`([^`]+)`/', $this->conteudo, $bancoMatches);

        $this->host  = $hostMatches[1]  ?? 'localhost';
        $this->banco = $bancoMatches[1] ?? '';

        // 1) Captura todas as tabelas
        preg_match_all(
            '/CREATE TABLE\s+`([^`]+)`\s*\((.*?)\)\s*ENGINE=/s',
            $this->conteudo,
            $matches,
            PREG_SET_ORDER
        );

        foreach ($matches as $match) {
            $nomeTabela = $match[1];
            $camposTexto = $match[2];
            $this->tabelas[$nomeTabela] = [];

            // Cada coluna ocupa uma linha iniciada por "`nome` tipo ..."
            $linhas = explode("\n", $camposTexto);
            foreach ($linhas as $linha) {
                $linha = trim($linha);
                // Ignora linhas que nao comecam com crase (PRIMARY KEY, KEY, etc.)
                if (strpos($linha, '`') !== 0) continue;

                // Captura `nome_coluna` tipo
                preg_match('/`(.+?)`\s+([a-zA-Z0-9()]+)/', $linha, $campo);
                $nomeCampo = $campo[1] ?? '';
                $tipoCampo = $campo[2] ?? '';
                if ($nomeCampo === '') continue;

                $nullable = !str_contains($linha, 'NOT NULL');
                $this->tabelas[$nomeTabela][$nomeCampo] = [
                    'tipo'     => $tipoCampo,
                    'primary'  => false,
                    'nullable' => $nullable
                ];
            }
        }

        // 2) Captura PRIMARY KEYs via ALTER TABLE
        preg_match_all(
            '/ALTER TABLE `(.+?)`(.*?)ADD PRIMARY KEY \(`(.+?)`\)/s',
            $this->conteudo,
            $primaryMatches,
            PREG_SET_ORDER
        );
        foreach ($primaryMatches as $match) {
            $tabela  = $match[1];
            $campoPK = $match[3];
            if (isset($this->tabelas[$tabela][$campoPK])) {
                $this->tabelas[$tabela][$campoPK]['primary'] = true;
            }
        }

        // 3) Captura FOREIGN KEYs
        preg_match_all(
            '/ALTER TABLE `([^`]+)`\s+ADD CONSTRAINT `[^`]+`\s+FOREIGN KEY \(`([^`]+)`\)\s+REFERENCES `([^`]+)` \(`([^`]+)`\)/',
            $this->conteudo,
            $fkMatches,
            PREG_SET_ORDER
        );
        foreach ($fkMatches as $fk) {
            $tabela     = $fk[1];
            $coluna     = $fk[2];
            $tabelaRef  = $fk[3];
            $colunaRef  = $fk[4];
            $this->relacionamentos[$tabela][$coluna] = [
                'tabela' => $tabelaRef,
                'coluna' => $colunaRef
            ];
        }
    }

    public function getRelacionamentos(): array { return $this->relacionamentos; }

    /**
     * Inicia a geracao do MVC.
     * - Valida extensao .sql
     * - Move o upload para sql/
     * - Processa o dump
     * - Gera as camadas
     * - Compacta o sistema em .zip e exibe link de download
     */
    function iniciar(): void
    {
        $arquivo = $_FILES['arquivo'] ?? null;
        if (!$arquivo || $arquivo['error'] !== UPLOAD_ERR_OK) {
            header("location: index.php?erro=1");
            exit;
        }

        $arquivo_tmp = $arquivo['tmp_name'];
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        if ($extensao != "sql") {
            header("location: index.php?erro=0");
            exit;
        }

        $diretorioSql = __DIR__ . DIRECTORY_SEPARATOR . "sql";
        if (!is_dir($diretorioSql)) {
            mkdir($diretorioSql, 0777, true);
        }
        $destino = $diretorioSql . DIRECTORY_SEPARATOR . $arquivo['name'];
        move_uploaded_file($arquivo_tmp, $destino);

        $this->receberArquivoSQL($destino);

        $relacionamentos = $this->getRelacionamentos();

        // Gera todas as camadas do sistema MVC
        new ClassesModel($this->tabelas, $relacionamentos);
        new ClassesView($this->tabelas, $relacionamentos);
        new ClassesControl($this->tabelas, $relacionamentos);
        new ClassesDAO($this->tabelas, $relacionamentos);
        new ClassesConexao($this->banco, $this->host);

        // Compacta o sistema em ZIP
        $zipPath = $this->compactarSistema();

        // Exibe a tela de sucesso com link para download
        $this->exibirSucesso($zipPath, $this->banco);
    }

    /**
     * Compacta a pasta "sistema/" em um .zip na raiz do framework.
     * Retorna o caminho relativo do zip para uso no link de download.
     */
    private function compactarSistema(): string
    {
        $origem = __DIR__ . DIRECTORY_SEPARATOR . "sistema";
        $zipNome = "sistema_mvc_" . date("Ymd_His") . ".zip";
        $zipPath = __DIR__ . DIRECTORY_SEPARATOR . $zipNome;

        if (!class_exists('ZipArchive')) {
            // Fallback: sem extensao zip, retorna caminho vazio
            return '';
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return '';
        }

        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($origem, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($it as $file) {
            if (!$file->isDir()) {
                $real = $file->getRealPath();
                $rel  = substr($real, strlen($origem) + 1);
                $zip->addFile($real, $rel);
            }
        }
        $zip->close();

        return $zipNome;
    }

    /**
     * Renderiza a tela de sucesso (HTML) com link de download do ZIP.
     */
    private function exibirSucesso(string $zipNome, string $banco): void
    {
        $link = $zipNome !== ''
            ? "<a class='btn-download' href='$zipNome' download>&#11015; Baixar sistema (.zip)</a>"
            : "<p style='color:#b91c1c'>Extensao ZipArchive indisponivel no servidor.</p>";

        $tabelas = count($this->tabelas);
        $rels    = count($this->relacionamentos);

        echo <<<HTML
        <!doctype html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <title>Sistema gerado com sucesso</title>
            <link rel="stylesheet" type="text/css" href="estilo.css">
        </head>
        <body>
            <div class="container-sucesso">
                <h1>&#9989; Sistema criado com sucesso!</h1>
                <p class="subtitulo">Banco: <strong>{$banco}</strong></p>
                <ul class="info">
                    <li>Tabelas processadas: <strong>{$tabelas}</strong></li>
                    <li>Relacionamentos (FKs): <strong>{$rels}</strong></li>
                    <li>Pasta gerada: <code>sistema/</code></li>
                </ul>
                {$link}
                <a class="btn-voltar" href="index.php">Voltar ao inicio</a>
            </div>
        </body>
        </html>
        HTML;
    }
}

(new LeitorSQL())->iniciar();
