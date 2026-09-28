<?php
require_once ("utils.php");

class ClassesControl{
    private array $entidades;
    private array $relacionamentos;
    private string $caminho = "sistema/control/";

    function __construct(array $e, array $rel = []) {
       if (!is_dir($this->caminho)) {
           mkdir($this->caminho, 0777, true);
        }
        $this->entidades = $e;
        $this->relacionamentos = $rel;
        $this->criaClasse();
    }

    function criaClasse() {
        $util = new Utils();
        foreach (array_keys($this->entidades) as $entidade) {
            $listaAtributos = $this->entidades[$entidade];
            $instancia = "";
            $pk = null;

            foreach ($listaAtributos as $key => $atributo) {
                if ($atributo["primary"]) {
                    $pk = $key;
                }

                $tipoPHP = $util->converterTipoPHP($atributo["tipo"]);
                $nullable = $atributo["nullable"] ?? false;
                $isPrimary = $atributo["primary"] ?? false;

                // Tratamento por tipo, preservando PK e valores nulos corretamente
                if ($tipoPHP === 'int') {
                    if ($isPrimary) {
                        // PK: NUNCA sobrescreve para 0. Vazio/ausente vira null.
                        $instancia .= "\$valor_{$key} = (isset(\$_POST[\"$key\"]) && \$_POST[\"$key\"] !== '') ? (int)\$_POST[\"$key\"] : null;\n\t";
                    } elseif ($nullable) {
                        $instancia .= "\$valor_{$key} = \$_POST[\"$key\"] ?? null;\n\t";
                        $instancia .= "if (\$valor_{$key} === '' || \$valor_{$key} === '0') { \$valor_{$key} = null; } else { \$valor_{$key} = (int)\$valor_{$key}; }\n\t";
                    } else {
                        $instancia .= "\$valor_{$key} = \$_POST[\"$key\"] ?? 0;\n\t";
                        $instancia .= "if (\$valor_{$key} === '') { \$valor_{$key} = 0; } else { \$valor_{$key} = (int)\$valor_{$key}; }\n\t";
                    }
                    $instancia .= "\$this->obj->set" . ucfirst($key) . "(\$valor_{$key});\n\t";
                } elseif ($tipoPHP === 'float') {
                    $instancia .= "\$valor_{$key} = \$_POST[\"$key\"] ?? null;\n\t";
                    $instancia .= "if (\$valor_{$key} === '' ) { \$valor_{$key} = null; } elseif (\$valor_{$key} !== null) { \$valor_{$key} = (float)\$valor_{$key}; }\n\t";
                    $instancia .= "\$this->obj->set" . ucfirst($key) . "(\$valor_{$key});\n\t";
                } elseif ($tipoPHP === 'bool') {
                    $instancia .= "\$valor_{$key} = isset(\$_POST[\"$key\"]) ? (bool)\$_POST[\"$key\"] : false;\n\t";
                    $instancia .= "\$this->obj->set" . ucfirst($key) . "(\$valor_{$key});\n\t";
                } else {
                    // string / date / mixed
                    $instancia .= "\$valor_{$key} = \$_POST[\"$key\"] ?? null;\n\t";
                    $instancia .= "if (\$valor_{$key} === '') { \$valor_{$key} = null; }\n\t";
                    $instancia .= "\$this->obj->set" . ucfirst($key) . "(\$valor_{$key});\n\t";
                }
            }

            $pkName = $pk ?? 'id';
            $nomeClasse = ucfirst($entidade);

            $conteudo = <<<CLASS
            <?PHP
            require_once('../model/$entidade.php');
            require_once('../dao/{$entidade}DAO.php');

            class {$nomeClasse}Control {
               private \$obj;
               private \$dao;
               private \$acao;

               public function __construct() {
                   \$this->obj = new {$nomeClasse}();
                   \$this->dao = new {$nomeClasse}DAO();
                   \$this->acao = (int)(\$_REQUEST["acao"] ?? 0);
                   \$this->executaAcao();
               }

               public function executaAcao() {
                   // Acoes que recebem dados do formulario (1=inserir, 2=alterar, 3=excluir)
                   if (in_array(\$this->acao, [1, 2, 3], true)) {
                       \$this->prepararObjeto();
                   }

                   // Validacao apenas em insercao e alteracao
                   if (in_array(\$this->acao, [1, 2], true)) {
                       \$erros = \$this->obj->validar();
                       if (!empty(\$erros)) {
                           if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
                           \$_SESSION['erros'] = \$erros;
                           \$_SESSION['dados'] = \$_POST;
                           \$id = \$_POST['{$pkName}'] ?? '';
                           \$url = "../control/{$entidade}Control.php?acao=5" . (\$id !== '' ? "&id=" . urlencode(\$id) : "");
                           header("Location: " . \$url);
                           exit;
                       }
                   }

                   switch(\$this->acao) {
                       case 1: // Inserir
                           try {
                               if (\$this->dao->inserir(\$this->obj)) {
                                   header("Location: ../control/{$entidade}Control.php?acao=4&msg=" . urlencode("Inserido com sucesso"));
                               } else {
                                   header("Location: ../control/{$entidade}Control.php?acao=5&erro=" . urlencode("Erro ao inserir"));
                               }
                           } catch (Throwable \$e) {
                               header("Location: ../control/{$entidade}Control.php?acao=5&erro=" . urlencode(\$e->getMessage()));
                           }
                           exit;

                       case 2: // Alterar
                           \$id = \$_POST['{$pkName}'] ?? null;
                           if (!\$id) {
                               header("Location: ../control/{$entidade}Control.php?acao=4&erro=" . urlencode("ID nao informado para edicao"));
                               exit;
                           }
                           try {
                               if (\$this->dao->alterar(\$this->obj)) {
                                   header("Location: ../control/{$entidade}Control.php?acao=4&msg=" . urlencode("Alterado com sucesso"));
                               } else {
                                   header("Location: ../control/{$entidade}Control.php?acao=5&id=" . urlencode(\$id) . "&erro=" . urlencode("Nenhuma linha alterada"));
                               }
                           } catch (Throwable \$e) {
                               header("Location: ../control/{$entidade}Control.php?acao=5&id=" . urlencode(\$id) . "&erro=" . urlencode(\$e->getMessage()));
                           }
                           exit;

                       case 3: // Excluir
                           \$id = \$_POST["{$pkName}"] ?? \$_GET["{$pkName}"] ?? null;
                           if (\$id) {
                               try {
                                   if (\$this->dao->excluir((int)\$id)) {
                                       header("Location: ../control/{$entidade}Control.php?acao=4&msg=" . urlencode("Excluido com sucesso"));
                                   } else {
                                       header("Location: ../control/{$entidade}Control.php?acao=4&erro=" . urlencode("Erro ao excluir"));
                                   }
                               } catch (Throwable \$e) {
                                   header("Location: ../control/{$entidade}Control.php?acao=4&erro=" . urlencode(\$e->getMessage()));
                               }
                           } else {
                               header("Location: ../control/{$entidade}Control.php?acao=4&erro=" . urlencode("ID nao informado"));
                           }
                           exit;

                       case 4: // Listar
                           \$dados = \$this->dao->listar();
                           include(__DIR__ . '/../view/listagem_{$entidade}.php');
                           break;

                       case 5: // Formulario (novo ou edicao)
                           \$id = \$_GET['id'] ?? null;
                           \$dados = [];
                           \$erros = [];

                           if (\$id) {
                               \$obj = \$this->dao->buscarPorId((int)\$id);
                               if (\$obj) {
                                   \$reflection = new ReflectionClass(\$obj);
                                   foreach (\$reflection->getProperties() as \$prop) {
                                       \$nome = \$prop->getName();
                                       \$metodo = 'get' . ucfirst(\$nome);
                                       if (method_exists(\$obj, \$metodo)) {
                                           \$dados[\$nome] = \$obj->\$metodo();
                                       }
                                   }
                               } else {
                                   \$erros['geral'] = "Registro nao encontrado.";
                               }
                           }

                           if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
                           if (isset(\$_SESSION['erros'])) {
                               \$erros = \$_SESSION['erros'];
                               if (isset(\$_SESSION['dados'])) {
                                   \$dados = array_merge(\$dados, \$_SESSION['dados']);
                               }
                               unset(\$_SESSION['erros'], \$_SESSION['dados']);
                           }

                           include(__DIR__ . '/../view/form_{$entidade}.php');
                           break;

                       default:
                           break;
                   }
               }

               public function prepararObjeto() {
                  $instancia
               }
            }

            new {$nomeClasse}Control;
            ?>
            CLASS;
            file_put_contents("{$this->caminho}{$entidade}Control.php", $conteudo);
        }
    }
}
