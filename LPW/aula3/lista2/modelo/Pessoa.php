<?php

class Pessoa{
    private string $nome;
    private string $sobrenome;
    private int $idade;

    public function __construct($n, $s, $i){
        $this->nome = $n;
        $this->sobrenome = $s;
        $this->idade = $i;
    }

    public function getDados(){
        $dados="Nome Completo: ".$this->nome." ".$this->sobrenome.
            "<br>Idade: ".$this->idade;
        return $dados;
    }

    
    //getters e setters
        /**
         * Get the value of nome
         */
        public function getNome(): string
        {
            return $this->nome;
        }

        /**
         * Set the value of nome
         */
        public function setNome(string $nome): self
        {
            $this->nome = $nome;

            return $this;
        }

        /**
         * Get the value of sobrenome
         */
        public function getSobrenome(): string
        {
            return $this->sobrenome;
        }

        /**
         * Set the value of sobrenome
         */
        public function setSobrenome(string $sobrenome): self
        {
            $this->sobrenome = $sobrenome;

            return $this;
        }

        /**
         * Get the value of idade
         */
        public function getIdade(): int
        {
            return $this->idade;
        }

        /**
         * Set the value of idade
         */
        public function setIdade(int $idade): self
        {
            $this->idade = $idade;

            return $this;
        }
}