<?php
require_once ("utils.php");

class ClassesView{
    private array $entidades;
    private array $relacionamentos;
    private string $caminho = "sistema/view/";

    function __construct(array $e, array $rel = []) {
        if (!is_dir($this->caminho)) {
            mkdir($this->caminho, 0777, true);
        }
        $this->entidades = $e;
        $this->relacionamentos = $rel;
        $this->criaFormulario();
        $this->criaListagem();
        $this->criaCSS();
    }

    private function criaCSS() {
        $css = <<<CSS
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        h2 { color: #343a40; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 25px; }
        .form-label { font-weight: 600; }
        .btn { margin-right: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #007bff; color: white; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #dee2e6; }
        tr:hover { background: #f1f3f5; }
        .alert { padding: 12px 20px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; border-color: #c3e6cb; color: #155724; }
        .alert-danger { background: #f8d7da; border-color: #f5c6cb; color: #721c24; }
        .is-invalid { border-color: #dc3545; }
        .invalid-feedback { color: #dc3545; font-size: 0.875em; }
        CSS;
        file_put_contents("{$this->caminho}style.css", $css);
    }

    /**
     * Gera o formulário de cadastro/edição.
     * A View NAO acessa DAO nem Model: recebe $dados e $erros prontos do Control.
     */
    function criaFormulario() {
        $util = new Utils();

        foreach (array_keys($this->entidades) as $entidade) {
            $listaAtributos = $this->entidades[$entidade];
            $campos = "";
            $pk = null;
            foreach ($listaAtributos as $key => $atributo) {
                if ($atributo["primary"]) {
                    $pk = $key;
                    continue;
                }
                $tipoForm = $util->converterTipoPHPForm($atributo["tipo"]);
                $campos .= "<div class=\"mb-3\">";
                $campos .= "<label for=\"$key\" class=\"form-label\">$key</label>";
                $campos .= "<input type='{$tipoForm}' name='{$key}' id='{$key}' class=\"form-control <?php echo isset(\$erros['$key']) ? 'is-invalid' : ''; ?>\" value=\"<?php echo isset(\$dados['$key']) ? htmlspecialchars((string)\$dados['$key']) : ''; ?>\">";
                $campos .= "<?php if (isset(\$erros['$key'])): ?><div class=\"invalid-feedback\"><?= \$erros['$key'] ?></div><?php endif; ?>";
                $campos .= "</div>\n\t";
            }

            $pkName = $pk ?? 'id';

            $conteudo = <<<FORM
            <html>
                <head>
                    <title>Cadastro - $entidade</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link rel="stylesheet" type="text/css" href="style.css">
                </head>
                <body>
                <div class="container mt-5">
                <h2 class="mb-4">Cadastro - $entidade</h2>
                <?php
                    // \$dados e \$erros sao populados pelo Control antes do include.
                    if (!isset(\$dados)) \$dados = [];
                    if (!isset(\$erros)) \$erros = [];

                    if (isset(\$_GET['msg'])) {
                        echo "<div class='alert alert-success'>".htmlspecialchars(\$_GET['msg'])."</div>";
                    }
                    if (isset(\$_GET['erro'])) {
                        echo "<div class='alert alert-danger'>".htmlspecialchars(\$_GET['erro'])."</div>";
                    }
                    foreach (\$erros as \$campo => \$msg) {
                        if (\$campo === 'geral') {
                            echo "<div class='alert alert-danger'>".htmlspecialchars(\$msg)."</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Erro em '{\$campo}': {\$msg}</div>";
                        }
                    }
                    \$emEdicao = isset(\$dados['$pkName']) && \$dados['$pkName'] !== '' && \$dados['$pkName'] !== null;
                ?>
                <form action="../control/{$entidade}Control.php" method="POST">
                    <input type="hidden" name="acao" value="<?php echo \$emEdicao ? 2 : 1; ?>">
                    <?php if (\$emEdicao): ?>
                        <input type="hidden" name="$pkName" value="<?php echo htmlspecialchars((string)\$dados['$pkName']); ?>">
                    <?php endif; ?>
                    $campos
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="../control/{$entidade}Control.php?acao=4" class="btn btn-secondary">Listar $entidade</a>
                </form>
                </div>
                </body>
            </html>
            FORM;
            file_put_contents("{$this->caminho}form_" . $entidade . ".php", $conteudo);
        }
    }

    /**
     * Gera a listagem. O Control inclui este arquivo apos \$this->dao->listar().
     * Nome do arquivo padronizado como listagem_{$entidade}.php
     */
    function criaListagem() {
        foreach (array_keys($this->entidades) as $entidade) {
            $listaAtributos = $this->entidades[$entidade];
            $pk = 'id';
            foreach ($listaAtributos as $key => $atributo) {
                if ($atributo["primary"]) { $pk = $key; break; }
            }

            // Cabecalhos (sem a PK)
            $ths = "";
            $tds = "";
            foreach ($listaAtributos as $key => $atributo) {
                if ($atributo["primary"]) continue;
                $ths .= "<th>" . htmlspecialchars($key) . "</th>\n";
                $tds .= "<td><?= htmlspecialchars((string)(\$item->get" . ucfirst($key) . "() ?? '')) ?></td>\n";
            }

            $conteudo = <<<LISTA
            <html>
                <head>
                    <title>Listagem - $entidade</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
                    <link rel="stylesheet" type="text/css" href="style.css">
                </head>
                <body>
                <div class="container mt-5">
                <h2 class="mb-4">Listagem - $entidade</h2>
                <?php
                    if (isset(\$_GET['msg'])) {
                        echo "<div class='alert alert-success'>".htmlspecialchars(\$_GET['msg'])."</div>";
                    }
                    if (isset(\$_GET['erro'])) {
                        echo "<div class='alert alert-danger'>".htmlspecialchars(\$_GET['erro'])."</div>";
                    }
                    \$itens = \$dados ?? [];
                ?>
                <a href="../control/{$entidade}Control.php?acao=5" class="btn btn-success mb-3">Novo</a>
                <table>
                    <thead>
                        <tr>
                            $ths
                            <th>Acoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty(\$itens)): ?>
                            <tr><td colspan="99">Nenhum registro encontrado.</td></tr>
                        <?php else: ?>
                            <?php foreach (\$itens as \$item): ?>
                                <tr>
                                    $tds
                                    <td>
                                        <a class="btn btn-sm btn-warning" href="../control/{$entidade}Control.php?acao=5&id=<?= (int)\$item->get" . ucfirst($pk) . "() ?>">Editar</a>
                                        <a class="btn btn-sm btn-danger" href="../control/{$entidade}Control.php?acao=3&{$pk}=<?= (int)\$item->get" . ucfirst($pk) . "() ?>" onclick="return confirm('Excluir este registro?');">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                </div>
                </body>
            </html>
            LISTA;
            file_put_contents("{$this->caminho}listagem_" . $entidade . ".php", $conteudo);
        }
    }

    private function obterCampoDescricao(string $tabela): string {
        $atributos = $this->entidades[$tabela] ?? [];
        foreach (['nome', 'descricao', 'titulo'] as $candidato) {
            if (isset($atributos[$candidato])) {
                return $candidato;
            }
        }
        foreach ($atributos as $key => $atributo) {
            if (!$atributo['primary']) {
                return $key;
            }
        }
        return 'id';
    }
}
