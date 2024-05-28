<x-admin.nav>

    <div>
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

        <script>
            const ctx = document.getElementById('myChart');
            Chart.register(ChartDataLabels);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($x_axis),
                datasets: [{
                    label: '# of Jobs Closed this Month',
                    data: @json($y_axis),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        color: 'blue',
                        font: {
                            weight: 'bold',
                        },
                        formatter: function(value, context) {
                            return value;
                        }
                    }
                }
            }
        });
    </script>


</x-admin.nav>
