<?php 
session_start();
include("Controller/config/config.php");

// Lấy dữ liệu thống kê: chỉ lấy các hóa đơn đã "Đã giao hàng"
$sql = "SELECT h.* 
        FROM hoadon h
        INNER JOIN vanchuyen v ON h.ID = v.ID_HoaDon
        WHERE v.TrangThai = 'Đã giao hàng'
        ORDER BY h.DateCreate ASC";
$result = $conn->query($sql);

$orders = [];
$totalRevenue = 0;
$totalOrders = 0;

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
    $totalRevenue += $row['TotalPrice'];
    $totalOrders++;
}

// Tính trung bình
$avgRevenue = $totalOrders ? $totalRevenue / $totalOrders : 0;

// Chuẩn bị dữ liệu cho biểu đồ
$chartData = [];
foreach ($orders as $order) {
    $date = $order['DateCreate'];
    if (!isset($chartData[$date])) $chartData[$date] = 0;
    $chartData[$date] += $order['TotalPrice'];
}

$chartLabels = json_encode(array_keys($chartData));
$chartValues = json_encode(array_values($chartData));
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<link rel="stylesheet" href="View/css/styleCss.css">
<meta charset="UTF-8">
<title>Thống kê doanh thu</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="twxstat-body">

<h1 class="twxstat-title">THỐNG KÊ DOANH THU</h1>
<br>

<!-- Thống kê tổng quan -->
<div class="twxstat-stats">
    <div class="twxstat-box">
        <h2 style="color:white"><?= number_format($totalRevenue, 0, ',', '.') ?>₫</h2>
        <p>Tổng doanh thu</p>
    </div>

    <div class="twxstat-box">
        <h2 style="color:white"><?= $totalOrders ?></h2>
        <p>Tổng số hóa đơn</p>
    </div>

    <div class="twxstat-box">
        <h2 style="color:white"><?= number_format($avgRevenue, 0, ',', '.') ?>₫</h2>
        <p>Trung bình mỗi hóa đơn</p>
    </div>
</div>

<!-- Bộ lọc -->
<div class="twxstat-filter-box">
    <select id="filter-type" class="twxstat-select">
        <option value="">Chọn dạng thống kê</option>
        <option value="day">Theo ngày</option>
        <option value="week">Theo tuần</option>
        <option value="month">Theo tháng</option>
        <option value="year">Theo năm</option>
    </select>

    <select id="filter-year" class="twxstat-select">
        <option value="">Chọn năm (dành cho lọc năm)</option>
        <option value="2023">2023</option>
        <option value="2024">2024</option>
        <option value="2025">2025</option>
    </select>

    <button id="filter-btn" class="twxstat-btn">Lọc</button>
    <button id="reset-btn" class="twxstat-btn-reset">Reset</button>
</div>
<br>

<!-- Biểu đồ -->
<div class="twxstat-chart-container">
    <canvas id="twxstatRevenueChart" height="100"></canvas>
</div>

<!-- Bảng chi tiết -->
<table class="twxstat-table">
<thead>
<tr>
<th>ID</th><th>Khách hàng</th><th>Điện thoại</th><th>Địa chỉ</th><th>Ngày nhận</th>
<th>Thời gian nhận</th><th>Thanh toán</th><th>Trạng thái</th><th>Tổng tiền</th><th>Ngày tạo</th>
</tr>
</thead>

<tbody>
<?php foreach ($orders as $o): ?>
<tr>
<td><?= $o['ID'] ?></td>
<td><?= htmlspecialchars($o['Name']) ?></td>
<td><?= htmlspecialchars($o['Phone']) ?></td>
<td><?= htmlspecialchars($o['Address']) ?></td>
<td><?= $o['DateReceive'] ?></td>
<td><?= $o['TimeReceive'] ?></td>
<td><?= htmlspecialchars($o['Method']) ?></td>
<td><?= $o['Status'] ?></td>
<td><?= number_format($o['TotalPrice'], 0, ',', '.') ?>₫</td>
<td><?= $o['DateCreate'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="twxstat-footer">&copy; <?= date('Y') ?> Thống kê doanh thu</div>

<script>
    const chartLabels = <?= $chartLabels ?>;
    const chartValues = <?= $chartValues ?>;
</script>

<script src="js/revenue.js"></script>

</body>
</html>
