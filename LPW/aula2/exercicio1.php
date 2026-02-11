<?php

$pares = 0;
$impares = 0;

for ($i = 20; $i < 71; $i++){
    if($i % 2 == 0){
        $pares += $i;
    }else{
        $impares =+ $i;
    };
}

print ("pares => ".$pares);
print (" | impares => ".$impares);