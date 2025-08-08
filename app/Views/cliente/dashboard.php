<?= $this->extend('cliente/templates/default') ?>

<?= $this->section('title') ?><?= esc($titulo ?? 'Dashboard') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-success border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">Valor Total Pago</div>
                            <div class="h5 mb-0 fw-bold">R$ <?= number_format($stats['total_pago'] ?? 0, 2, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-body-tertiary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-warning border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Valor Pendente</div>
                            <div class="h5 mb-0 fw-bold">R$ <?= number_format($stats['total_pendente'] ?? 0, 2, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-body-tertiary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-danger border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">Valor Vencido</div>
                            <div class="h5 mb-0 fw-bold">R$ <?= number_format($stats['total_vencido'] ?? 0, 2, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-times fa-2x text-body-tertiary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-primary border-4 shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total de Faturas</div>
                            <div class="h5 mb-0 fw-bold"><?= esc($stats['total_faturas'] ?? 0) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-invoice fa-2x text-body-tertiary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Histórico de Pagamentos (Últimos 6 Meses)</h6>
                </div>
                <div class="card-body">
                    <div id="monthlyRevenueChart" style="min-height: 325px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Situação das Faturas</h6>
                </div>
                <div class="card-body">
                    <div id="statusDistributionChart" style="min-height: 325px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Garante que o DOM está carregado antes de criar os gráficos
document.addEventListener("DOMContentLoaded", function() {

    // 1. Gráfico de Distribuição de Status (Donut)
    var statusOptions = {
        series: <?= json_encode($status_distribution['data'] ?? [0,0,0,0]) ?>,
        labels: <?= json_encode($status_distribution['labels'] ?? []) ?>,
        chart: { type: 'donut', height: 350, foreColor: '#c9d1d9' },
        colors: ['#238636', '#d29922', '#da3633', '#8b949e'], // Cores para Paga, Pendente, Vencida, Cancelada
        legend: { position: 'bottom' },
        responsive: [{
            breakpoint: 480,
            options: { chart: { width: 200 }, legend: { position: 'bottom' } }
        }]
    };
    var statusChart = new ApexCharts(document.querySelector("#statusDistributionChart"), statusOptions);
    statusChart.render();

    // 2. Gráfico de Receita Mensal (Área)
    var revenueOptions = {
        series: [{
            name: '<?= esc($monthly_revenue['series']['name'] ?? 'Valor Pago') ?>',
            data: <?= json_encode($monthly_revenue['series']['data'] ?? []) ?>
        }],
        chart: { type: 'area', height: 350, toolbar: { show: false }, foreColor: '#c9d1d9' },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: {
            type: 'category',
            categories: <?= json_encode($monthly_revenue['categories'] ?? []) ?>
        },
        yaxis: {
            labels: {
                formatter: function (val) { return "R$ " + val.toFixed(2).replace('.', ',') }
            }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function (val) { return "R$ " + val.toFixed(2).replace('.', ',') }
            }
        },
        grid: {
            borderColor: '#30363d'
        }
    };
    var revenueChart = new ApexCharts(document.querySelector("#monthlyRevenueChart"), revenueOptions);
    revenueChart.render();
});
</script>
<?= $this->endSection() ?>