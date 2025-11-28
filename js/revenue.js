const ctx = document.getElementById('twxstatRevenueChart').getContext('2d');

const twxstatRevenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartLabels,      // lấy từ HTML
        datasets: [{
            label: 'Doanh thu theo ngày',
            data: chartValues,    // lấy từ HTML
            backgroundColor: 'rgba(255,50,50,0.3)',
            borderColor: 'rgba(255,0,0,1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointHoverRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: { color: '#fff' }
            },
            tooltip: {
                callbacks: {
                    label: function(ctx) {
                        return ctx.dataset.label + ': ' +
                               ctx.formattedValue.toLocaleString() + '₫';
                    }
                }
            }
        },
        interaction: { mode: 'nearest', intersect: false },
        scales: {
            x: {
                ticks: { color: '#fff' },
                grid: { color: '#444' }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#fff',
                    callback: v => v.toLocaleString() + '₫'
                },
                grid: { color: '#444' }
            }
        }
    }
});
