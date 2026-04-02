<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Projeto Integrador • Lista de Jogadores</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <div class="container py-5">

        <!-- TÍTULO + NOVO -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Lista de Jogadores</h2>
            <a href="<?= URL_BASE ?>/jogadores/cadastrar" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Novo Jogador
            </a>
        </div>

        <!-- CARD COM TABELA -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Nome</th>
                                <th class="px-4 py-3">Nacionalidade</th>
                                <th class="px-4 py-3 text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista as $jogador): ?>
                                <tr>
                                    <td class="px-4 py-3 align-middle"><?= $jogador['nome'] ?></td>
                                    <td class="px-4 py-3 align-middle"><?= $jogador['nacionalidade'] ?></td>
                                    <td class="px-4 py-3 align-middle text-end">
                                        <a href="<?= URL_BASE ?>/jogadores/jogador?id=<?= $jogador['id'] ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>