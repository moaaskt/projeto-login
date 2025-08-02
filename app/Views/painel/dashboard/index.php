<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bem-vindo de volta!</h5>
                    <p class="card-text">Seu e-mail é: <?= esc($email ?? 'Não encontrado') ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2" style="border-left: 5px solid #6366f1;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tickets Criados</div>
                            <div class="h5 mb-0 font-weight-bold">120</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-secondary"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2" style="border-left: 5px solid #10b981;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tickets Resolvidos</div>
                            <div class="h5 mb-0 font-weight-bold">90</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-check-circle fa-2x text-secondary"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2" style="border-left: 5px solid #f59e0b;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tickets Pendentes</div>
                            <div class="h5 mb-0 font-weight-bold">30</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clock fa-2x text-secondary"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2" style="border-left: 5px solid #ef4444;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tickets Cancelados</div>
                            <div class="h5 mb-0 font-weight-bold">5</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-times-circle fa-2x text-secondary"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Visão Geral de Tickets</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 320px;">
                        <canvas id="ticketsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Fontes de Tickets</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4" style="height: 320px;">
                        <canvas id="ticketTypesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuração para o gráfico de linha
    new Chart(document.getElementById('ticketsChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            datasets: [{
                label: "Tickets Criados",
                borderColor: "#6366f1",
                data: [20, 30, 45, 40, 50, 70],
            }],
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Configuração para o gráfico de pizza
    new Chart(document.getElementById('ticketTypesChart'), {
        type: 'doughnut',
        data: {
            labels: ['Vendas', 'Suporte', 'Bug'],
            datasets: [{
                data: [55, 30, 15],
                backgroundColor: ['#6366f1', '#10b981', '#ef4444'],
            }],
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
<?= $this->endSection() ?>