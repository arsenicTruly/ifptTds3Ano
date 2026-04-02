<div class="container mt-5">
    <div class="card shadow-sm col-md-6 mx-auto border-primary">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Editar Usuário</h4>
        </div>
        <div class="card-body">
            <form action="<?= URL_BASE ?>/usuarios/atualizar" method="post">
                <!-- Campo oculto para o ID -->
                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

                <div class="mb-3">
                    <label for="nomeUsuario" class="form-label">Nome de Usuário</label>
                    <input type="text" class="form-control" id="nomeUsuario" name="nomeUsuario" value="<?= $usuario['nomeUsuario'] ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $usuario['email'] ?>">
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Nova Senha (Deixe em branco para não alterar)</label>
                    <input type="password" class="form-control" id="senha" name="senha">
                </div>

                <div class="mb-3">
                    <label for="perfil" class="form-label">Perfil de Acesso</label>
                    <select class="form-select" id="perfil" name="perfil">
                        <option value="user" <?= $usuario['perfil'] === 'user' ? 'selected' : '' ?>>Usuário Padrão</option>
                        <option value="admin" <?= $usuario['perfil'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Atualizar Dados</button>
                    <a href="<?= URL_BASE ?>/usuarios" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>