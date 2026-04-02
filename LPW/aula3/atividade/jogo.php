<?php

require_once(__DIR__."/modelo/Palpite.php");

$avestruz = new Palpite("avestruz", "https://www.eojogodobicho.com/images/animais/grupo-1-avestruz.webp", [1,2,3,4]);
$aguia = new Palpite("aguia", "https://www.eojogodobicho.com/images/animais/grupo-2-aguia.webp", [5,6,7,8]);
$burro = new Palpite("burro", "https://www.eojogodobicho.com/images/animais/grupo-3-burro.webp", [9,10,11,12]);
$borboleta = new Palpite("borboleta", "https://www.eojogodobicho.com/images/animais/grupo-4-borboleta.webp", [13,14,15,16]);
$cachorro = new Palpite("cachorro", "https://www.eojogodobicho.com/images/animais/grupo-5-cachorro.webp", [17,18,19,20]);
$cabra = new Palpite("cabra", "https://www.eojogodobicho.com/images/animais/grupo-6-cabra.webp", [21,22,23,24]);
$carneiro = new Palpite("carneiro", "https://www.eojogodobicho.com/images/animais/grupo-7-carneiro.webp", [25,26,27,28]);
$camelo = new Palpite("camelo", "https://www.eojogodobicho.com/images/animais/grupo-8-camelo.webp", [29,30,31,32]);
$cobra = new Palpite("cobra", "https://www.eojogodobicho.com/images/animais/grupo-9-cobra.webp", [33,34,35,36]);
$coelho = new Palpite("coelho", "https://www.eojogodobicho.com/images/animais/grupo-10-coelho.webp", [37,38,39,40]);
$cavalo = new Palpite("cavalo", "https://www.eojogodobicho.com/images/animais/grupo-11-cavalo.webp", [41,42,43,44]);
$elefante = new Palpite("elefante", "https://www.eojogodobicho.com/images/animais/grupo-12-elefante.webp", [45,46,47,48]);
$galo = new Palpite("galo", "https://www.eojogodobicho.com/images/animais/grupo-13-galo.webp", [49,50,51,52]);
$gato = new Palpite("gato", "https://www.eojogodobicho.com/images/animais/grupo-14-gato.webp", [53,54,55,56]);
$jacare = new Palpite("jacare", "https://www.eojogodobicho.com/images/animais/grupo-15-jacare.webp", [57,58,59,60]);
$leao = new Palpite("leao", "https://www.eojogodobicho.com/images/animais/grupo-16-leao.webp", [61,62,63,64]);
$macaco = new Palpite("macaco", "https://www.eojogodobicho.com/images/animais/grupo-17-macaco.webp", [65,66,67,68]);
$porco = new Palpite("porco", "https://www.eojogodobicho.com/images/animais/grupo-18-porco.webp", [69,70,71,72]);
$peru = new Palpite("peru", "https://www.eojogodobicho.com/images/animais/grupo-20-peru.webp", [77,78,79,80]);
$pavao = new Palpite("pavao", "https://www.eojogodobicho.com/images/animais/grupo-19-pavao.webp", [73,74,75,76]);
$touro = new Palpite("touro", "https://www.eojogodobicho.com/images/animais/grupo-21-touro.webp", [81,82,83,84]);
$tigre = new Palpite("tigre", "https://www.eojogodobicho.com/images/animais/grupo-22-tigre.webp", [85,86,87,88]);
$urso = new Palpite("urso", "https://www.eojogodobicho.com/images/animais/grupo-23-urso.webp", [89,90,91,92]);
$veado = new Palpite("veado", "https://www.eojogodobicho.com/images/animais/grupo-24-veado.webp", [93,94,95,96]);
$vaca = new Palpite("vaca", "https://www.eojogodobicho.com/images/animais/grupo-25-vaca.webp", [97,98,99,100]);


$animais = [
    $avestruz, $aguia, $burro, $borboleta, $cachorro, $cabra, $carneiro, 
    $camelo, $cobra, $coelho, $cavalo, $elefante, $galo, $gato, $jacare, 
    $leao, $macaco, $porco, $peru, $pavao, $touro, $tigre, $urso, $veado, $vaca
];


$palpite = $_GET["palpite"] ?? null;

$correto = 10;//rand(1, 100);

$animalCorreto = null;
    foreach ($animais as $animal) {
        if (in_array($correto, $animal->getNumeros())) {
            $animalCorreto = $animal;
            break;
        }
    }

if($palpite && (is_numeric($palpite) || $palpite < 1 || $palpite > 100)){
    foreach($animalCorreto->getNumeros() as $teste){
    if($palpite == $teste){

        echo "parabens! voce acertou! os numero da vez eram <br>|| ";
        foreach($animalCorreto->getNumeros() as $n){
            echo $n." || ";
        }
        echo "<br>";

        echo "Animal: " . $animalCorreto->getNome() . "<br>";
        echo "<img src=" . $animalCorreto->getImagem().">";
        exit;
    }
    } 
    //TODO: implementar codigo em caso de erro (ex: dar dicas antes de rodar dnv)

    echo "que pena, voce errou!";
}else{
    echo "insira seu palpite na uri (jogo.php?palpite=_)";
}