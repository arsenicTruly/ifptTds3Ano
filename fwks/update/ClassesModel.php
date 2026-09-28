<?php
require_once ("utils.php");

class ClassesModel{
    private array $entidades;
    private string $caminho = "sistema/model/";
    private array $relacionamentos;

    function __construct(array $e, array $rel = []) {
        if (!is_dir($this->caminho)) {
            mkdir($this->caminho, 0777, true);
        }
        $this->entidades = $e;
        $this->relacionamentos = $rel;
        $this->criaClasses();
    }

    function criaClasses() {
        $util = new Utils();
        foreach (array_keys($this->entidades) as $entidade) {
            $listaAtributos = $this->entidades[$entidade];
            $attr = "";
            $metodos = "";
            $validacao = "";
            $construtorParams = "";
            $construtorBody = "";

            foreach ($listaAtributos as $key => $atributo) {
                $tipoPHP = $util->converterTipoPHP($atributo["tipo"]);
                $construtorParams .= "?$tipoPHP \$$key = null, ";
                $construtorBody .= "        \$this->$key = \$$key;\n";
            }
            $construtorParams = rtrim($construtorParams, ", ");

            foreach ($listaAtributos as $key => $atributo) {
                $tipoPHP = $util->converterTipoPHP($atributo["tipo"]);
                $tipoDecl = "?" . $tipoPHP;
                $attr .= "   private " . $tipoDecl . " $" . $key . ";\n";

                $metodos .= "function get" . ucfirst($key) . "() : " . $tipoDecl . "{\n";
                $metodos .= "return \$this->" . $key . ";\n }\n";

                $metodos .= "function set" . ucfirst($key) . "($tipoDecl \$arg){\n";
                $metodos .= " \$this->" . $key . "=\$arg;\n }\n";
            }

            foreach ($listaAtributos as $key => $atributo) {
                $tipoPHP = $util->converterTipoPHP($atributo["tipo"]);
                $nullable = $atributo["nullable"] ?? false;
                $isNullable = $nullable ? 'true' : 'false';
                $validacao .= "            '$key' => ['nullable' => $isNullable, 'type' => '$tipoPHP'],\n";
            }
            $validacao = rtrim($validacao, ",\n");

            $magico = "";
            foreach ($listaAtributos as $key => $atributo) {
                if(!$atributo["primary"]) {
                    $magico .= " \"$key: \" . (\$this->$key ?? 'N/A') . \"<br>\".\n";
                }
            }
            $magico = substr($magico, 0, -2);

            $nomeClasse = ucfirst($entidade);
            $conteudo = <<<CLASS
            <?php
            class $nomeClasse {
            $attr
            function __construct($construtorParams){
            $construtorBody
            }
            $metodos
            public function validar(): array
            {
                \$erros = [];
                \$regras = [
                    $validacao
                ];

                foreach (\$regras as \$campo => \$regra) {
                    \$valor = \$this->\$campo;
                    \$isNullable = \$regra['nullable'];
                    \$tipo = \$regra['type'];

                    if (!\$isNullable) {
                        \$vazio = (\$valor === null || \$valor === '');
                        if (\$tipo === 'int') {
                            \$vazio = \$vazio || (\$valor === 0);
                        }
                        if (\$vazio) {
                            \$erros[\$campo] = "O campo '\$campo' é obrigatorio.";
                            continue;
                        }
                    }

                    if (\$valor !== null && \$valor !== '') {
                        switch (\$tipo) {
                            case 'int':
                                if (filter_var(\$valor, FILTER_VALIDATE_INT) === false) {
                                    \$erros[\$campo] = "O campo '\$campo' deve ser um numero inteiro.";
                                }
                                break;
                            case 'float':
                                if (!is_numeric(\$valor)) {
                                    \$erros[\$campo] = "O campo '\$campo' deve ser um numero.";
                                }
                                break;
                            case 'string':
                                if (\$campo === 'email' && !filter_var(\$valor, FILTER_VALIDATE_EMAIL)) {
                                    \$erros[\$campo] = "O campo 'email' deve ser um endereco de e-mail valido.";
                                }
                                break;
                        }
                    }
                }
                return \$erros;
            }

            function __toString(){
            return $magico;
            }
            }
            CLASS;
            file_put_contents("$this->caminho" . $entidade . ".php", $conteudo);
        }
    }
}
