<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veiculo</title>
</head>
<body>
    <h1>Veiculo</h1>
    <form action="veiculoExec.php" method="POST">
        <label for="">Modelo:</label>
        <input type="text" placeholder="Informe o modelo" name="modelo"/>

        <br>

        <label for="">Idade:</label>
        <input type="text" placeholder="Informe a marca" name="marca"/>

        <br>

        <select name="combustivel">
            <option value="">--Selecione o combustivel--</option>
            <option value="A">Alcol</option>
            <option value="G">Gasolina</option>
            <option value="F">Flex</option>
        </select>

        <button type="submit">Enviar</button>
    </form>
</body>

</html>