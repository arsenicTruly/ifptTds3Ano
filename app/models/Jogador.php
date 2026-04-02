<?php 

namespace app\models;

use DateTimeImmutable;

class Jogador {

    private int $id;
    private string $nome;
    private string $dataNascimento;
    private ?string $nacionalidade;
    private ?float $altura;
    private ?float $peso;
    private ?string $peDominante;
    private ?string $posicao;
    private ?string $time;
    private ?string $imagem;
    private DateTimeImmutable $criadoEm;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

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
     * Get the value of dataNascimento
     */
    public function getDataNascimento(): string
    {
        return $this->dataNascimento;
    }

    /**
     * Set the value of dataNascimento
     */
    public function setDataNascimento(string $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento;

        return $this;
    }

    /**
     * Get the value of nacionalidade
     */
    public function getNacionalidade(): ?string
    {
        return $this->nacionalidade;
    }

    /**
     * Set the value of nacionalidade
     */
    public function setNacionalidade(?string $nacionalidade): self
    {
        $this->nacionalidade = $nacionalidade;

        return $this;
    }

    /**
     * Get the value of altura
     */
    public function getAltura(): ?float
    {
        return $this->altura;
    }

    /**
     * Set the value of altura
     */
    public function setAltura(?float $altura): self
    {
        $this->altura = $altura;

        return $this;
    }

    /**
     * Get the value of peso
     */
    public function getPeso(): ?float
    {
        return $this->peso;
    }

    /**
     * Set the value of peso
     */
    public function setPeso(?float $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get the value of peDominante
     */
    public function getPeDominante(): ?string
    {
        return $this->peDominante;
    }

    /**
     * Set the value of peDominante
     */
    public function setPeDominante(?string $peDominante): self
    {
        $this->peDominante = $peDominante;

        return $this;
    }

    /**
     * Get the value of posicao
     */
    public function getPosicao(): ?string
    {
        return $this->posicao;
    }

    /**
     * Set the value of posicao
     */
    public function setPosicao(?string $posicao): self
    {
        $this->posicao = $posicao;

        return $this;
    }

    /**
     * Get the value of time
     */
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * Set the value of time
     */
    public function setTime(?string $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get the value of imagem
     */
    public function getImagem(): ?string
    {
        return $this->imagem;
    }

    /**
     * Set the value of imagem
     */
    public function setImagem(?string $imagem): self
    {
        $this->imagem = $imagem;

        return $this;
    }

    /**
     * Get the value of criadoEm
     */
    public function getCriadoEm(): DateTimeImmutable
    {
        return $this->criadoEm;
    }

    /**
     * Set the value of criadoEm
     */
    public function setCriadoEm(DateTimeImmutable $criadoEm): self
    {
        $this->criadoEm = $criadoEm;

        return $this;
    }
}