<?php
session_start();
include 'Controller/config/config.php';  // Bao gồm tệp cấu hình

header('Content-Type: application/json');

$userId = $_POST['id'] ?? null;

if (!$userId) {
    echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ']);
    exit;
}

$sql = "DELETE FROM sanpham WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Sản phẩm đã được xóa thành công!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Lỗi khi xóa sản phẩm: ' . $conn->error]);
}
?>
