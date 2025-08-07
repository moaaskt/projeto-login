<?= $this->extend('painel/templates/default') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="dashboard-wrapper">
  <div class="dashboard-grid">
    <!-- Donut: Distribuição de Status -->
    <div class="grid-item card-donut">
      <h6 class="chart-title">Distribuição de Status</h6>
      <div id="statusChart"
        data-series='<?= $statusChart['series'] ?>'
        data-labels='<?= $statusChart['labels'] ?>'>
      </div>
    </div>

    <!-- Área: Novos Clientes -->
    <div class="grid-item card-line">
      <h6 class="chart-title">Novos Clientes por Mês</h6>
      <div id="clientesChart"
        data-series='<?= $clientesChart['series'] ?>'
        data-categories='<?= $clientesChart['categories'] ?>'>
      </div>
    </div>

    <!-- Colunas: Visão Geral Mensal -->
    <div class="grid-item card-bar" style="grid-column: span 2;">
      <h6 class="chart-title">Visão Geral Mensal</h6>
      <div id="comparisonChart"
        data-labels='<?= $comparisonChart['labels'] ?>'
        data-revenue='<?= $comparisonChart['revenue'] ?>'
        data-billed='<?= $comparisonChart['billed'] ?>'
        data-clients='<?= $comparisonChart['clients'] ?>'>
      </div>
    </div>
  </div>
</div>



 <script src="<?= base_url('js/dashboard.js') ?>"></script>
<?= $this->endSection() ?>