<?php

require_once(__DIR__."/modelo/Veiculo.php");

$modelo = $_POST["modelo"];
$marca = $_POST["modelo"];
$combust = $_POST["modelo"];

$veiculo = new Veiculo($modelo, $marca, $combust);

echo "<h1>Dados informados</h1>";
echo "Modelo: ".$veiculo->getModelo()."<br>";
echo "Marca: ".$veiculo->getMarca()."<br>";
echo "Combustivel: ".$veiculo->getCombustivelInteiro()."<br>";

echo "<br><a href='index.php'>Cadastrar outro veiculo</a>";

?>