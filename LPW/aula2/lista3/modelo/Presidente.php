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

    public function getLinhaTabela(){
        $linha = "";
        for ($i = 0; $i < 4; $i++) {
                    $linha += "<td>";
                    switch ($i) {
                        case 0: $linha += $this->getNumero(); break;
                        case 1: $linha += $this-getNome(); break;
                        case 2: $linha += $this-getInicio(); break;
                        case 3: $linha += $this->getFim(); break;
                    }
                    $linha +="</td>";
            }
        return $linha;

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
