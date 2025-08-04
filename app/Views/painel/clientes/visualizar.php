<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Detalhes do Cliente<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Detalhes do Cliente</h1>
    <div>
        <a href="<?= base_url('dashboard/clientes') ?>" class="btn btn-secondary">Voltar para a Lista</a>
        <a href="<?= base_url('dashboard/clientes/pdf/' . $cliente['id']) ?>" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf me-2"></i>Gerar PDF
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-user-circle me-2"></i> <?= esc($cliente['nome_completo']) ?></h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Informações de Contato</h5>
                <dl class="row">
                    <dt class="col-sm-4">E-mail</dt>
                    <dd class="col-sm-8"><?= esc($cliente['email'] ?: 'Não informado') ?></dd>

                    <dt class="col-sm-4">Telefone</dt>
                    <dd class="col-sm-8"><?= esc($cliente['telefone'] ?: 'Não informado') ?></dd>
                </dl>
            </div>
            <div class="col-md-6">
                <h5>Documentos e Datas</h5>
                <dl class="row">
                    <dt class="col-sm-4">CPF/CNPJ</dt>
                    <dd class="col-sm-8"><?= esc($cliente['cpf_cnpj'] ?: 'Não informado') ?></dd>

                    <dt class="col-sm-4">Data de Nascimento</dt>
                    <dd class="col-sm-8"><?= $cliente['data_nascimento'] ? date('d/m/Y', strtotime($cliente['data_nascimento'])) : 'Não informada' ?></dd>

                    <dt class="col-sm-4">Cliente desde</dt>
                    <dd class="col-sm-8"><?= date('d/m/Y \à\s H:i', strtotime($cliente['created_at'])) ?></dd>
                </dl>
            </div>
        </div>
        <hr>
        <h5>Endereço</h5>
        <p><?= esc($cliente['endereco'] ?: 'Endereço não informado') ?></p>
        <p><strong>CEP:</strong> <?= esc($cliente['cep'] ?: 'Não informado') ?></p>
    </div>
</div>

<?= $this->endSection() ?>