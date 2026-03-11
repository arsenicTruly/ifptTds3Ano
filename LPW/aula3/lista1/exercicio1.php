<form method="POST">
    <input type="number" name="num1" placeholder="Número 1" required>
    <input type="number" name="num2" placeholder="Número 2" required>
    <button type="submit">Calcular</button>
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $num1 = $_POST['num1'] ?? 0;
    $num2 = $_POST['num2'] ?? 0;
    
    echo "Soma: ".$num1 + $num2;
    echo "<br>";
    echo "Divisao: ".$num1 / $num2;
    echo "<br>";
    echo "Multiplicacao: ".$num1 * $num2;
    echo "<br>";
    echo "Subtracao: ".$num1 - $num2;
    echo "<br>";
    echo "Resto: ".$num1 % $num2;
}
?>