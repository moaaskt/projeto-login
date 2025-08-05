<?= $this->extend('painel/templates/default') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribuição de Status</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4">
                    <div id="statusChart" 
                         data-series='<?= $statusSeries ?>'
                         data-labels='<?= $statusLabels ?>'>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Novos Clientes por Mês</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <div id="clientesChart"
                         data-series='<?= $clientSeries ?>'
                         data-categories='<?= $clientLabels ?>'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Faturamento Mensal (Faturas Pagas)</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <div id="revenueChart" 
                         data-series='<?= $revenueSeries ?>' 
                         data-labels='<?= $revenueLabels ?>'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<?= $this->endSection() ?>
<?= $this->section('scripts') ?>

<?= $this->endSection() ?>