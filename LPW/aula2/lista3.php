<?php 

$nome = array("Nome", "Foz do Iguacu", "Cascavel", "Chapeco", "Blumenau", "Curitiba");
$habitantes = array("Habitantes", "250.000", "300.000", "240.000", "330.000", "1.500.0000");
$area = array("Area", "500km²","420km²","120km²", "200km²", "300km²");
$altitude = array("Altitude", "145m", "320m", "620m", "85m", "850m");
$estado = array("Estado", "Parana-PR", "Parana-PR", "Santa catarina-SC", "Santa catarina-SC", "Parana-PR");

$tabela = array();
array_push($tabela, $nome, $habitantes, $area, $altitude, $estado);
?>
<table style='border: solid 1px;'>
    <?php
        do{
            ?>
            <tr style='border: solid 1px;'>
            <?php
                foreach ($tabela as $coluna){
                    if($i == 0){?>
                        <th style='border: solid 1px;'> <?php echo $coluna[0]?> </th>
                        <?php
                    }else{?>
                        <td style='border: solid 1px;'> <?php echo $coluna[$i]?> </td>
                        <?php
                    }
                }
                $i++;
            ?>
            </tr>
            <?php
        }while($i <6);
    ?>
</table>