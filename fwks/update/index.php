<?php
/**
 * index.php - Pagina inicial do framework.
 * Exibe formulario de upload do dump .sql e mensagens de erro.
 */
if (isset($_GET["erro"])) {
    switch ($_GET["erro"]) {
        case 0:
            echo "<div class='erro'>Apenas arquivos com extensao .sql sao permitidos.</div>";
            break;
        case 1:
            echo "<div class='erro'>Falha no upload. Tente novamente.</div>";
            break;
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Framework MVC - Gerador</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
</head>
<body>
    <main class="hero">
        <header class="hero-top">
            <span class="badge">IFPT / TDS 3º Ano</span>
            <h1>Framework MVC</h1>
            <h2>Transforme seu dump <code>.sql</code> em um sistema PHP completo em segundos</h2>
        </header>

        <form action="LeitorSQL.php" method="post" enctype="multipart/form-data" class="card-upload">
            <label for="arquivo">Selecione o arquivo SQL (dump MySQL)</label>
            <div class="dropzone">
                <input type="file" name="arquivo" id="arquivo" accept=".sql" required>
                <p class="dica">Formatos aceitos: <strong>.sql</strong> gerados pelo phpMyAdmin / mysqldump</p>
            </div>
            <button type="submit">Gerar sistema MVC &#10148;</button>
        </form>

        <section class="recursos">
            <article class="recurso">
                <h3>Model</h3>
                <p>Classes com tipagem, getters/setters e validacao automatica.</p>
            </article>
            <article class="recurso">
                <h3>View</h3>
                <p>Formularios e listagens com Bootstrap 5, prontos para uso.</p>
            </article>
            <article class="recurso">
                <h3>Control</h3>
                <p>CRUD completo: inserir, alterar, excluir e listar via <code>?acao=</code>.</p>
            </article>
            <article class="recurso">
                <h3>DAO</h3>
                <p>Acesso a dados via PDO com prepared statements e JOINs automaticos.</p>
            </article>
        </section>
    </main>
</body>
</html>
