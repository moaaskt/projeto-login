<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-wrapper">
  <div class="dashboard-grid">
    <!-- Donut: Distribuição de Status -->
    <div class="grid-item card-donut">
      <h6 class="chart-title">Distribuição de Status</h6>
      <div id="statusChart"
           data-series='<?= $statusSeries ?>'
           data-labels='<?= $statusLabels ?>'>
      </div>
    </div>

    <!-- Área: Novos Clientes -->
    <div class="grid-item card-line">
      <h6 class="chart-title">Novos Clientes por Mês</h6>
      <div id="clientesChart"
           data-series='<?= $clientSeries ?>'
           data-categories='<?= $clientLabels ?>'>
      </div>
    </div>

    <!-- Colunas: Visão Geral Mensal -->
    <div class="grid-item card-bar" style="grid-column: span 2;">
      <h6 class="chart-title">Visão Geral Mensal</h6>
      <div id="comparisonChart"
           data-labels='<?= $chartLabels ?>'
           data-revenue='<?= $revenueSeries ?>'
           data-billed='<?= $billedSeries ?>'
           data-clients='<?= $clientSeries ?>'>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
