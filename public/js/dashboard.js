document.addEventListener('DOMContentLoaded', function () {
    // ----- Gráfico Distribuição de Status (donut) -----
    const statusEl = document.getElementById('statusChart');
    if (statusEl) {
        const seriesStatus = JSON.parse(statusEl.getAttribute('data-series'));
        const labelsStatus = JSON.parse(statusEl.getAttribute('data-labels'));

        const optionsStatus = {
            chart: { type: 'donut', height: 350, foreColor: '#cbd5e1' },
            series: seriesStatus,
            labels: labelsStatus,
            colors: ['#22c55e', '#ef4444', '#fbbf24', '#f97316'],
            legend: { position: 'bottom', labels: { colors: '#94a3b8' } },
            tooltip: {
                fillSeriesColor: false,
                y: { formatter: function (val) { return val + ' fatura(s)'; } }
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
            chart: { type: 'area', height: 350, foreColor: '#cbd5e1', toolbar: { show: false } },
            series: [{ name: 'Clientes Novos', data: seriesClientes }],
            xaxis: { categories: categoriesClientes, axisBorder: { color: '#475569' }, axisTicks: { color: '#475569' } },
            yaxis: { labels: { formatter: function (val) { return val.toFixed(0); } } },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.6, opacityTo: 0, stops: [0, 90, 100] }
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: { formatter: function (val) { return val + ' clientes'; } }
            },
            grid: { borderColor: '#334155', strokeDashArray: 3 }
        };
        const chartClientes = new ApexCharts(clientesEl, optionsClientes);
        chartClientes.render();
    }

    // ----- GRÁFICO DE FATURAMENTO MENSAL (NOVO) -----
    const revenueEl = document.getElementById('revenueChart');
    if (revenueEl) {
        const seriesRevenue = JSON.parse(revenueEl.getAttribute('data-series'));
        const labelsRevenue = JSON.parse(revenueEl.getAttribute('data-labels'));

        const optionsRevenue = {
            series: [{
                name: 'Faturamento R$',
                data: seriesRevenue
            }],
            chart: {
                type: 'bar',
                height: 350,
                foreColor: '#cbd5e1'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 4
                },
            },
            dataLabels: { enabled: false },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: labelsRevenue,
                labels: { style: { colors: '#cbd5e1' } }
            },
            yaxis: {
                title: { text: 'R$ (reais)', style: { color: '#cbd5e1' } },
                labels: { style: { colors: '#cbd5e1' } }
            },
            fill: { opacity: 1 },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val) {
                        return "R$ " + val.toFixed(2).replace('.', ',');
                    }
                }
            },
            grid: { borderColor: '#334155' }
        };

        const chartRevenue = new ApexCharts(revenueEl, optionsRevenue);
        chartRevenue.render();
    }
});