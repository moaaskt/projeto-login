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
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribuição de Status</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4">
                    <div id="donutChart"></div>
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
                    <div id="barChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Passando os dados do PHP (Controller) para o JavaScript
    const statusLabels = <?= $statusLabels ?>;
    const statusSeries = <?= $statusSeries ?>;
    const clientLabels = <?= $clientLabels ?>;
    const clientSeries = <?= $clientSeries ?>;

    // Configurações do Gráfico de Rosca (Donut)
    var donutOptions = {
      series: statusSeries,
      chart: {
        type: 'donut',
        height: 350,
      },
      labels: statusLabels,
      theme: {
          monochrome: {
              enabled: true,
              color: '#6366f1',
              shadeTo: 'dark',
              shadeIntensity: 0.65
          }
      },
      plotOptions: {
          pie: {
              donut: {
                  labels: {
                      show: true,
                      total: {
                          show: true,
                          label: 'Total',
                          color: '#fff'
                      }
                  }
              }
          }
      },
      legend: {
          labels: { colors: ['#fff'] }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };
    var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutOptions);
    donutChart.render();

    // Configurações do Gráfico de Barras
    var barOptions = {
      series: [{
          name: 'Novos Clientes',
          data: clientSeries
      }],
      chart: {
        height: 350,
        type: 'bar',
      },
      plotOptions: {
        bar: {
          borderRadius: 10,
          dataLabels: {
            position: 'top', // top, center, bottom
          },
        }
      },
      dataLabels: {
        enabled: true,
        offsetY: -20,
        style: {
          fontSize: '12px',
          colors: ["#fff"]
        }
      },
      xaxis: {
        categories: clientLabels,
        position: 'top',
        axisBorder: { show: false },
        axisTicks: { show: false },
        tooltip: { enabled: true },
        labels: { style: { colors: '#fff' } }
      },
      yaxis: {
        axisBorder: { show: false },
        axisTicks: { show: false },
        labels: {
          show: false,
        }
      },
      theme: {
          palette: 'palette2' // Ou palette1, palette2, etc.
      }
    };
    var barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
    barChart.render();
</script>
<?= $this->endSection() ?>