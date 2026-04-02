<?php

    $cor = $_POST["cor"];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cor Selecionada</title>
    <style>
        body{ 
            background-color: <?php echo $cor;?>;
        }
    </style>
</head>
<body>
    <h1><?php echo $cor?></h1>
    <a href="index.php">Voltar</a>
</body>
</html>