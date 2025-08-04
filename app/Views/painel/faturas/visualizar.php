<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Detalhes da Fatura<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Detalhes da Fatura #<?= esc($fatura['id']) ?></h1>
    <div>
        <a href="<?= base_url('dashboard/faturas') ?>" class="btn btn-secondary">Voltar para a Lista</a>
        <a href="<?= base_url('dashboard/faturas/excel/' . $fatura['id']) ?>" class="btn btn-success">
            <i class="fas fa-file-excel me-2"></i>Exportar para Excel
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-user-circle me-2"></i>Cliente: <?= esc($fatura['nome_cliente']) ?></h4>
    </div>
    <div class="card-body">
        <h5>Descrição</h5>
        <p><?= esc($fatura['descricao']) ?></p>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <h5>Valor</h5>
                <p class="h4 text-success">R$ <?= number_format($fatura['valor'], 2, ',', '.') ?></p>
            </div>
            <div class="col-md-4">
                <h5>Data de Vencimento</h5>
                <p class="h5"><?= date('d/m/Y', strtotime($fatura['data_vencimento'])) ?></p>
            </div>
            <div class="col-md-4">
                <h5>Status</h5>
                <p>
                    <?php 
                        $statusClass = ['Paga' => 'success', 'Pendente' => 'warning', 'Vencida' => 'danger', 'Cancelada' => 'secondary'];
                    ?>
                    <span class="badge fs-6 text-bg-<?= $statusClass[$fatura['status']] ?? 'light' ?>"><?= esc($fatura['status']) ?></span>
                </p>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted">
        Fatura criada em: <?= date('d/m/Y \à\s H:i', strtotime($fatura['created_at'])) ?>
    </div>
</div>

<?= $this->endSection() ?>