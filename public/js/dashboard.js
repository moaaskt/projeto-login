document.addEventListener('DOMContentLoaded', function () {

  // Helper para base options comuns
  const commonOpts = {
    chart: { foreColor: '#cbd5e1', animations: { enabled: true } },
    tooltip: { theme: 'dark' },
    legend: { labels: { colors: '#cbd5e1' } }
  };

  // Donut com gradientes
  const statusEl = document.getElementById('statusChart');
  if (statusEl) {
    const series = JSON.parse(statusEl.getAttribute('data-series'));
    const labels = JSON.parse(statusEl.getAttribute('data-labels'));
    const opts = {
      ...commonOpts,
      chart: { ...commonOpts.chart, type: 'donut' },
      series,
      labels,
      plotOptions: {
        pie: {
          donut: {
            size: '70%',
            labels: {
              show: true,
              total: { show: true, label: 'Total', color: '#fff', formatter: () => `${series.reduce((a,b)=>a+b,0)} faturas` }
            }
          }
        }
      },
      fill: { type: 'gradient' },
      stroke: { show: true, width: 2, colors: ['#0f172a'] },
      dataLabels: { enabled: true },
      colors: ['#10b981', '#f59e0b', '#ef4444', '#3b82f6']
    };
    new ApexCharts(statusEl, opts).render();
  }

  // Área de clientes
  const clientsEl = document.getElementById('clientesChart');
  if (clientsEl) {
    const series = JSON.parse(clientsEl.getAttribute('data-series'));
    const cats = JSON.parse(clientsEl.getAttribute('data-categories'));
    const opts = {
      ...commonOpts,
      chart: { ...commonOpts.chart, type: 'area', height: '95%' },
      series: [{ name: 'Novos Clientes', data: series }],
      xaxis: { categories: cats, labels: { style: { colors: '#ccc' } } },
      yaxis: { labels: { style: { colors: '#ccc' }, formatter: val => val.toFixed(0) } },
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth', width: 2 },
      fill: { type: 'gradient', gradient: { opacityFrom: 0.6, opacityTo: 0.1 } },
      grid: { borderColor: '#334155' }
    };
    new ApexCharts(clientsEl, opts).render();
  }

  // Colunas comparativas
  const cmpEl = document.getElementById('comparisonChart');
  if (cmpEl) {
    const labels = JSON.parse(cmpEl.getAttribute('data-labels'));
    const rev = JSON.parse(cmpEl.getAttribute('data-revenue'));
    const bill = JSON.parse(cmpEl.getAttribute('data-billed'));
    const cli = JSON.parse(cmpEl.getAttribute('data-clients'));
    const opts = {
      ...commonOpts,
      chart: { ...commonOpts.chart, type: 'bar', height: '95%' },
      series: [
        { name: 'Faturamento (R$)', data: rev },
        { name: 'Total Emitido (R$)', data: bill },
        { name: 'Novos Clientes', data: cli }
      ],
      xaxis: { categories: labels, labels: { style: { colors: '#ccc' } } },
      yaxis: { title: { text: 'Valores', style: { color: '#ccc' } }, labels: { style: { colors: '#ccc' } } },
      plotOptions: { bar: { columnWidth: '55%' } },
      dataLabels: { enabled: false },
      stroke: { show: true, width: 2, colors: ['transparent'] },
      fill: { opacity: 1 },
      colors: ['#008FFB', '#00E396', '#FEB019'],
      tooltip: {
        y: {
          formatter: (val, { seriesIndex }) => seriesIndex < 2
            ? `R$ ${val.toFixed(2).replace('.', ',')}`
            : `${val} clientes`
        }
      },
      grid: { borderColor: '#475569' }
    };
    new ApexCharts(cmpEl, opts).render();
  }
});
