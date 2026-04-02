<?php

namespace app\repositories;

use app\database\ConnectionFactory;
use app\models\Jogador;
use PDO;

class JogadorRepository
{

    private PDO $connection;


    function __construct()
    {
        $this->connection = ConnectionFactory::getConnection();
    }

    public function getJogadores(): array
    {

        $stm = $this->connection->prepare("SELECT * FROM jogadores");
        $stm->execute();

        $jogadores = $stm->fetchAll();

        return $jogadores;
    }

    public function getJogador(int $id)
    {

        $stm = $this->connection->prepare("SELECT * FROM jogadores WHERE id = :id");
        $stm->bindValue('id', $id);

        $stm->execute();

        $jogador = $stm->fetch();

        return $jogador;
    }

    public function saveJogador(Jogador $jogador)
    {

        $sql = "INSERT INTO jogadores (nome, data_nascimento, nacionalidade, altura, peso, pe_dominante, posicao, time, imagem) " .
            "VALUES(:nome, :nascimento, :nacionalidade, :altura, :peso, :peDominante, :posicao, :time, :imagem)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nome', $jogador->getNome());
        $stmt->bindValue(':nascimento', $jogador->getDataNascimento());
        $stmt->bindValue(':nacionalidade', $jogador->getNacionalidade());
        $stmt->bindValue(':altura', $jogador->getAltura());
        $stmt->bindValue(':peso', $jogador->getPeso());
        $stmt->bindValue(':peDominante', $jogador->getPeDominante());
        $stmt->bindValue(':posicao', $jogador->getPosicao());
        $stmt->bindValue(':time', $jogador->getTime());
        $stmt->bindValue(':imagem', $jogador->getImagem());

        return $stmt->execute();
    }
}
