/**
 * Inicializa os gráficos da dashboard do cliente
 * Este script espera que as constantes 'statusChartData' e 'revenueChartData'
 * já existam na página, vindas da view PHP.
 */
document.addEventListener("DOMContentLoaded", function() {

    // 1. Opções para o Gráfico de Situação das Faturas (Donut)
    const statusOptions = {
        series: statusChartData.series,
        labels: statusChartData.labels,
        chart: {
            type: 'donut',
            height: 360,
            foreColor: '#c9d1d9' // Cor do texto para tema escuro
        },
        colors: ['#238636', '#d29922', '#da3633', '#8b949e'], // Cores para Paga, Pendente, Vencida, Cancelada
        dataLabels: {
            enabled: false // Remove os textos de porcentagem de dentro das fatias
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: function (w) {
                                // Soma todos os valores da série para mostrar o total no centro
                                return w.globals.seriesTotals.reduce((a, b) => { return a + b }, 0)
                            }
                        }
                    }
                }
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            // CORREÇÃO APLICADA: Adiciona um espaçamento vertical de 10px
            offsetY: 10,
            itemMargin: {
                vertical: 5
            }
        }
    };

    // Renderiza o gráfico de Donut, se o elemento existir na página
    const statusChartEl = document.querySelector("#statusDistributionChart");
    if (statusChartEl) {
        const statusChart = new ApexCharts(statusChartEl, statusOptions);
        statusChart.render();
    }


    // 2. Opções para o Gráfico de Histórico de Pagamentos (Área)
    const revenueOptions = {
        series: [{
            name: revenueChartData.name,
            data: revenueChartData.data
        }],
        chart: {
            type: 'area',
            height: 350,
            toolbar: { show: false },
            foreColor: '#c9d1d9'
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: {
            type: 'category',
            categories: revenueChartData.categories,
            labels: {
                style: {
                    colors: '#8b949e'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#8b949e'
                },
                formatter: function (val) { return "R$ " + val.toFixed(2).replace('.', ',') }
            }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function (val) { return "R$ " + val.toFixed(2).replace('.', ',') }
            }
        },
        grid: {
            borderColor: '#30363d'
        }
    };

    // Renderiza o gráfico de Área, se o elemento existir na página
    const revenueChartEl = document.querySelector("#monthlyRevenueChart");
    if (revenueChartEl) {
        const revenueChart = new ApexCharts(revenueChartEl, revenueOptions);
        revenueChart.render();
    }
});