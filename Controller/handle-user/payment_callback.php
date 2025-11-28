<?php
// Bắt đầu phiên làm việc của PHP
session_start();

// Kết nối tới cơ sở dữ liệu
include "../../Controller/config/config.php";

// Thiết lập múi giờ hệ thống
date_default_timezone_set('Asia/Ho_Chi_Minh');

// ===== Kiểm tra giao dịch hợp lệ =====
// Nếu không tồn tại session 'bank_txn', dừng trang và thông báo lỗi
if (!isset($_SESSION['bank_txn'])) {
    die("❌ Không tìm thấy giao dịch. Vui lòng thử lại!");
}

// Lấy dữ liệu giỏ hàng và tổng tiền từ session
$txn = $_SESSION['bank_txn'];
$cartItems = $txn['cartItems']; // mảng các sản phẩm trong giỏ
$total = $txn['total'];         // tổng tiền hóa đơn

// ===== Lấy thông tin người dùng từ SESSION =====
$name    = $_SESSION['TenTK']    ?? "Khách hàng";
$phone   = $_SESSION['phone']    ?? "Chưa có";
$address = $_SESSION['DiaChi']   ?? "Chưa có";
$method  = "Chuyển khoản ngân hàng"; // Phương thức thanh toán

// ===== Thời gian hệ thống =====
$DateCreate  = date('Y-m-d'); // Ngày tạo hóa đơn
$DateReceive = date('Y-m-d'); // Ngày nhận
$TimeReceive = date('H:i:s'); // Giờ nhận
$Status      = 0;             // Trạng thái hóa đơn (0 = chờ xử lý)

// ===== GHI HÓA ĐƠN =====
$sqlHoadon = "INSERT INTO hoadon 
    (Name, Phone, Address, DateReceive, TimeReceive, Method, Status, TotalPrice, DateCreate)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Chuẩn bị câu truy vấn để chống SQL Injection
$stmt = $conn->prepare($sqlHoadon);
if (!$stmt) die("Prepare hoadon lỗi: " . $conn->error);

// Gắn giá trị vào câu truy vấn
$stmt->bind_param(
    "ssssssids",
    $name,
    $phone,
    $address,
    $DateReceive,
    $TimeReceive,
    $method,
    $Status,
    $total,
    $DateCreate
);

// Thực thi câu truy vấn
if (!$stmt->execute()) {
    die("Execute hoadon lỗi: " . $stmt->error);
}

// ===== Lấy ID tự động của hóa đơn mới =====
$bill_id = $conn->insert_id;
$stmt->close();

// ===============================
// 🔥 REALTIME: Gửi dữ liệu sang Node server (POST JSON)
// ===============================
$orderData = [
    "id"      => $bill_id,
    "name"    => $name,
    "phone"   => $phone,
    "address" => $address,
    "total"   => $total,
    "created" => date('Y-m-d H:i:s')
];

// Chuyển dữ liệu sang JSON
$payload = json_encode($orderData);

// Thiết lập context POST JSON
$opts = [
    "http" => [
        "method"  => "POST",
        "header"  => "Content-Type: application/json\r\n",
        "content" => $payload,
        "timeout" => 3
    ]
];

$context = stream_context_create($opts);
// Gửi dữ liệu đến Node.js server (localhost:3000)
@file_get_contents("http://localhost:3000/emit-order", false, $context);
// ===============================

// ==================================
// 🔥 REALTIME bằng PHP (Dashboard)
// ==================================
// Dùng session để dashboard biết có đơn mới
$_SESSION['lastViewedOrder'] = 0;

// ===== GHI CHI TIẾT HÓA ĐƠN =====
foreach ($cartItems as $item) {
    $productId   = strval($item['ID'] ?? '');         // Mã sản phẩm
    $productName = $item['TenSP'] ?? '';             // Tên sản phẩm
    $qty         = intval($item['SoLuong'] ?? 0);    // Số lượng
    $price       = floatval($item['Gia'] ?? $item['GiaTien'] ?? 0); // Giá

    // Câu truy vấn insert chi tiết hóa đơn
    $sqlDetail = "INSERT INTO hoadon_detail 
        (BillID, ProductID, ProductName, Quantity, Price)
        VALUES (?, ?, ?, ?, ?)";

    $stmtDetail = $conn->prepare($sqlDetail);
    if ($stmtDetail) {
        // Gắn giá trị và thực thi
        $stmtDetail->bind_param("sssii", $bill_id, $productId, $productName, $qty, $price);
        $stmtDetail->execute();
        $stmtDetail->close();
    }
}

// ===== Xóa session giao dịch =====
unset($_SESSION['bank_txn']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đặt hàng thành công</title>
<style>
/* ===== CSS Trang Đặt Hàng Thành Công ===== */

/* Body của trang */
body {
    font-family: "Segoe UI", sans-serif;
    background-color: #0b0b0b; /* nền đen */
    padding: 40px;
    text-align: center;
    color: #fff;
    margin: 0;
}

/* Hộp chính */
.box {
    background-color: #1a1a1a; /* hộp đen nhạt */
    border-radius: 20px;
    padding: 40px 30px;
    max-width: 600px;
    margin: auto;
    box-shadow: 0 8px 30px rgba(255, 0, 0, 0.4);
    border: 2px solid #ff2e2e; /* viền đỏ */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.box:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(255, 0, 0, 0.6);
}

/* Tiêu đề */
h2 {
    color: #ff2e2e; /* đỏ nổi bật */
    font-size: 28px;
    margin-bottom: 20px;
    text-shadow: 0 0 8px #ff2e2e;
}

/* Thông tin tổng quan */
.box p {
    font-size: 16px;
    margin: 8px 0;
}

/* Hộp thông tin chi tiết giao hàng */
.info-box {
    text-align: left;
    background-color: #2a2a2a; /* hộp xám đen */
    border: 2px solid #ff2e2e; /* viền đỏ */
    border-radius: 12px;
    padding: 20px 25px;
    margin-top: 25px;
    box-shadow: 0 4px 15px rgba(255, 0, 0, 0.25);
}

.info-box h3 {
    margin-top: 0;
    color: #ff2e2e;
    text-align: center;
    font-size: 20px;
    text-shadow: 0 0 5px #ff2e2e;
}

.info-box p {
    margin: 6px 0;
    font-size: 15px;
}

/* Nút quay về trang chủ */
.btn-home {
    display: inline-block;
    margin-top: 30px;
    background-color: #ff2e2e; /* đỏ */
    color: #fff;
    padding: 14px 28px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 0, 0, 0.4);
}

.btn-home:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 0, 0, 0.6);
    background-color: #d10000; /* đỏ đậm khi hover */
}

/* Responsive: giảm padding trên thiết bị nhỏ */
@media (max-width: 768px) {
    body { padding: 20px; }
    .box { padding: 30px 20px; }
    .btn-home { width: 100%; padding: 14px 0; }
}

</style>
</head>
<body>
</br>
</br>
</br>
<div class="box">
    <h2>Đặt hàng thành công!</h2>
    <p><b>Mã hóa đơn:</b> <?= $bill_id ?></p>
    <p><b>Tổng tiền:</b> <?= number_format($total, 0, ',', '.') ?> VND</p>

    <div class="info-box">
        <h3 style="margin-top:0;color:#d10000;text-align:center;">Xác nhận thông tin giao hàng</h3>
        <p><b>Họ và tên:</b> <?= htmlspecialchars($name) ?></p>
        <p><b>Số điện thoại:</b> <?= htmlspecialchars($phone) ?></p>
        <p><b>Địa chỉ:</b> <?= htmlspecialchars($address) ?></p>
        <p><b>Phương thức:</b> <?= htmlspecialchars($method) ?></p>
    </div>

    <a href="../../index.php" class="btn-home">Quay về trang chủ</a>
</div>

</body>
</html>
