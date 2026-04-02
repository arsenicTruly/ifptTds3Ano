<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <h1>Formulario</h1>
    <form action="pessoaExec.php" method="POST">
        <label for="">Nome:</label>
        <input type="text" placeholder="Informe o nome" name="nome"/>

        <br>

        <label for="">Idade:</label>
        <input type="number" placeholder="Informe a idade" name="idade"/>

        <br>

        <button type="submit">Enviar</button>
    </form>
</body>

</html>