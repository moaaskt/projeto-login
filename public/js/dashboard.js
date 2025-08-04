document.addEventListener("DOMContentLoaded", function () {
    // Gráfico de Status das Faturas
    const elStatus = document.querySelector('#graficoStatus');
    if (elStatus) {
        const statusSeries = JSON.parse(elStatus.dataset.series);

        new ApexCharts(elStatus, {
            chart: {
                type: 'donut',
                background: '#1e293b'
            },
            series: statusSeries,
            labels: ['Pagas', 'Vencidas', 'Canceladas', 'Pendentes'],
            colors: ['#22c55e', '#f97316', '#ef4444', '#facc15'],
            legend: { labels: { colors: '#f1f5f9' } }
        }).render();
    }

    // Gráfico de Novos Clientes
    const elClientes = document.querySelector('#graficoClientes');
    if (elClientes) {
        const clientesSeries = JSON.parse(elClientes.dataset.series);
        const clientesLabels = JSON.parse(elClientes.dataset.categories);

        new ApexCharts(elClientes, {
            chart: {
                type: 'bar',
                background: '#1e293b'
            },
            series: [{
                name: 'Clientes',
                data: clientesSeries
            }],
            xaxis: {
                categories: clientesLabels,
                labels: { style: { colors: '#f1f5f9' } }
            },
            yaxis: {
                labels: { style: { colors: '#f1f5f9' } }
            },
            colors: ['#38bdf8'],
            legend: { labels: { colors: '#f1f5f9' } }
        }).render();
    }
});
