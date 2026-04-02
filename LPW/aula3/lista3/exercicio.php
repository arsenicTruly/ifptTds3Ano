<?php

require_once(__DIR__."/modelo/ImpostoRenda.php");

$renda = $_GET["renda"];

$imposto = new ImpostoRenda($renda);

echo"Seu imposto total: ".$imposto->formatarMoeda($imposto->getImposto());
echo"<br>Sua alquota total: ".$imposto->getAliquotaEfetiva()."%";
echo"<br>Detalhes: ";
$index = $i+1;
if($imposto->getImposto() > 0){
    foreach($imposto->getDetalhesFaixas() as $i => $porcFaixa){
        echo"Faixa ".$index.": ".$porcFaixa."%";
        echo"<br>";
    }
}

?>