<?= $this->extend('cliente/templates/default') ?>

<?= $this->section('title') ?><?= esc($title ?? 'Meu Perfil') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4">Meu Perfil</h1>

<div class="row">

    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Informações Pessoais</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('cliente/perfil/atualizar') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= esc($usuario['nome'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Endereço de E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= esc($usuario['email'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" value="<?= esc($usuario['cpf'] ?? '') ?>" readonly>
                        <div class="form-text">Seu CPF não pode ser alterado.</div>
                    </div>
                    <button type="submit" class="btn btn-success">Atualizar Dados</button>
                </form>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 fw-bold text-primary">Segurança</h6>
            </div>
            <div class="card-body">
                <p>Para sua segurança, mantenha sua senha sempre atualizada.</p>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalAlterarSenha">
                    Alterar Minha Senha
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                 <h6 class="m-0 fw-bold text-primary">Foto de Perfil</h6>
            </div>
            <div class="card-body text-center">
                
                <?php
                    // Prepara o nome do usuário para ser usado na URL
                    $nomeParaAvatar = urlencode($usuario['nome'] ?? 'Usuario');
                ?>

                <img src="https://ui-avatars.com/api/?name=<?= $nomeParaAvatar ?>&background=0D6EFD&color=fff&size=128" 
                     alt="Avatar de <?= esc($usuario['nome']) ?>" 
                     class="img-thumbnail rounded-circle mb-3">
                
                <h5 class="card-title"><?= esc($usuario['nome']) ?></h5>
                <p class="card-text text-muted"><?= esc($usuario['email']) ?></p>

                <!-- <a href="#" class="btn btn-outline-primary btn-sm">Alterar Foto</a> -->
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="modalAlterarSenha" tabindex="-1" aria-labelledby="modalAlterarSenhaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= base_url('cliente/perfil/salvar-senha') ?>" method="post">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalAlterarSenhaLabel">Alterar Senha</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Salvar Nova Senha</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>