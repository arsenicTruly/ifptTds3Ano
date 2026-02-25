<?php

require_once("modelo/Presidente.php");

$lista = array();

$presidente = new Presidente(16, "Eurico Gaspar Dutra", 1946, 1951);
array_push($lista, $presidente);
$presidente = new Presidente(17, "Getulio Vargas", 1951, 1954);
array_push($lista, $presidente);
$presidente = new Presidente(18, "Cafe filho", 1954, 1955);
array_push($lista, $presidente);
$presidente = new Presidente(19, "Carlos Luz", 1955, 1955);
array_push($lista, $presidente);
$presidente = new Presidente(20, "Nereu Ramos", 1955, 1956);
array_push($lista, $presidente);
$presidente = new Presidente(21, "Jucelino Kubistchek", 1956, 1961);
array_push($lista, $presidente);

echo "<table>";
    echo "<tr>";
        echo "<th>Numero</th>";
        echo "<th>Nome</th>";
        echo "<th>Inicio</th>";
        echo "<th>Fim</th>";
    echo "</tr>";
    foreach($lista as $linha => $presidente){
        echo "<tr>";
        echo $presidente->getLinhaTabela;
        echo "</tr>";
    }
echo "</table>"
