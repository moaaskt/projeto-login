<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Detalhes do Cliente<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold text-primary"><i class="fas fa-user me-2"></i>Detalhes do Cliente</h1>
    <div class="d-flex gap-2">
        <a href="<?= base_url('dashboard/clientes') ?>" class="btn btn-outline-light">
            <i class="fas fa-arrow-left me-1"></i> Voltar
        </a>
        <a href="<?= base_url('dashboard/clientes/pdf/' . $cliente['id']) ?>" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf me-2"></i>Gerar PDF
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Card de Informações -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100 bg-dark text-light">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-id-card me-2"></i><?= esc($cliente['nome_completo']) ?>
                </h4>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <!-- Contato -->
                    <div class="col-md-6">
                        <h5 class="fw-semibold text-info mb-3">
                            <i class="fas fa-envelope me-2"></i>Informações de Contato
                        </h5>
                        <ul class="list-unstyled mb-0">
                            <li><strong class="text-white">E-mail:</strong> <?= esc($cliente['email'] ?: 'Não informado') ?></li>
                            <li><strong class="text-white">Telefone:</strong> <?= esc($cliente['telefone'] ?: 'Não informado') ?></li>
                        </ul>
                    </div>
                    <!-- Documentos -->
                    <div class="col-md-6">
                        <h5 class="fw-semibold text-info mb-3">
                            <i class="fas fa-file-alt me-2"></i>Documentos e Datas
                        </h5>
                        <ul class="list-unstyled mb-0">
                            <li><strong class="text-white">CPF/CNPJ:</strong> <?= esc($cliente['cpf_cnpj'] ?: 'Não informado') ?></li>
                            <li><strong class="text-white">Cliente desde:</strong> <?= date('d/m/Y \à\s H:i', strtotime($cliente['created_at'])) ?></li>
                        </ul>
                    </div>
                </div>

                <hr class="border-secondary my-4">

                <!-- Endereço -->
                <h5 class="fw-semibold text-info mb-3">
                    <i class="fas fa-map-marker-alt me-2"></i>Endereço
                </h5>
                <ul class="list-unstyled mb-0">
                    <li><strong class="text-white">Logradouro:</strong> <?= esc($cliente['logradouro'] ?: 'Não informado') ?>, <?= esc($cliente['numero'] ?: 's/n') ?></li>
                    <li><strong class="text-white">Bairro:</strong> <?= esc($cliente['bairro'] ?: 'Não informado') ?></li>
                    <li><strong class="text-white">Cidade/UF:</strong> <?= esc($cliente['cidade'] ?: 'Não informada') ?> - <?= esc($cliente['estado'] ?: 'NI') ?></li>
                    <li><strong class="text-white">CEP:</strong> <?= esc($cliente['cep'] ?: 'Não informado') ?></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Card QR Code -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100 bg-dark text-light text-center">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-qrcode me-2"></i>Cartão de Visita Digital (vCard)
                </h6>
            </div>
            <div class="card-body">
                <p class="text-light small mb-3">Escaneie o código com a câmera do seu celular para salvar este contato.</p>
                <div class="p-3 border border-secondary rounded bg-white d-inline-block">
                    <img src="<?= $qrCodeDataUri ?>" alt="QR Code vCard" class="img-fluid" style="max-width: 200px;">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ajustes de contraste para tema dark -->
<style>
    .card ul li {
        margin-bottom: 0.4rem;
    }
    .card strong {
        color: #fff !important;
    }
    .card ul li {
        color: #f8f9fa;
    }
</style>

<?= $this->endSection() ?>
