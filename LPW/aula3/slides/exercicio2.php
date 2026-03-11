<?php

//metodo GET

$numA = $_GET["numA"] ?? 0;
$numB = $_GET["numB"] ?? 0;
$numC = $_GET["numC"] ?? 0;

$media = ($numA + $numB + $numC)/3;
    echo $media;

//metodo POST


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num1 = $_POST['num1'] ?? 0;
    $num2 = $_POST['num2'] ?? 0;
    $num3 = $_POST['num3'] ?? 0;
    
    $media = ($num1 + $num2 + $num3)/3;
    echo $media;
}
?>

<!-- Formulário HTML para enviar os dados por POST -->
<form method="POST">
    <input type="number" name="num1" placeholder="Número 1" required>
    <input type="number" name="num2" placeholder="Número 2" required>
    <input type="number" name="num3" placeholder="Número 3" required>
    <button type="submit">Calcular media</button>
</form>