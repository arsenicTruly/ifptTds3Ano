<?php

require_once(__DIR__."/modelo/Pessoa.php");


$tipo = $_GET["tipo"] ?? null;
$nome = $_GET["nome"] ?? null;
$sobrenome = $_GET["sobrenome"] ?? null;
$idade = $_GET["idade"] ?? null;


if (!$tipo || !$nome || !$sobrenome || !$idade) {
    echo "Erro: Faltam parametros. Por favor insira tipo, nome, sobrenome, e idade.";
    exit;
}

$tipo = strtoupper($tipo);

if($tipo == "C"){
    $pessoa = new Pessoa($nome, $sobrenome, $idade);
    echo $pessoa->getDados();
} elseif($tipo == "A"){
    $pessoa = [
        "nome" => $nome,
        "sobrenome" => $sobrenome,
        "idade" => $idade
    ];

    echo "Nome completo: " . $pessoa["nome"] . " " . $pessoa["sobrenome"] 
         . "<br>Idade: " . $pessoa["idade"];
} else {
    echo "Variável 'tipo' com valor inadequado. Valores 'A' ou 'C' apenas.";
}

//exercicio1.php?tipo=a&nome=_&sobrenome=_&idade=_
?>