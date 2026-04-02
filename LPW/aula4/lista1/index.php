<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto</title>
</head>
<body>
    <form action="produtoExec.php" method="POST">
        <label for="">Descricao: </label>
        <input type="text"  name="descricao"/>

        <br>

        <select name="tipo">
            <option value="">--Selecione o tipo--</option>
            <option value="Vestuario">Vestuario</option>
            <option value="Limpeza">Limpeza</option>
            <option value="Ferramenta">Ferramenta</option>
            <option value="Eletronico">Eletronico</option>
            <option value="Eletrodomestico">Eletrodomestico</option>
        </select>

        <br>

        <label for="">Marca: </label>
        <input type="text"  name="marca"/>

        <br>

        <label for="">Valor: </label>
        <input type="number"  name="valor"/>

        <br>

        <label for="">Link para Imagem: </label>
        <input type="text"  name="Imagem"/>

        <br>

        <label for="">Descricao detalhada: </label>
        <input type="textarea"  name="detalhada"/>

        <br>

        <button type="submit">Enviar</button>
    </form>
</body>

</html>