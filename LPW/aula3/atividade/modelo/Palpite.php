<?php

class Palpite {
    private string $nome;
    private string $imagem;
    private array $numeros;

    public function __construct(string $n, string $i, array $num) {
        $this->nome = $n;
        $this->imagem = $i;
        $this->numeros = $num;
    }

    //getters e setters
        public function getNome(): string {
            return $this->nome;
        }

        public function setNome(string $nome): self {
            $this->nome = $nome;
            return $this;
        }

        public function getImagem(): string {
            return $this->imagem;
        }

        public function setImagem(string $imagem): self {
            $this->imagem = $imagem;
            return $this;
        }

        public function getNumeros(): array {
            return $this->numeros;
        }

        public function setNumeros(array $numeros): self {
            $this->numeros = $numeros;
            return $this;
        }
}
?>