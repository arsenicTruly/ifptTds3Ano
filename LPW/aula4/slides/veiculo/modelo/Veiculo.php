<?php

class Veiculo{
    private string $modelo;
    private string $marca;
    private string $combustivel;

    public function __construct($m, $ma, $c){
        $this->modelo = $m;
        $this->marca = $ma;
        $this->combustivel = $c;
    }

    public function getCombustivelInteiro(){
        $tipo = $this->combustivel;
        strtolower($tipo);
        switch($tipo){
            case 'a':
                $retorno = "Alcool";
                break;
            case 'g':
                $retorno = "Gasolina";
                break;
            case 'f':
                $retorno = "Flex";
                break;
            default:
                $retorno = "indefinido";
                break;
        }
        return $retorno;
    }

    //getters e setters

        /**
         * Get the value of modelo
         */
        public function getModelo(): string
        {
            return $this->modelo;
        }

        /**
         * Set the value of modelo
         */
        public function setModelo(string $modelo): self
        {
            $this->modelo = $modelo;

            return $this;
        }

        /**
         * Get the value of marca
         */
        public function getMarca(): string
        {
            return $this->marca;
        }

        /**
         * Set the value of marca
         */
        public function setMarca(string $marca): self
        {
            $this->marca = $marca;

            return $this;
        }

        /**
         * Get the value of combustivel
         */
        public function getCombustivel(): string
        {
            return $this->combustivel;
        }

        /**
         * Set the value of combustivel
         */
        public function setCombustivel(string $combustivel): self
        {
            $this->combustivel = $combustivel;

            return $this;
        }
}

?>