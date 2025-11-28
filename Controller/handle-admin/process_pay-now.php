<?php
session_start();
include "../../Controller/config/config.php";
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Chỉ xử lý khi có POST (nút đặt hàng được nhấn)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ===== LẤY THÔNG TIN NGƯỜI DÙNG TỪ SESSION =====
    $name    = $_SESSION['TenTK']  ?? 'Khách hàng';
    $phone   = $_SESSION['phone']  ?? 'Chưa cập nhật';
    $address = $_SESSION['DiaChi'] ?? 'Chưa cập nhật';
    //$UserID  = $_SESSION['ID']     ?? 0; // Bỏ ID_Customer

    // ===== LẤY DỮ LIỆU GIỎ HÀNG / SẢN PHẨM =====
    $MaSP     = intval($_POST['MaSP'] ?? 0);
    $SoLuong  = intval($_POST['SoLuong'] ?? 1);
    $TongTien = floatval($_POST['TongTien'] ?? 0);
    $method   = trim($_POST['method'] ?? 'COD');
    $shipping = trim($_POST['shipping_method'] ?? '');

    if ($shipping === 'Giao hàng tận nơi') {
        $TongTien += 30000;
    }

    // ===== CẬP NHẬT LẠI SỐ LƯỢNG SẢN PHẨM =====
    if ($MaSP > 0) {
        $sql_update = "UPDATE sanpham SET SoLuong = GREATEST(SoLuong - ?, 0) WHERE ID = ?";
        $stmt_upd = $conn->prepare($sql_update);
        $stmt_upd->bind_param("ii", $SoLuong, $MaSP);
        $stmt_upd->execute();
        $stmt_upd->close();
    }

    // ===== TẠO HÓA ĐƠN (BỎ ID_Bill, ID_Customer) =====
    $DateCreate  = date('Y-m-d H:i:s');
    $DateReceive = date('Y-m-d');
    $TimeReceive = date('H:i:s');
    $Status      = 0;

    $sql_insert = "INSERT INTO hoadon 
        (Name, Phone, Address, DateReceive, TimeReceive, Method, Status, TotalPrice, DateCreate)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql_insert);
$stmt->bind_param(
    "ssssssids",
    $name,
    $phone,
    $address,
    $DateReceive,
    $TimeReceive,
    $method,
    $Status,
    $TongTien,
    $DateCreate
);

if ($stmt->execute()) {

    // LẤY ID hóa đơn vừa tạo
    $newID = $stmt->insert_id;

    // Tạo payload đúng
    $order = [
        "ID" => $newID,
        "Name" => $name,
        "Phone" => $phone,
        "Address" => $address,
        "TotalPrice" => $TongTien,
        "DateCreate" => $DateCreate
    ];

    // Emit sang Node.js — SAU KHI TẠO ĐƠN
    include "../handle-admin/order_trigger.php";
    emitNewOrder($order);

    echo "success";
} 
else {
    echo "error: " . $conn->error;
}

    $stmt->close();
}
?>
