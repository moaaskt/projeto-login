<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Meu Perfil<?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4">Meu Perfil</h1>

<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Informações Cadastrais</h6>
            </div>
            <div class="card-body">
                <?php if (session()->get('success')): ?>
                    <div class="alert alert-success"><?= session()->get('success') ?></div>
                <?php endif; ?>
                <?php if (session()->get('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                        <?php foreach (session()->get('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>
            
                <form action="<?= base_url('dashboard/perfil/atualizar-dados') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= esc($usuario['nome']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= esc($usuario['email']) ?>">
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Alterar Senha</h6>
            </div>
            <div class="card-body">
                 <?php if (session()->get('success-senha')): ?>
                    <div class="alert alert-success"><?= session()->get('success-senha') ?></div>
                <?php endif; ?>
                <?php if (session()->get('error-senha')): ?>
                    <div class="alert alert-danger"><?= session()->get('error-senha') ?></div>
                <?php endif; ?>
                 <?php if (session()->get('errors-senha')): ?>
                    <div class="alert alert-danger">
                        <ul>
                        <?php foreach (session()->get('errors-senha') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('dashboard/perfil/alterar-senha') ?>" method="post">
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
                    <button type="submit" class="btn btn-warning">Alterar Senha</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>