<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Meu Perfil<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4">Meu Perfil</h1>

<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Informações Cadastrais</h6></div>
            <div class="card-body">
                <?php if (session()->get('success')): ?>
                    <div class="alert alert-success"><?= session()->get('success') ?></div>
                <?php endif; ?>
                <?php if (session()->get('errors')): ?>
                    <div class="alert alert-danger">
                        <ul><?php foreach (session()->get('errors') as $error): ?><li><?= esc($error) ?></li><?php endforeach ?></ul>
                    </div>
                <?php endif; ?>
            
                <form action="<?= base_url('dashboard/perfil/atualizar-dados') ?>" method="post" id="form-dados">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= esc($usuario['nome']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= esc($usuario['email']) ?>">
                    </div>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirm-dados-modal">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header"><h6 class="m-0 font-weight-bold text-primary">Alterar Senha</h6></div>
            <div class="card-body">
                 <?php if (session()->get('success-senha')): ?>
                    <div class="alert alert-success"><?= session()->get('success-senha') ?></div>
                <?php endif; ?>
                <?php if (session()->get('error-senha')): ?>
                    <div class="alert alert-danger"><?= session()->get('error-senha') ?></div>
                <?php endif; ?>
                 <?php if (session()->get('errors-senha')): ?>
                    <div class="alert alert-danger">
                        <ul><?php foreach (session()->get('errors-senha') as $error): ?><li><?= esc($error) ?></li><?php endforeach ?></ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('dashboard/perfil/alterar-senha') ?>" method="post" id="form-senha">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="senha_atual" class="form-label">Senha Atual</label>
                        <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
                    </div>
                    <div class="mb-3">
                        <label for="nova_senha" class="form-label">Nova Senha</label>
                        <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                    </div>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirm-senha-modal">Alterar Senha</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-dados-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header"><h5 class="modal-title">Confirmar Alterações</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
            <div class="modal-body"><p>Deseja realmente salvar as novas informações do seu perfil?</p></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="submit-dados-btn">Confirmar e Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm-senha-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header"><h5 class="modal-title">Confirmar Alteração de Senha</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <p>Você tem certeza que deseja alterar sua senha de acesso?</p>
                <p class="text-warning"><small>Você precisará usar a nova senha no seu próximo login.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="submit-senha-btn">Confirmar e Alterar Senha</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>