<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login TDS</title>
</head>
<body>
        <h1>Login TDS</h1>
        
        <?php
        //se ja teve um post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = strtolower($usuario = $_POST["usuario"] ?? "");
            $senha = strtolower($_POST["senha"] ?? "");
            
            if ($usuario == "ifpr" && $senha == "tds") {
                echo '<div class="welcome">';
                echo 'Bem vindo ao TDS!';
                echo '</div>';
                $showForm = false;
            } else {
                $mostraForm = true;
            }
        } else {
            $mostraForm = true;
        }
        
        if ($mostraForm) {
        ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="usuario">Usuário:</label>
                <input type="text" name="usuario"/>
                
                <br>
                
                <label for="senha">Senha:</label>
                <input type="password" name="senha"/>
                
                <br>
                
                <button type="submit">Enviar</button>
            </form>
        
        <?php 
        } ?>
</body>
</html>