<?php
include "Controller/config/config.php";
header('Content-Type: application/json; charset=utf-8');

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if ($keyword === '') {
    echo json_encode([]);
    exit;
}

$sql = "SELECT ID, TenSP, Gia FROM sanpham WHERE TenSP LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%{$keyword}%";
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products, JSON_UNESCAPED_UNICODE);
