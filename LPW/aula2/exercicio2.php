<?php
echo "media de 1, 2 e 3 => ";
echo media(1,2,3);
echo " | media de 4, 5 e 6 => ";
echo media(4,5,6);
echo " | media de 7, 8 e 9 => ";
echo media(7,8,9);
function media($n1, $n2, $n3){
    $soma = $n1 + $n2 + $n3;
    $media = $soma/3;
    return $media;
}