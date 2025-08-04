document.addEventListener('DOMContentLoaded', function () {
  // ----- Gráfico Distribuição de Status (donut) -----
  const statusEl = document.getElementById('statusChart');
  if (statusEl) {
    const seriesStatus = JSON.parse(statusEl.getAttribute('data-series'));

    const optionsStatus = {
      chart: {
        type: 'donut',
        height: 350,
        foreColor: '#cbd5e1', // texto claro
        animations: { enabled: true, easing: 'easeinout', speed: 800 },
        toolbar: { show: false },
      },
      series: seriesStatus,
      labels: ['Pagas', 'Vencidas', 'Canceladas', 'Pendentes'],
      colors: ['#22c55e', '#ef4444', '#fbbf24', '#f97316'],
      legend: {
        position: 'bottom',
        labels: { colors: '#94a3b8' },
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: ['#16a34a', '#b91c1c', '#ca8a04', '#ea580c'],
          inverseColors: true,
          opacityFrom: 0.85,
          opacityTo: 0.85,
          stops: [0, 100]
        }
      },
      tooltip: {
        fillSeriesColor: false,
        y: {
          formatter: function (val) {
            return val + ' fatur(a)s';
          }
        }
      }
    };

    const chartStatus = new ApexCharts(statusEl, optionsStatus);
    chartStatus.render();
  }


  // ----- Gráfico Novos Clientes por Mês (área) -----
  const clientesEl = document.getElementById('clientesChart');
  if (clientesEl) {
    const seriesClientes = JSON.parse(clientesEl.getAttribute('data-series'));
    const categoriesClientes = JSON.parse(clientesEl.getAttribute('data-categories'));

    const optionsClientes = {
      chart: {
        type: 'area',
        height: 350,
        foreColor: '#cbd5e1',
        animations: { enabled: true, easing: 'easeinout', speed: 800 },
        toolbar: { show: false },
      },
      series: [{
        name: 'Clientes Novos',
        data: seriesClientes
      }],
      xaxis: {
        categories: categoriesClientes,
        axisBorder: { color: '#475569' },
        axisTicks: { color: '#475569' },
      },
      yaxis: {
        labels: {
          formatter: function (val) {
            return val.toFixed(0);
          }
        }
      },
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth', width: 3 },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.6,
          opacityTo: 0,
          stops: [0, 90, 100]
        }
      },
      tooltip: {
        shared: true,
        intersect: false,
        y: {
          formatter: function (val) {
            return val + ' clientes';
          }
        }
      },
      grid: {
        borderColor: '#334155',
        strokeDashArray: 3
      }
    };

    const chartClientes = new ApexCharts(clientesEl, optionsClientes);
    chartClientes.render();
  }


  // ----- Gráfico alternativo para "graficoStatus" (donut, dark background) -----
  const graficoStatusEl = document.getElementById('graficoStatus');
  if (graficoStatusEl) {
    const series = JSON.parse(graficoStatusEl.getAttribute('data-series'));
    const options = {
      chart: {
        type: 'donut',
        height: 300,
        background: '#1e293b',
        foreColor: '#e2e8f0',
        animations: { enabled: true, easing: 'easeinout', speed: 800 },
        toolbar: { show: false },
      },
      series: series,
      labels: ['Pagas', 'Vencidas', 'Canceladas', 'Pendentes'],
      colors: ['#22c55e', '#ef4444', '#fbbf24', '#f97316'],
      legend: {
        position: 'bottom',
        labels: { colors: '#94a3b8' },
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          type: 'horizontal',
          shadeIntensity: 0.7,
          gradientToColors: ['#16a34a', '#b91c1c', '#ca8a04', '#ea580c'],
          opacityFrom: 0.85,
          opacityTo: 0.85,
          stops: [0, 100]
        }
      },
      tooltip: {
        fillSeriesColor: false,
        y: {
          formatter: function (val) {
            return val + ' fatur(a)s';
          }
        }
      }
    };
    const chart = new ApexCharts(graficoStatusEl, options);
    chart.render();
  }


  // ----- Gráfico alternativo para "graficoClientes" (linha) -----
  const graficoClientesEl = document.getElementById('graficoClientes');
  if (graficoClientesEl) {
    const series = JSON.parse(graficoClientesEl.getAttribute('data-series'));
    const categories = JSON.parse(graficoClientesEl.getAttribute('data-categories'));

    const options = {
      chart: {
        type: 'line',
        height: 300,
        background: '#1e293b',
        foreColor: '#e2e8f0',
        animations: { enabled: true, easing: 'easeinout', speed: 800 },
        toolbar: { show: false },
      },
      series: [{
        name: 'Clientes Novos',
        data: series
      }],
      xaxis: {
        categories: categories,
        axisBorder: { color: '#475569' },
        axisTicks: { color: '#475569' },
      },
      yaxis: {
        labels: {
          formatter: function (val) {
            return val.toFixed(0);
          }
        }
      },
      stroke: { curve: 'smooth', width: 3 },
      dataLabels: { enabled: false },
      grid: {
        borderColor: '#334155',
        strokeDashArray: 3
      },
      tooltip: {
        shared: true,
        intersect: false,
        y: {
          formatter: function (val) {
            return val + ' clientes';
          }
        }
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.7,
          opacityTo: 0.1,
          stops: [0, 90, 100]
        }
      }
    };

    const chart = new ApexCharts(graficoClientesEl, options);
    chart.render();
  }
});
