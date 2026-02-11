<?php

$retanguloContainer = array();
for($i=1; $i<4; $i++){
    $retangulo = ["base" => $i, "altura" => $i+1];
    array_push($retanguloContainer, $retangulo);
};
foreach($retanguloContainer as $r){
    print ("Area retangulo => ".$r["base"]*$r["altura"]." | ");
}
