document.addEventListener('DOMContentLoaded', function () {

    // ----- Gráfico 1: Distribuição de Status (Donut) -----
    const statusEl = document.getElementById('statusChart');
    if (statusEl) {
        const seriesStatus = JSON.parse(statusEl.getAttribute('data-series'));
        const labelsStatus = JSON.parse(statusEl.getAttribute('data-labels'));

        const optionsStatus = {
            chart: { type: 'donut', height: 350, foreColor: '#cbd5e1' },
            series: seriesStatus,
            labels: labelsStatus,
            theme: { monochrome: { enabled: true, color: '#6366f1', shadeTo: 'dark', shadeIntensity: 0.65 }},
            plotOptions: { pie: { donut: { labels: { show: true, total: { show: true, label: 'Total', color: '#fff' }}}}},
            legend: { labels: { colors: ['#fff'] }},
        };
        const chartStatus = new ApexCharts(statusEl, optionsStatus);
        chartStatus.render();
    }

    // ----- Gráfico 2: Novos Clientes por Mês (Área) -----
    const clientesEl = document.getElementById('clientesChart');
    if (clientesEl) {
        const seriesClientes = JSON.parse(clientesEl.getAttribute('data-series'));
        const categoriesClientes = JSON.parse(clientesEl.getAttribute('data-categories'));

        const optionsClientes = {
            chart: { type: 'area', height: 350, foreColor: '#cbd5e1', toolbar: { show: false } },
            series: [{ name: 'Clientes Novos', data: seriesClientes }],
            xaxis: { categories: categoriesClientes, axisBorder: { color: '#475569' }, axisTicks: { color: '#475569' }, labels: { style: { colors: '#ccc' } } },
            yaxis: { labels: { style: { colors: '#ccc' }, formatter: function (val) { return val.toFixed(0); } }},
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.6, opacityTo: 0.1, stops: [0, 90, 100] }},
            grid: { borderColor: '#334155', strokeDashArray: 3 }
        };
        const chartClientes = new ApexCharts(clientesEl, optionsClientes);
        chartClientes.render();
    }

    // ----- Gráfico 3: Comparativo Mensal (Colunas) -----
    const comparisonEl = document.getElementById('comparisonChart');
    if (comparisonEl) {
        const labels = JSON.parse(comparisonEl.getAttribute('data-labels'));
        const revenueSeries = JSON.parse(comparisonEl.getAttribute('data-revenue'));
        const billedSeries = JSON.parse(comparisonEl.getAttribute('data-billed'));
        const clientSeries = JSON.parse(comparisonEl.getAttribute('data-clients'));

        const options = {
            series: [
                { name: 'Faturamento (R$)', data: revenueSeries },
                { name: 'Total Emitido (R$)', data: billedSeries },
                { name: 'Novos Clientes', data: clientSeries }
            ],
            chart: { type: 'bar', height: 400, foreColor: '#ccc' },
            plotOptions: { bar: { horizontal: false, columnWidth: '55%' }},
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: { categories: labels, labels: { style: { colors: '#ccc' } }},
            yaxis: { title: { text: 'Valores', style: { color: '#ccc' } }, labels: { style: { colors: '#ccc' } }},
            fill: { opacity: 1 },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val, { seriesIndex }) {
                        if (seriesIndex < 2) {
                            return "R$ " + val.toFixed(2).replace('.', ',');
                        } else {
                            return val + " clientes";
                        }
                    }
                }
            },
            colors: ['#008FFB', '#00E396', '#FEB019'],
            grid: { borderColor: '#555' }
        };
        const comparisonChart = new ApexCharts(comparisonEl, options);
        comparisonChart.render();
    }
});