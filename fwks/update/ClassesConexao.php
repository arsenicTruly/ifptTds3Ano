<?php
/**
 * ClassesConexao - Gera a classe Conexao.php com as credenciais do dump.
 * O usuario pode editar o arquivo gerado para ajustar usuario/senha.
 */
class ClassesConexao {
    private $caminho = "sistema/model/";

    function __construct(string $banco, string $host) {
        $this->criaClasse($banco, $host);
    }

    function criaClasse(string $banco, string $host): bool {
        // Remove porta se vier "localhost:3306"
        $porta = 3306;
        if (str_contains($host, ':')) {
            [$host, $porta] = explode(':', $host);
        }

        $conteudo = <<<CLASS
        <?php
        /**
         * Conexao - Conexao PDO padrao (root / sem senha).
         * Ajuste as credenciais conforme o ambiente.
         */
        class Conexao{
            public static function conectar(): PDO {
                \$host    = "$host";
                \$porta   = $porta;
                \$banco   = "$banco";
                \$usuario = "root";
                \$senha   = "";

                \$dsn = "mysql:host=\$host;port=\$porta;dbname=\$banco;charset=utf8mb4";
                \$opcoes = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                return new PDO(\$dsn, \$usuario, \$senha, \$opcoes);
            }
        }
        CLASS;
        return file_put_contents("{$this->caminho}Conexao.php", $conteudo);
    }
}
