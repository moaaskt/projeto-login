document.addEventListener("DOMContentLoaded", function () {
    Apex.chart = {
        foreColor: '#ccc'
    };

    var statusOptions = {
        series: statusChartData.series,
        labels: statusChartData.labels,
        chart: {
            type: 'donut',
            height: 350,
            foreColor: '#ccc'
        },
        theme: { mode: 'dark' },
        colors: ['#00E396', '#FEB019', '#FF4560', '#775DD0'],
        legend: { position: 'bottom' },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%'
                }
            }
        },
        dataLabels: { enabled: true },
        tooltip: { theme: 'dark' },
        responsive: [{
            breakpoint: 576,
            options: { chart: { height: 250 } }
        }]
    };
    new ApexCharts(document.querySelector("#statusDistributionChart"), statusOptions).render();

    var revenueOptions = {
        series: [{
            name: revenueChartData.name,
            data: revenueChartData.data
        }],
        chart: {
            type: 'area',
            height: 350,
            toolbar: { show: false },
            foreColor: '#ccc'
        },
        theme: { mode: 'dark' },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                gradientToColors: ['#ABE5A1'],
                shadeIntensity: 1,
                type: 'horizontal',
                opacityFrom: 0.7,
                opacityTo: 0.2,
                stops: [0, 100]
            }
        },
        xaxis: {
            categories: revenueChartData.categories
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return "R$ " + val.toFixed(2).replace('.', ',');
                }
            }
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function (val) {
                    return "R$ " + val.toFixed(2).replace('.', ',');
                }
            }
        },
        grid: {
            borderColor: '#444',
            strokeDashArray: 4
        }
    };
    new ApexCharts(document.querySelector("#monthlyRevenueChart"), revenueOptions).render();
});
