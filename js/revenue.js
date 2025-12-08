// =========================
// LƯU DỮ LIỆU GỐC
// =========================
const originalLabels = [...chartLabels];
const originalValues = [...chartValues];

// =========================
// TẠO BIỂU ĐỒ 1 LẦN DUY NHẤT
// =========================
const canvas = document.getElementById("twxstatRevenueChart");
const ctx = canvas.getContext("2d");

let revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: originalLabels,
        datasets: [{
            label: 'Doanh thu',
            data: originalValues,
            borderColor: 'rgba(255,0,0,1)',
            backgroundColor: 'rgba(255,50,50,0.3)',
            borderWidth: 2,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// =========================
// HÀM LẤY SỐ TUẦN CỦA NĂM
// =========================
function getWeek(dateString) {
    const d = new Date(dateString);
    const first = new Date(d.getFullYear(), 0, 1);
    return Math.ceil(((d - first) / 86400000 + first.getDay() + 1) / 7);
}

function formatMonth(dateString) {
    const d = new Date(dateString);
    return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}`;
}

function formatYear(dateString) {
    return new Date(dateString).getFullYear();
}

// =========================
// HÀM LỌC DỮ LIỆU BIỂU ĐỒ
// =========================
function filterChart(type) {
    const grouped = {};

    originalLabels.forEach((date, index) => {
        let key = "";

        if (type === "day") key = date;
        if (type === "week") key = `Tuần ${getWeek(date)} - ${new Date(date).getFullYear()}`;
        if (type === "month") key = formatMonth(date);
        if (type === "year") key = formatYear(date);

        if (!grouped[key]) grouped[key] = 0;
        grouped[key] += originalValues[index];
    });

    // Cập nhật biểu đồ
    revenueChart.data.labels = Object.keys(grouped);
    revenueChart.data.datasets[0].data = Object.values(grouped);
    revenueChart.update();
}

// =========================
// NÚT LỌC
// =========================
document.getElementById("filter-btn").addEventListener("click", function(e) {
    e.preventDefault();
    const type = document.getElementById("filter-type").value;

    if (!type) return alert("Hãy chọn hình thức thống kê!");

    filterChart(type);
});

// =========================
// NÚT RESET
// =========================
document.getElementById("reset-btn").addEventListener("click", function(e) {
    e.preventDefault();

    revenueChart.data.labels = originalLabels;
    revenueChart.data.datasets[0].data = originalValues;
    revenueChart.update();
});
