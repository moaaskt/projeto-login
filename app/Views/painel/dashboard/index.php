<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-lg col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2" style="border-left: 5px solid #6366f1;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total de Faturas</div>
                        <div class="h5 mb-0 font-weight-bold"><?= $stats['total']['count'] ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-file-invoice-dollar fa-2x text-secondary"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2" style="border-left: 5px solid #10b981;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Faturas Pagas</div>
                        <div class="h5 mb-0 font-weight-bold"><?= $stats['Paga']['count'] ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-secondary"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2" style="border-left: 5px solid #f59e0b;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Faturas Pendentes</div>
                        <div class="h5 mb-0 font-weight-bold"><?= $stats['Pendente']['count'] ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-clock fa-2x text-secondary"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Visão Geral Mensal</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <div id="comparisonChart" 
                        data-labels='<?= $chartLabels ?>'
                        data-revenue='<?= $revenueSeries ?>'
                        data-billed='<?= $billedSeries ?>'
                        data-clients='<?= $clientSeries ?>'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>