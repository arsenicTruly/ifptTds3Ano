<?php
// Exibe erros para depuracao
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
    private array $tabelas = [];
    private array $relacionamentos = [];
    private string $banco = '';
    private string $host = '';

    // Le o arquivo SQL e dispara o processamento
    public function receberArquivoSQL(string $arquivo)
    {
        if (!file_exists($arquivo)) {
            throw new Exception("Arquivo nao encontrado.");
        }
        $this->conteudo = file_get_contents($arquivo);
        $this->processarTabelas();
    }

    // Extrai tabelas, colunas, PKs e FKs do dump
    private function processarTabelas(): void
    {
        $hostMatches = [];
        $bancoMatches = [];

        preg_match('/--\s*Host:\s*([^\r\n]+)/', $this->conteudo, $hostMatches);
        preg_match('/Banco de dados:\s*`([^`]+)`/', $this->conteudo, $bancoMatches);

        $this->host = $hostMatches[1] ?? 'localhost';
        $this->banco = $bancoMatches[1] ?? '';

        // Captura CREATE TABLE
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
            $linhas = explode("\n", $camposTexto);

            foreach ($linhas as $linha) {
                $linha = trim($linha);
                if (strpos($linha, '`') !== 0) continue;
                preg_match('/`(.+?)`\s+([a-zA-Z0-9()]+)/', $linha, $campo);
                $nomeCampo = $campo[1] ?? '';
                $tipoCampo = $campo[2] ?? '';
                if ($nomeCampo === '') continue;
                $nullable = !str_contains($linha, 'NOT NULL');
                $this->tabelas[$nomeTabela][$nomeCampo] = [
                    'tipo' => $tipoCampo,
                    'primary' => false,
                    'nullable' => $nullable
                ];
            }
        }

        // Captura PRIMARY KEY
        preg_match_all(
            '/ALTER TABLE `(.+?)`(.*?)ADD PRIMARY KEY \(`(.+?)`\)/s',
            $this->conteudo,
            $primaryMatches,
            PREG_SET_ORDER
        );
        foreach ($primaryMatches as $match) {
            $tabela = $match[1];
            $campoPK = $match[3];
            if (isset($this->tabelas[$tabela][$campoPK])) {
                $this->tabelas[$tabela][$campoPK]['primary'] = true;
            }
        }

        // Captura FOREIGN KEY
        preg_match_all(
            '/ALTER TABLE `([^`]+)`\s+ADD CONSTRAINT `[^`]+`\s+FOREIGN KEY \(`([^`]+)`\)\s+REFERENCES `([^`]+)` \(`([^`]+)`\)/',
            $this->conteudo,
            $fkMatches,
            PREG_SET_ORDER
        );
        foreach ($fkMatches as $fk) {
            $tabela = $fk[1];
            $coluna = $fk[2];
            $tabelaRef = $fk[3];
            $colunaRef = $fk[4];
            $this->relacionamentos[$tabela][$coluna] = [
                'tabela' => $tabelaRef,
                'coluna' => $colunaRef
            ];
        }
    }

    public function getRelacionamentos(): array
    {
        return $this->relacionamentos;
    }

    // Inicia a geracao do MVC
    function iniciar(): void
    {
        $arquivo = $_FILES['arquivo'];
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

        // Gera todas as camadas
        new ClassesModel($this->tabelas, $relacionamentos);
        new ClassesView($this->tabelas, $relacionamentos);
        new ClassesControl($this->tabelas, $relacionamentos);
        new ClassesDAO($this->tabelas, $relacionamentos);
        new ClassesConexao($this->banco, $this->host);

        echo "Processamento concluido com sucesso!";
    }
}
(new LeitorSQL())->iniciar();
