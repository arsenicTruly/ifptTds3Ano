<?php

$corFundo = $_GET["corFundo"] ?? 'white';

echo "<style>";
    echo"body{";
        echo"background-color:". $corFundo.";";
    echo"}";
echo "</style>";