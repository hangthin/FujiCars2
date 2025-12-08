<?php
session_start();
include "../../Controller/config/config.php";
date_default_timezone_set('Asia/Ho_Chi_Minh');

// ===============================
// KIỂM TRA GIAO DỊCH HỢP LỆ
// ===============================
if (!isset($_SESSION['bank_txn'])) {
    die("❌ Không tìm thấy giao dịch. Vui lòng thử lại!");
}

$txn        = $_SESSION['bank_txn'];
$cartItems  = $txn['cartItems'];
$total      = $txn['total'];

// ===============================
// LẤY THÔNG TIN USER
// ===============================
$name    = $_SESSION['TenTK']  ?? "Khách hàng";
$phone   = $_SESSION['phone']  ?? "Chưa có";
$address = $_SESSION['DiaChi'] ?? "Chưa có";
$method  = "Chuyển khoản ngân hàng";

// ===============================
// THỜI GIAN
// ===============================
$DateCreate  = date('Y-m-d');
$DateReceive = date('Y-m-d');
$TimeReceive = date('H:i:s');
$Status      = 0;

// ===============================
// INSERT HÓA ĐƠN
// ===============================
$sqlHoadon = "INSERT INTO hoadon 
(Name, Phone, Address, DateReceive, TimeReceive, Method, Status, TotalPrice, DateCreate)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sqlHoadon);
if (!$stmt) die("Prepare hoadon lỗi: " . $conn->error);

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

if (!$stmt->execute()) die("Execute hoadon lỗi: " . $stmt->error);
$bill_id = $stmt->insert_id;
$stmt->close();

// ===============================
// 🔥 REALTIME TRIGGER → NODE SERVER (Render)
// ===============================
include "../handle-admin/order_trigger.php";

$order = [
    "ID" => $bill_id,       // ID hóa đơn vừa insert
    "Name" => $name,
    "Phone" => $phone,
    "Address" => $address,
    "DateReceive" => $DateReceive,
    "TimeReceive" => $TimeReceive,
    "Method" => $method,
    "TotalPrice" => $total,
    "Status" => $Status,
    "DateCreate" => $DateCreate
];

emitNewOrder($order);  // Gửi đúng biến


// ===============================
// ĐÁNH DẤU DASHBOARD CHƯA XEM ĐƠN MỚI
// ===============================
$_SESSION['lastViewedOrder'] = 0;

// ===============================
// LƯU CHI TIẾT ĐƠN HÀNG
// ===============================
foreach ($cartItems as $item) {
    $productId   = strval($item['ID'] ?? '');
    $productName = $item['TenSP'] ?? '';
    $qty         = intval($item['SoLuong'] ?? 0);
    $price       = floatval($item['Gia'] ?? $item['GiaTien'] ?? 0);

    $sqlDetail = "INSERT INTO hoadon_detail 
    (BillID, ProductID, ProductName, Quantity, Price)
    VALUES (?, ?, ?, ?, ?)";

    $stmtDetail = $conn->prepare($sqlDetail);
    if ($stmtDetail) {
        $stmtDetail->bind_param("sssii", $bill_id, $productId, $productName, $qty, $price);
        $stmtDetail->execute();
        $stmtDetail->close();
    }
}

// ===============================
// XÓA SESSION BANKING
// ===============================
unset($_SESSION['bank_txn']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đặt hàng thành công</title>

<style>
body {
    font-family: "Segoe UI", sans-serif;
    background-color: #0b0b0b;
    padding: 40px;
    text-align: center;
    color: #fff;
    margin: 0;
}
.box {
    background-color: #1a1a1a;
    border-radius: 20px;
    padding: 40px 30px;
    max-width: 600px;
    margin: auto;
    box-shadow: 0 8px 30px rgba(255, 0, 0, 0.4);
    border: 2px solid #ff2e2e;
    transition: 0.3s ease;
}
.box:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(255, 0, 0, 0.6);
}
h2 {
    color: #ff2e2e;
    font-size: 28px;
    margin-bottom: 20px;
    text-shadow: 0 0 8px #ff2e2e;
}
.box p {
    font-size: 16px;
    margin: 8px 0;
}
.info-box {
    text-align: left;
    background-color: #2a2a2a;
    border: 2px solid #ff2e2e;
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
}
.btn-home {
    display: inline-block;
    margin-top: 30px;
    background-color: #ff2e2e;
    color: #fff;
    padding: 14px 28px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 0, 0, 0.4);
}
.btn-home:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 0, 0, 0.6);
    background-color: #d10000;
}
</style>
</head>
<body>

<br><br><br>

<div class="box">
    <h2>Đặt hàng thành công!</h2>
    <p><b>Mã hóa đơn:</b> <?= $bill_id ?></p>
    <p><b>Tổng tiền:</b> <?= number_format($total, 0, ',', '.') ?> VND</p>

    <div class="info-box">
        <h3>Xác nhận thông tin giao hàng</h3>
        <p><b>Họ và tên:</b> <?= htmlspecialchars($name) ?></p>
        <p><b>Số điện thoại:</b> <?= htmlspecialchars($phone) ?></p>
        <p><b>Địa chỉ:</b> <?= htmlspecialchars($address) ?></p>
        <p><b>Phương thức:</b> <?= htmlspecialchars($method) ?></p>
    </div>

    <a href="../../index.php" class="btn-home">Quay về trang chủ</a>
</div>

</body>
</html>
