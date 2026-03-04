<?php

require_once("modelo/Link.php");

$times = [
    new Link("https://upload.wikimedia.org/wikipedia/commons/thumb/0/04/Gremio_logo.svg/1200px-Gremio_logo.svg.png", "Grêmio FBPA"),
    new Link("https://upload.wikimedia.org/wikipedia/commons/thumb/9/9d/Sc_internacional_logo.svg/1200px-Sc_internacional_logo.svg.png", "Sport Club Internacional"),
    new Link("https://upload.wikimedia.org/wikipedia/commons/thumb/5/56/Escudo_do_Santos_Futebol_Clube.svg/1200px-Escudo_do_Santos_Futebol_Clube.svg.png", "Santos Futebol Clube")
];

$paises = [
    new Link("https://upload.wikimedia.org/wikipedia/en/thumb/0/05/Flag_of_Brazil.svg/1200px-Flag_of_Brazil.svg.png", "Brasil"),
    new Link("https://upload.wikimedia.org/wikipedia/en/thumb/a/a4/Flag_of_the_United_States.svg/1200px-Flag_of_the_United_States.svg.png", "Estados Unidos"),
    new Link("https://upload.wikimedia.org/wikipedia/en/thumb/c/c3/Flag_of_France.svg/1200px-Flag_of_France.svg.png", "França")
];

$carros = [
    new Link("https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Ferrari-Logo.svg/1200px-Ferrari-Logo.svg.png", "Ferrari"),
    new Link("https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/Lamborghini_logo.svg/1200px-Lamborghini_logo.svg.png", "Lamborghini"),
    new Link("https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Porsche_logo.svg/1200px-Porsche_logo.svg.png", "Porsche")
];

$politicos = [
    new Link("https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/Presidente_Luiz_In%C3%A1cio_Lula_da_Silva_%28recorte%29.jpg/1200px-Presidente_Luiz_In%C3%A1cio_Lula_da_Silva_%28recorte%29.jpg", "Luiz Inácio Lula da Silva"),
    new Link("https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Jair_Bolsonaro_em_2019.jpg/1200px-Jair_Bolsonaro_em_2019.jpg", "Jair Bolsonaro"),
    new Link("https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/Fernando_Haddad_2023_%28cropped%29.jpg/1200px-Fernando_Haddad_2023_%28cropped%29.jpg", "Fernando Haddad")
];

print"<link rel='stylesheet' href='botao_imagem.css'>";

desenhaBotao("times", $times);
desenhaBotao("paises", $paises);
desenhaBotao("carros", $carros);
desenhaBotao("politicos", $politicos);

function desenhaBotao(string $nomeBotao = "botao", array $itemsBotao = array()){
    print"<div class='dropdown'>";
        print"<button class='dropbtn'>".$nomeBotao."</button>";
        print"<div class='droptext'>";
        foreach($itemsBotao as $item){
                print"<span><img src='".$item->getLinkImg()."' width='20' height='20'>".$item->getInfo()."</span>";        
        }
        print"</div>";
    print"</div>";
}