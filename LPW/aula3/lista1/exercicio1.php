<?php

$numA = $_GET["numA"] ?? null;
$numB = $_GET["numB"] ?? null;

$numA = $numA !== null ? intval($numA) : null;
$numB = $numB !== null ? intval($numB) : null;

if($numA !== null && $numB !== null ){
    
    echo "Soma: " . ($numA + $numB);
    echo "<br>";
    
    if ($numB != 0) {
        echo "Divisao: " . ($numA / $numB);
    } else {
        echo "Divisao: nao se divide por zero";
    }
    echo "<br>";
    
    echo "Multiplicacao: " . ($numA * $numB);
    echo "<br>";
    
    echo "Subtracao: " . ($numA - $numB);
    echo "<br>";
    
    if ($numB != 0) {
        echo "Resto: " . ($numA % $numB);
    } else {
        echo "Resto: nao se calcula modulo de zero";
    }
}else{
    echo "insira os valores na uri (exercicio1.php?numA=_&numB=_)";
}
?>