<?= $this->extend('cliente/templates/default') ?>

<?= $this->section('title') ?><?= esc($titulo ?? 'Dashboard') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>


<link rel="stylesheet" href="<?= base_url('css/dashboard/styledashCliente.css') ?>">


<div class="container-fluid py-4">
    <!-- Título -->

    <!-- Cards de estatísticas -->
    <div class="row g-4">
        <!-- Total Pago -->
        <div class="col-sm-6 col-lg-3">
            <div class="card card-custom h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-muted text-uppercase small">Valor Total Pago</p>
                        <h5 class="mb-0 fw-bold">R$ <?= number_format($stats['total_pago'] ?? 0, 2, ',', '.') ?></h5>
                    </div>
                    <div class="icon-shape bg-success text-white rounded-circle">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendente -->
        <div class="col-sm-6 col-lg-3">
            <div class="card card-custom h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-muted text-uppercase small">Valor Pendente</p>
                        <h5 class="mb-0 fw-bold">R$ <?= number_format($stats['total_pendente'] ?? 0, 2, ',', '.') ?></h5>
                    </div>
                    <div class="icon-shape bg-warning text-white rounded-circle">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vencido -->
        <div class="col-sm-6 col-lg-3">
            <div class="card card-custom h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-muted text-uppercase small">Valor Vencido</p>
                        <h5 class="mb-0 fw-bold">R$ <?= number_format($stats['total_vencido'] ?? 0, 2, ',', '.') ?></h5>
                    </div>
                    <div class="icon-shape bg-danger text-white rounded-circle">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Faturas -->
        <div class="col-sm-6 col-lg-3">
            <div class="card card-custom h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="mb-1 text-muted text-uppercase small">Total de Faturas</p>
                        <h5 class="mb-0 fw-bold"><?= esc($stats['total_faturas'] ?? 0) ?></h5>
                    </div>
                    <div class="icon-shape bg-primary text-white rounded-circle">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Linha de gráficos -->
    <div class="row mt-4 g-4">
        <!-- Gráfico de Receita Mensal -->
        <div class="col-lg-8">
            <div class="card card-custom h-100">
                <div class="card-header border-0">
                    <h6 class="mb-0 fw-bold">Histórico de Pagamentos</h6>
                    <small class="text-muted">Últimos 6 meses</small>
                </div>
                <div class="card-body">
                    <div id="monthlyRevenueChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Distribuição -->
        <div class="col-lg-4">
            <div class="card card-custom h-100">
                <div class="card-header border-0">
                    <h6 class="mb-0 fw-bold">Situação das Faturas</h6>
                    <small class="text-muted">Distribuição atual</small>
                </div>
                <div class="card-body">
                    <div id="statusDistributionChart" style="min-height: 360px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const statusChartData = {
        series: <?= json_encode($status_distribution['data'] ?? [0, 0, 0, 0]) ?>,
        labels: <?= json_encode($status_distribution['labels'] ?? []) ?>
    };

    const revenueChartData = {
        name: "<?= esc($monthly_revenue['series']['name'] ?? 'Valor Pago') ?>",
        data: <?= json_encode($monthly_revenue['series']['data'] ?? []) ?>,
        categories: <?= json_encode($monthly_revenue['categories'] ?? []) ?>
    };
</script>

<!-- Corrigido: Sem "public/" -->
<script src="<?= base_url('js/dashboardCliente.js') ?>"></script>

<?= $this->endSection() ?>