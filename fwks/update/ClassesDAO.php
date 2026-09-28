<?php
require_once("utils.php");

/**
 * Gera as classes DAO com metodos para CRUD.
 * Erros sao propagados via excecoes (PDOException / RuntimeException).
 */
class ClassesDAO
{
    private array $entidades;
    private array $relacionamentos;
    private string $caminho = "sistema/dao/";

    function __construct(array $e, array $rel = [])
    {
        if (!is_dir($this->caminho)) {
            mkdir($this->caminho, 0777, true);
        }
        $this->entidades = $e;
        $this->relacionamentos = $rel;
        $this->criaClasse();
    }

    function criaClasse()
    {
        $util = new Utils();
        foreach (array_keys($this->entidades) as $entidade) {
            $listaAtributos = $this->entidades[$entidade];
            $bindings = "";
            $atributos = "";
            $placeholders = "";
            $i = 1;
            $campoPK = "id";
            foreach ($listaAtributos as $key => $atributo) {
                if ($atributo["primary"]) {
                    $campoPK = $key;
                } else {
                    $bindings .= "\$stmt->bindValue($i,\$obj->get" . ucfirst($key) . "());\n\t\t";
                    $atributos .= $key . ",";
                    $placeholders .= "?,";
                    $i++;
                }
            }
            $atributos = substr($atributos, 0, -1);
            $placeholders = substr($placeholders, 0, -1);
            $camelPK = ucfirst($campoPK);
            $nomeClasse = ucfirst($entidade);

            // SET para UPDATE
            $setClauses = "";
            $bindAlterar = "";
            $j = 1;
            foreach ($listaAtributos as $key => $atributo) {
                if (!$atributo["primary"]) {
                    $setClauses .= "$key = ?, ";
                    $bindAlterar .= "\$stmt->bindValue($j,\$obj->get" . ucfirst($key) . "());\n\t\t";
                    $j++;
                }
            }
            $setClauses = rtrim($setClauses, ", ");
            $bindAlterar .= "\$stmt->bindValue($j,\$obj->get{$camelPK}());\n\t\t";

            // JOINs para FKs na listagem
            $joins = "";
            $selectExtras = "";
            $fkColunas = [];
            if (isset($this->relacionamentos[$entidade])) {
                foreach ($this->relacionamentos[$entidade] as $coluna => $fk) {
                    $tabelaRef = $fk['tabela'];
                    $colunaRef = $fk['coluna'];
                    $campoDesc = $this->obterCampoDescricao($tabelaRef);
                    $alias = $tabelaRef . "_" . $campoDesc;
                    $joins .= "LEFT JOIN {$tabelaRef} ON {$entidade}.{$coluna} = {$tabelaRef}.{$colunaRef} ";
                    $selectExtras .= ", {$tabelaRef}.{$campoDesc} AS {$alias}";
                    $fkColunas[] = $alias;
                }
            }

            $extraColsCode = '';
            if (!empty($fkColunas)) {
                $fkColunasString = "'" . implode("', '", $fkColunas) . "'";
                $extraColsCode = <<<EXTRA
                            \$extraCols = [$fkColunasString];
                            foreach (\$extraCols as \$campoExtra) {
                                if (isset(\$dados[\$campoExtra])) {
                                    \$obj->\$campoExtra = \$dados[\$campoExtra];
                                }
                            }
                EXTRA;
            }

            $conteudo = <<<CLASS
            <?php
            require_once("../model/{$entidade}.php");
            require_once("../model/Conexao.php");

            class {$nomeClasse}DAO
            {
                private PDO \$conexao;

                public function __construct()
                {
                    \$this->conexao = Conexao::conectar();
                }

                public function inserir($nomeClasse \$obj): bool
                {
                    \$sql = "insert into {$entidade} ($atributos) values($placeholders)";
                    \$stmt = \$this->conexao->prepare(\$sql);
                    $bindings
                    return \$stmt->execute();
                }

                public function alterar($nomeClasse \$obj): bool
                {
                    \$metodoGetPK = 'get{$camelPK}';
                    if (!\$obj->\$metodoGetPK()) {
                        throw new InvalidArgumentException("ID nao definido para alteracao.");
                    }
                    \$sql = "update {$entidade} set $setClauses where $campoPK = ?";
                    \$stmt = \$this->conexao->prepare(\$sql);
                    $bindAlterar
                    \$stmt->execute();
                    return \$stmt->rowCount() > 0;
                }

                public function excluir(int \$id): bool
                {
                    \$sql = "delete from {$entidade} where $campoPK = ?";
                    \$stmt = \$this->conexao->prepare(\$sql);
                    \$stmt->bindValue(1, \$id);
                    return \$stmt->execute();
                }

                public function buscarPorId(int \$id): ?$nomeClasse
                {
                    \$sql = "select * from {$entidade} where $campoPK = ?";
                    \$stmt = \$this->conexao->prepare(\$sql);
                    \$stmt->bindValue(1, \$id);
                    \$stmt->execute();
                    \$dados = \$stmt->fetch(PDO::FETCH_ASSOC);
                    return \$dados ? \$this->montarObjeto(\$dados) : null;
                }

                public function listar(): array
                {
                    \$sql = "select {$entidade}.* $selectExtras from {$entidade} $joins";
                    \$stmt = \$this->conexao->prepare(\$sql);
                    \$stmt->execute();
                    \$linhas = \$stmt->fetchAll(PDO::FETCH_ASSOC);
                    \$lista = [];
                    foreach (\$linhas as \$dados) {
                        \$obj = \$this->montarObjeto(\$dados);
                        $extraColsCode
                        \$lista[] = \$obj;
                    }
                    return \$lista;
                }

                /**
                 * Monta o objeto via Reflection, sem depender de construtor posicional.
                 * Preenche propriedades via setters quando existirem.
                 */
                private function montarObjeto(array \$dados): $nomeClasse
                {
                    \$reflection = new ReflectionClass('$nomeClasse');
                    \$obj = \$reflection->newInstanceWithoutConstructor();
                    foreach (\$dados as \$campo => \$valor) {
                        \$metodo = 'set' . ucfirst(\$campo);
                        if (method_exists(\$obj, \$metodo)) {
                            \$obj->\$metodo(\$valor);
                        } else {
                            // Colunas extras de JOIN: propriedade dinamica
                            \$obj->\$campo = \$valor;
                        }
                    }
                    return \$obj;
                }
            }
            ?>
            CLASS;
            file_put_contents("{$this->caminho}{$entidade}DAO.php", $conteudo);
        }
    }

    private function obterCampoDescricao(string $tabela): string
    {
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
