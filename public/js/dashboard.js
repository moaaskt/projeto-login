document.addEventListener('DOMContentLoaded', function () {
  // Chart de Status de Faturas (Donut)
  const statusEl = document.querySelector("#statusChart");
  const statusSeries = JSON.parse(statusEl.dataset.series);
  const statusChart = new ApexCharts(statusEl, {
    chart: {
      type: 'donut',
      height: 350
    },
    theme: { mode: 'dark' },
    labels: ['Paga', 'Vencida', 'Cancelada', 'Pendente'],
    series: statusSeries,
    legend: { position: 'bottom' }
  });
  statusChart.render();

  // Chart de Novos Clientes por Mês (Bar)
  const clientesEl = document.querySelector("#clientesChart");
  const clientesSeries = JSON.parse(clientesEl.dataset.series);
  const clientesCategories = JSON.parse(clientesEl.dataset.categories);
  const clientesChart = new ApexCharts(clientesEl, {
    chart: {
      type: 'bar',
      height: 350
    },
    theme: { mode: 'dark' },
    series: [{
      name: 'Novos Clientes',
      data: clientesSeries
    }],
    xaxis: {
      categories: clientesCategories
    }
  });
  clientesChart.render();
});
