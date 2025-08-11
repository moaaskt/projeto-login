<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Detalhes da Fatura<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold text-primary">
        <i class="fas fa-file-invoice-dollar me-2"></i>Detalhes da Fatura #<?= esc($fatura['id']) ?>
    </h1>
    <div class="d-flex gap-2">
        <a href="<?= base_url('dashboard/faturas') ?>" class="btn btn-outline-light">
            <i class="fas fa-arrow-left me-1"></i> Voltar para a Lista
        </a>
        <a href="<?= base_url('dashboard/faturas/excel/' . $fatura['id']) ?>" class="btn btn-success">
            <i class="fas fa-file-excel me-2"></i>Exportar para Excel
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 bg-dark text-light">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">
            <i class="fas fa-user-circle me-2"></i>Cliente: <?= esc($fatura['nome_cliente']) ?>
        </h4>
    </div>
    <div class="card-body">
        <!-- Descrição -->
        <h5 class="fw-semibold text-info"><i class="fas fa-align-left me-2"></i>Descrição</h5>
        <p class="text-light"><?= esc($fatura['descricao']) ?></p>

        <hr class="border-secondary">

        <div class="row">
            <!-- Valor -->
            <div class="col-md-4">
                <h5 class="fw-semibold text-info"><i class="fas fa-dollar-sign me-2"></i>Valor</h5>
                <p class="h4 text-success fw-bold">
                    R$ <?= number_format($fatura['valor'], 2, ',', '.') ?>
                </p>
            </div>
            <!-- Vencimento -->
            <div class="col-md-4">
                <h5 class="fw-semibold text-info"><i class="fas fa-calendar-alt me-2"></i>Data de Vencimento</h5>
                <p class="h5 text-light">
                    <?= date('d/m/Y', strtotime($fatura['data_vencimento'])) ?>
                </p>
            </div>
            <!-- Status -->
            <div class="col-md-4">
                <h5 class="fw-semibold text-info"><i class="fas fa-info-circle me-2"></i>Status</h5>
                <?php 
                    $statusClass = [
                        'Paga' => 'success', 
                        'Pendente' => 'warning', 
                        'Vencida' => 'danger', 
                        'Cancelada' => 'secondary'
                    ];
                ?>
                <span class="badge fs-6 text-bg-<?= $statusClass[$fatura['status']] ?? 'light' ?>">
                    <?= esc($fatura['status']) ?>
                </span>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted border-top border-secondary">
        <small>
            <i class="fas fa-clock me-1"></i>Fatura criada em: 
            <?= date('d/m/Y \à\s H:i', strtotime($fatura['created_at'])) ?>
        </small>
    </div>
</div>

<!-- Ajustes de contraste para tema dark -->
<style>
    .card strong, 
    .card p, 
    .card h5 {
        color: #f8f9fa !important;
    }
    .badge {
        padding: 0.6em 1em;
    }
</style>

<?= $this->endSection() ?>
