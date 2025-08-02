<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>
Meu Perfil
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1 class="h3 mb-4">Meu Perfil</h1>
    <div class="card shadow">
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label for="fullName" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="fullName" value="Seu Chefe">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Endereço de E-mail</label>
                    <input type="email" class="form-control" id="email" value="chefe@empresa.com" readonly>
                </div>
                <hr>
                <button type="submit" class="btn btn-success">Salvar Alterações</button>
            </form>
        </div>
    </div>
<?= $this->endSection() ?>