<?php 
$cabecalho = array("Ordem", "Pais", "Ouro", "Prata", "Bronze", "Total");
$USA = array("1", "USA - Estados Unidos", "46", "37", "38", "121", "bandeiraUSA.svg", "https://pt.wikipedia.org/wiki/Estados_Unidos");
$GBR = array("2", "GBR - Gra-Bretanha", "27", "23", "12", "67", "bandeiraGBR.svg", "https://pt.wikipedia.org/wiki/Grã-Bretanha");
$CHN = array("3", "CHN - China", "26", "18", "26", "70", "bandeiraCHN.svg", "https://pt.wikipedia.org/wiki/China");
$RUS = array("4", "RUS - Russia", "19", "17", "20", "56", "bandeiraRUS.svg", "https://pt.wikipedia.org/wiki/Russia");
$GER = array("5", "GER - Alemanha", "17", "10", "15", "42", "bandeiraGER.svg", "https://pt.wikipedia.org/wiki/Alemanha");

$tabela = array();
array_push($tabela, $cabecalho, $USA, $GBR, $CHN, $RUS, $GER);
?>

<table style="border='1'">
    <?php
        foreach ($tabela as $linha => $row) {
            echo "<tr>";
            for ($i = 0; $i < count($row) - 2; $i++) {
                if ($linha == 0) {
                    echo "<th style='background-color: grey'>{$row[$i]}</th>";
                } else {
                    echo "<td>";
                        if ($i == 1) {
                            echo "<img src='{$row[6]}' alt='Bandeira' width='25'> ";
                            echo "<a href='{$row[7]}'>";
                            echo $row[$i];
                            echo "</a>";
                        } else {
                            echo $row[$i];
                        }
                    echo "</td>";
                }
            }
            echo "</tr>";
        }
    ?>
</table>

