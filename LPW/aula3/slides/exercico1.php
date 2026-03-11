<?php

//metodo GET
$numA = $_GET["numA"] ?? 0;
$numB = $_GET["numB"] ?? 0;

echo $numA+$numB;

echo "<br>";

//metodo POST

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num1 = $_POST['num1'] ?? 0;
    $num2 = $_POST['num2'] ?? 0;
    
    echo $num1 + $num2;
}
?>

<!-- Formulário HTML para enviar os dados por POST -->
<form method="POST">
    <input type="number" name="num1" placeholder="Número 1" required>
    <input type="number" name="num2" placeholder="Número 2" required>
    <button type="submit">Somar</button>
</form>