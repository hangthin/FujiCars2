document.addEventListener("DOMContentLoaded", () => {
// ===============================================
// 📊 VẼ BIỂU ĐỒ
// ===============================================
const ctx = document.getElementById('chart');

const labels = window.chartData.labels;
const values = window.chartData.values;

new Chart(ctx, {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{
      label: 'Doanh thu (VNĐ)',
      data: values,
      borderColor: '#e53935',
      backgroundColor: 'rgba(229,57,53,0.18)',
      fill: true,
      tension: 0.35,
      pointBackgroundColor: '#fff',
      pointBorderColor: '#e53935',
      pointRadius: 4,
      borderWidth: 2
    }]
  },
  options: {
    plugins: { legend: { labels: { color: 'black' } } },
    scales: {
      x: { ticks: { color: 'black' }, grid: { color: '#222' } },
      y: { ticks: { color: 'black' }, grid: { color: '#222' } }
    }
  }
});


});
