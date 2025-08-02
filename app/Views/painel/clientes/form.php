<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?><?= isset($cliente) ? 'Editar Cliente' : 'Novo Cliente' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<h1 class="h3 mb-4"><?= isset($cliente) ? 'Editando Cliente: ' . esc($cliente['nome_completo']) : 'Cadastrar Novo Cliente' ?></h1>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('dashboard/clientes/salvar') ?>" method="post">
            
            <input type="hidden" name="id" value="<?= isset($cliente) ? esc($cliente['id']) : '' ?>">

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label for="nome_completo" class="form-label">Nome Completo / Razão Social</label>
                    <input type="text" class="form-control" id="nome_completo" name="nome_completo" value="<?= isset($cliente) ? esc($cliente['nome_completo']) : '' ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="cpf_cnpj" class="form-label">CPF / CNPJ</label>
                    <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="<?= isset($cliente) ? esc($cliente['cpf_cnpj']) : '' ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= isset($cliente) ? esc($cliente['email']) : '' ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= isset($cliente) ? esc($cliente['telefone']) : '' ?>">
                </div>
            </div>

            <div class="mb-3">
                <label for="endereco" class="form-label">Endereço</label>
                <textarea class="form-control" id="endereco" name="endereco" rows="3"><?= isset($cliente) ? esc($cliente['endereco']) : '' ?></textarea>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="<?= base_url('dashboard/clientes') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>