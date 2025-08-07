<?= $this->extend('portal/templates/default') ?>

<?= $this->section('title') ?><?= esc($title) ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<a href="<?= base_url('portal/faturas') ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Voltar para a lista</a>

<h1 class="h3 mb-4">Detalhes da Fatura #<?= esc($fatura['id']) ?></h1>

<div class="card">
    <div class="card-body">
        <h3><?= esc($fatura['descricao']) ?></h3>
        <hr>
        <dl class="row">
            <dt class="col-sm-3">Status:</dt>
            <dd class="col-sm-9">
                <span class="badge bg-<?= $fatura['status'] === 'paga' ? 'success' : 'warning' ?>"><?= ucfirst($fatura['status']) ?></span>
            </dd>

            <dt class="col-sm-3">Valor:</dt>
            <dd class="col-sm-9"><strong>R$ <?= number_format($fatura['valor'], 2, ',', '.') ?></strong></dd>

            <dt class="col-sm-3">Data de Emissão:</dt>
            <dd class="col-sm-9"><?= date('d/m/Y', strtotime($fatura['created_at'])) ?></dd>
            
            <dt class="col-sm-3">Data de Vencimento:</dt>
            <dd class="col-sm-9"><?= date('d/m/Y', strtotime($fatura['data_vencimento'])) ?></dd>
        </dl>
        <hr>

        <?php if ($fatura['status'] !== 'paga'): ?>
            <a href="<?= base_url('portal/faturas/pagar/' . $fatura['id']) ?>" class="btn btn-success btn-lg">
                <i class="fas fa-dollar-sign"></i> Pagar Fatura
            </a>
        <?php else: ?>
            <p class="text-success"><i class="fas fa-check-circle"></i> Esta fatura já foi paga. Obrigado!</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>