<?php

$carroContainer = array();
$carro = ["modelo" => "fusca", "marca" => "Volkswagen", "imagem" => "fusca.png" ];
array_push($carroContainer, $carro);

$carro = ["modelo" => "uno", "marca" => "Fiat", "imagem" => "uno.png" ];
array_push($carroContainer, $carro);

$carro = ["modelo" => "civic", "marca" => "Honda", "imagem" => "civic.png" ];
array_push($carroContainer, $carro);

$carro = ["modelo" => "corolla", "marca" => "Toyota", "imagem" => "corolla.png" ];
array_push($carroContainer, $carro);

$carro = ["modelo" => "gol", "marca" => "Volkswagen", "imagem" => "gol.png" ];
array_push($carroContainer, $carro);

foreach($carroContainer as $carro){?>

    <div style='border: solid 1px; width: 300px; margin-top: 20px;'>
        <?php echo $carro["modelo"] ?> <br>
        <?php echo $carro["marca"] ?> <br>
        <img style='width: 100%; height: auto; max-height: 200px;' src=<?php echo $carro["imagem"]?> > <br>
    </div>

    <?php
}
