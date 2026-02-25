<?php 

$cabecalho = array("Ordem", "Pais", "Ouro", "Prata", "Bronze", "Total");
$USA = array("1", "USA - Estados Unidos", "46", "37", "38", "121", "bandeiraUSA.jpg");
$GBR = array("2", "GBR - Gra-Bretanha", "27", "23", "12", "67", "bandeiraGBR.jpg");
$CHN = array("3", "CHN - China", "26", "18", "26", "70", "bandeiraCHN.jpg");
$RUS = array("4", "RUS - Russia", "19", "17", "20", "56", "bandeiraRUS.jpg");
$GER = array("5", "GER - Alemanha", "17", "10", "15", "42", "bandeiraGER.jpg");

$tabela = array();
array_push($tabela, $cabecalho, $USA, $GBR, $CHN, $RUS, $GER);
?>
<table>
    <?php
        foreach ($tabela as $linha => $row) {
            echo "<tr>";
            for ($i = 0; $i < count($row); $i++) {
                if ($linha == 0) {
                    echo "<th style='background-color: grey'>{$row[$i]}</th>";
                } else {
                    echo "<td>";
                    if ($i == 1) {
                        echo "<img src='{$row[6]}' alt='Bandeira' width='25'> ";
                    }
                    echo $row[$i];
                    echo"</td>";
                }
            }
            echo "</tr>";
        }
    ?>
</table>
