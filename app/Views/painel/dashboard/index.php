<?= $this->extend('painel/templates/default') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">TOTAL DE FATURAS</h5>
                <p class="card-text display-4"><?= $stats['total']['count'] ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">FATURAS PAGAS</h5>
                <p class="card-text display-4"><?= $stats['Paga']['count'] ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">FATURAS PENDENTES</h5>
                <p class="card-text display-4"><?= $stats['Pendente']['count'] ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Distribuição de Status</div>
            <div class="card-body">
                <div id="statusChart"
                    data-series='<?= json_encode([$stats["Paga"]["count"], $stats["Vencida"]["count"], $stats["Cancelada"]["count"], $stats["Pendente"]["count"]]) ?>'>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Novos Clientes por Mês</div>
            <div class="card-body">
                <div id="clientesChart"
                    data-series='<?= $clientSeries ?>'
                    data-categories='<?= $clientLabels ?>'>
                </div>
            </div>
        </div>
    </div>
</div>







<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="<?= base_url('js/dashboard.js') ?>"></script>
<?= $this->endSection() ?>