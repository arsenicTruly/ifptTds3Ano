<?php

echo"<link rel='stylesheet' href='style.css'>";

$jogadores = [
    [1, "Tafarel"],
    [2, "Jorginho"],
    [13, "Aldair"],
    [15, "Marcio Santos"],
    [6, "Branco"],
    [5, "Mauro Silva"],
    [8, "Dunga"],
    [17, "Mazinho"],
    [9, "Zinho"],
    [11, "Romario"],
    [7, "Bebeto"],
];

print"<table>";
    print"<tr>";
        print"<th>Numero</th>";
        print"<th>Nome</th>";
    print"</tr>";
    foreach($jogadores as $n => $jogador){
        if($n % 2 == 0){
            $cor="amarelo";
        }else{
            $cor="verde";
        }
        linhaJogador($jogador[0], $jogador[1], $cor);
    }
print"</table>";

function linhaJogador(int $numero = 0, string $nome = "indefinido", string $cor = "amarelo"){
    echo"<tr style='background-color:var(--cor-".$cor.");'>";
        echo"<td>".$numero."</td>";
        echo"<td>".$nome."</td>";
    echo"<tr>";
}