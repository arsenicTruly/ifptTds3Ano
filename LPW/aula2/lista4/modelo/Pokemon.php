<?php

class Pokemon{
    private string $nome;
    private string $tipo;
    private string $imagem;
    private string $pokepediaPage;

    public function __construct($n, $t, $i, $p){
        $this->nome = $n;
        $this->tipo = $t;
        $this->imagem = $i;
        $this->pokepediaPage = $p;
    }

    public function getRow(){
        print"<tr>";

            print"<td>";
                echo $this->getNome();
            print"</td>";
            print"<td>";
                echo $this->getTipo();
            print"</td>";
            print"<td style='height: 200px; width 200px; overflow: hidden'>";
                echo "<img src=".$this->getImagem().">";
            print"</td>";
            print"<td>";
                echo "<a href='".$this->getPokepediaPage()."'>link</a>";
            print"</td>";

        print"</tr>";
        return;
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
         * Get the value of tipo
         */
        public function getTipo(): string
        {
            return $this->tipo;
        }

        /**
         * Set the value of tipo
         */
        public function setTipo(string $tipo): self
        {
            $this->tipo = $tipo;

            return $this;
        }

        /**
         * Get the value of imagem
         */
        public function getImagem(): string
        {
            return $this->imagem;
        }

        /**
         * Set the value of imagem
         */
        public function setImagem(string $imagem): self
        {
            $this->imagem = $imagem;

            return $this;
        }

        /**
         * Get the value of pokepediaPage
         */
        public function getPokepediaPage(): string
        {
            return $this->pokepediaPage;
        }

        /**
         * Set the value of pokepediaPage
         */
        public function setPokepediaPage(string $pokepediaPage): self
        {
            $this->pokepediaPage = $pokepediaPage;

            return $this;
        }
}