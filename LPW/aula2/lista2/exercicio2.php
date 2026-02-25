<?php

class Presidente {
    private int $numero;
    private string $nome;
    private int $inicio;
    private int $fim;

    public function __construct($num, $nome, $ini, $fim){
        $this->numero = $num;
        $this->nome = $nome;
        $this->inicio = $ini;
        $this->fim = $fim;
    }

    //Getters e Setters
        // Getter e Setter do número
        public function getNumero(): int {
            return $this->numero;
        }

        public function setNumero(int $numero): void {
            $this->numero = $numero;
        }

        // Getter e Setter do nome
        public function getNome(): string {
            return $this->nome;
        }

        public function setNome(string $nome): void {
            $this->nome = $nome;
        }

        // Getter e Setter do início do mandato
        public function getInicio(): int {
            return $this->inicio;
        }

        public function setInicio(int $inicio): void {
            $this->inicio = $inicio;
        }

        // Getter e Setter do fim do mandato
        public function getFim(): int {
            return $this->fim;
        }

        public function setFim(int $fim): void {
            $this->fim = $fim;
        }
}

$lista = array();

$presidente = new Presidente(16, "Eurico Gaspar Dutra", 1946, 1951);
array_push($lista, $presidente);
$presidente = new Presidente(17, "Getulio Vargas", 1951, 1954);
array_push($lista, $presidente);
$presidente = new Presidente(18, "Cafe filho", 1954, 1955);
array_push($lista, $presidente);
$presidente = new Presidente(19, "Carlos Luz", 1955, 1955);
array_push($lista, $presidente);
$presidente = new Presidente(20, "Nereu Ramos", 1955, 1956);
array_push($lista, $presidente);
$presidente = new Presidente(21, "Jucelino Kubistchek", 1956, 1961);
array_push($lista, $presidente);

echo "<table>";
    echo "<tr>";
        echo "<th>Numero</th>";
        echo "<th>Nome</th>";
        echo "<th>Inicio</th>";
        echo "<th>Fim</th>";
    echo "</tr>";
    foreach($lista as $linha => $presidente){
        echo "<tr>";

            for ($i = 0; $i < 4; $i++) {
                    echo "<td>";
                    switch ($i) {
                        case 0: echo $presidente->getNumero(); break;
                        case 1: echo $presidente->getNome(); break;
                        case 2: echo $presidente->getInicio(); break;
                        case 3: echo $presidente->getFim(); break;
                    }
                    echo"</td>";
            }
        echo "</tr>";
    }
echo "</table>"