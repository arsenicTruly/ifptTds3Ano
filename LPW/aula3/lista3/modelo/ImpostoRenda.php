<?php
class ImpostoRenda {
    
    private float $faixa2 = 3036.01;
    private float $faixa3 = 3553.32;
    private float $faixa4 = 4688.86;
    private float $faixa5 = 5830.85;

    private float $aliquotaFaixa2 = 7.5;
    private float $aliquotaFaixa3 = 15.0;
    private float $aliquotaFaixa4 = 22.5;
    private float $aliquotaFaixa5 = 27.5;

    private float $impostoFaixa2 = 38.80;
    private float $impostoFaixa3 = 170.33;
    private float $impostoFaixa4 = 256.95;
    private float $impostoFaixa5 = 596.52;
    
    private float $renda;
    private float $imposto;
    private float $aliquotaEfetiva;
    private array $detalhesFaixas;
    
    public function __construct(float $renda) {
        $this->renda = $renda;
        $this->imposto = 0;
        $this->aliquotaEfetiva = 0;
        $this->detalhesFaixas = [];
        $this->calcularImposto();
    }
    
    private function calcularImposto(): void {
        $renda = $this->renda;
        $this->imposto = 0;
        
        if ($renda > $this->faixa2) {
            $this->aliquotaEfetiva += $this->aliquotaFaixa2;
            $this->imposto += $this->impostoFaixa2;
            array_push($this->detalhesFaixas, $this->aliquotaFaixa2);
        }
        if ($renda > $this->faixa3) {
            $this->aliquotaEfetiva += $this->aliquotaFaixa3;
            $this->imposto += $this->impostoFaixa3;
            array_push($this->detalhesFaixas, $this->aliquotaFaixa3);
        }
        if ($renda > $this->faixa4) {
            $this->aliquotaEfetiva += $this->aliquotaFaixa4;
            $this->imposto += $this->impostoFaixa4;
            array_push($this->detalhesFaixas, $this->aliquotaFaixa4);
        }
        if ($renda > $this->faixa5) {
            $this->aliquotaEfetiva += $this->aliquotaFaixa5;
            $this->imposto += $this->impostoFaixa5;
            array_push($this->detalhesFaixas, $this->aliquotaFaixa5);
        }
    }
    
    public function formatarMoeda(float $valor): string {
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }
    
    //getters e setters
    

        /**
         * Get the value of faixa2
         */
        public function getFaixa2(): float
        {
            return $this->faixa2;
        }

        /**
         * Set the value of faixa2
         */
        public function setFaixa2(float $faixa2): self
        {
            $this->faixa2 = $faixa2;

            return $this;
        }

        /**
         * Get the value of faixa3
         */
        public function getFaixa3(): float
        {
            return $this->faixa3;
        }

        /**
         * Set the value of faixa3
         */
        public function setFaixa3(float $faixa3): self
        {
            $this->faixa3 = $faixa3;

            return $this;
        }

        /**
         * Get the value of faixa4
         */
        public function getFaixa4(): float
        {
            return $this->faixa4;
        }

        /**
         * Set the value of faixa4
         */
        public function setFaixa4(float $faixa4): self
        {
            $this->faixa4 = $faixa4;

            return $this;
        }

        /**
         * Get the value of faixa5
         */
        public function getFaixa5(): float
        {
            return $this->faixa5;
        }

        /**
         * Set the value of faixa5
         */
        public function setFaixa5(float $faixa5): self
        {
            $this->faixa5 = $faixa5;

            return $this;
        }

        /**
         * Get the value of aliquotaFaixa2
         */
        public function getAliquotaFaixa2(): float
        {
            return $this->aliquotaFaixa2;
        }

        /**
         * Set the value of aliquotaFaixa2
         */
        public function setAliquotaFaixa2(float $aliquotaFaixa2): self
        {
            $this->aliquotaFaixa2 = $aliquotaFaixa2;

            return $this;
        }

        /**
         * Get the value of aliquotaFaixa3
         */
        public function getAliquotaFaixa3(): float
        {
            return $this->aliquotaFaixa3;
        }

        /**
         * Set the value of aliquotaFaixa3
         */
        public function setAliquotaFaixa3(float $aliquotaFaixa3): self
        {
            $this->aliquotaFaixa3 = $aliquotaFaixa3;

            return $this;
        }

        /**
         * Get the value of aliquotaFaixa4
         */
        public function getAliquotaFaixa4(): float
        {
            return $this->aliquotaFaixa4;
        }

        /**
         * Set the value of aliquotaFaixa4
         */
        public function setAliquotaFaixa4(float $aliquotaFaixa4): self
        {
            $this->aliquotaFaixa4 = $aliquotaFaixa4;

            return $this;
        }

        /**
         * Get the value of aliquotaFaixa5
         */
        public function getAliquotaFaixa5(): float
        {
            return $this->aliquotaFaixa5;
        }

        /**
         * Set the value of aliquotaFaixa5
         */
        public function setAliquotaFaixa5(float $aliquotaFaixa5): self
        {
            $this->aliquotaFaixa5 = $aliquotaFaixa5;

            return $this;
        }

        /**
         * Get the value of impostoFaixa2
         */
        public function getImpostoFaixa2(): float
        {
            return $this->impostoFaixa2;
        }

        /**
         * Set the value of impostoFaixa2
         */
        public function setImpostoFaixa2(float $impostoFaixa2): self
        {
            $this->impostoFaixa2 = $impostoFaixa2;

            return $this;
        }

        /**
         * Get the value of impostoFaixa3
         */
        public function getImpostoFaixa3(): float
        {
            return $this->impostoFaixa3;
        }

        /**
         * Set the value of impostoFaixa3
         */
        public function setImpostoFaixa3(float $impostoFaixa3): self
        {
            $this->impostoFaixa3 = $impostoFaixa3;

            return $this;
        }

        /**
         * Get the value of impostoFaixa4
         */
        public function getImpostoFaixa4(): float
        {
            return $this->impostoFaixa4;
        }

        /**
         * Set the value of impostoFaixa4
         */
        public function setImpostoFaixa4(float $impostoFaixa4): self
        {
            $this->impostoFaixa4 = $impostoFaixa4;

            return $this;
        }

        /**
         * Get the value of impostoFaixa5
         */
        public function getImpostoFaixa5(): float
        {
            return $this->impostoFaixa5;
        }

        /**
         * Set the value of impostoFaixa5
         */
        public function setImpostoFaixa5(float $impostoFaixa5): self
        {
            $this->impostoFaixa5 = $impostoFaixa5;

            return $this;
        }

        /**
         * Get the value of renda
         */
        public function getRenda(): float
        {
            return $this->renda;
        }

        /**
         * Set the value of renda
         */
        public function setRenda(float $renda): self
        {
            $this->renda = $renda;

            return $this;
        }

        /**
         * Get the value of imposto
         */
        public function getImposto(): float
        {
            return $this->imposto;
        }

        /**
         * Set the value of imposto
         */
        public function setImposto(float $imposto): self
        {
            $this->imposto = $imposto;

            return $this;
        }

        /**
         * Get the value of aliquotaEfetiva
         */
        public function getAliquotaEfetiva(): float
        {
            return $this->aliquotaEfetiva;
        }

        /**
         * Set the value of aliquotaEfetiva
         */
        public function setAliquotaEfetiva(float $aliquotaEfetiva): self
        {
            $this->aliquotaEfetiva = $aliquotaEfetiva;

            return $this;
        }

        /**
         * Get the value of detalhesFaixas
         */
        public function getDetalhesFaixas(): array
        {
            return $this->detalhesFaixas;
        }

        /**
         * Set the value of detalhesFaixas
         */
        public function setDetalhesFaixas(array $detalhesFaixas): self
        {
            $this->detalhesFaixas = $detalhesFaixas;

            return $this;
        }
}
?>