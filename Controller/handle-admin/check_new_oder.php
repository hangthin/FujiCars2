<?php
session_start();
include "../../Controller/config/config.php";

// Lấy đơn hàng mới nhất
$order = $conn->query("SELECT * FROM hoadon ORDER BY DateCreate DESC, ID DESC LIMIT 1")->fetch_assoc();

// Lấy ID đơn đã xem
$lastViewedOrder = $_SESSION['lastViewedOrder'] ?? 0;

if ($order && $order['ID'] != $lastViewedOrder) {
    // Đơn mới, chưa xem
    echo json_encode([
        'newOrder' => true,
        'order' => $order
    ]);
} else {
    // Không có đơn mới hoặc đã xem
    echo json_encode([
        'newOrder' => false
    ]);
}
