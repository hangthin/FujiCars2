<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'Controller/config/config.php';

if (!isset($_SESSION['TenTK'])) {
    header("Location: index.php?n=login");
    exit();
}

$TenTK = $_SESSION['TenTK'];

// Lấy thông tin người dùng
$khQuery = $conn->prepare("SELECT * FROM nguoidung WHERE TenTK = ?");
$khQuery->bind_param("s", $TenTK);
$khQuery->execute();
$kh = $khQuery->get_result()->fetch_assoc();
if (!$kh) die("Không tìm thấy thông tin tài khoản.");

// Lấy hóa đơn
$billQuery = $conn->prepare("
    SELECT h.ID, h.DateCreate, h.TimeReceive, h.TotalPrice, h.Status,
           IFNULL(v.TrangThai,'Chưa tiến hành vận chuyển') AS VanChuyenStatus
    FROM hoadon h
    LEFT JOIN vanchuyen v ON v.ID_HoaDon = h.ID
    WHERE h.Name = ?
    ORDER BY h.DateCreate DESC, h.TimeReceive DESC
");
$billQuery->bind_param("s", $kh['TenTK']);
$billQuery->execute();
$bills = $billQuery->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Trang tài khoản - FujiCars</title>
<link rel="stylesheet" href="View/css/styleCss.css">
</head>
<body class="fjxacc-body">
<div class="fjxacc-container">
    <!-- FORM AVATAR + INFO -->
    <div class="fjxacc-form">
        <div class="fjxacc-avatar">
            <div class="circle"></div>
            <p><?= htmlspecialchars($kh['TenTK']) ?></p>
        </div>

        <div class="fjxacc-info-card">
            <h2>Thông tin tài khoản</h2>
            <p><strong>Tên tài khoản:</strong> <?= htmlspecialchars($kh['TenTK']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($kh['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($kh['phone']) ?></p>
            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($kh['DiaChi']) ?></p>
        </div>
    </div>

    <!-- HÓA ĐƠN -->
    <div class="fjxacc-bills">
        <h2>Hóa đơn</h2>
        <?php if($bills->num_rows>0): ?>
            <table class="fjxacc-table">
                <thead>
                    <tr>
                        <th>Mã hóa đơn</th>
                        <th>Ngày lập</th>
                        <th>Trạng thái xử lý</th>
                        <th>Trạng thái vận chuyển</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($bill=$bills->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($bill['ID']) ?></td>
                        <td><?= htmlspecialchars($bill['DateCreate']) ?></td>
                        <td>
                            <span class="fjxacc-status-icon">
                                <?php if($bill['Status']==0): ?>
                                    <i class="fa fa-clock-o pending"></i> Chưa xử lý
                                <?php else: ?>
                                    <i class="fa fa-check-circle done"></i> Đã xử lý
                                <?php endif; ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($bill['VanChuyenStatus']) ?></td>
                        <td><?= number_format($bill['TotalPrice'],0,',','.') ?>₫</td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="fjxacc-empty">Chưa có hóa đơn.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
