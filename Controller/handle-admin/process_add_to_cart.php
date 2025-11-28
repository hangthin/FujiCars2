<?php
session_start();
include "../../Controller/config/config.php";

if (!isset($_SESSION['ID'])) {
    echo "not_logged";
    exit();
}

$MaKH = $_SESSION['ID']; 
$action = $_POST['action'] ?? '';
$id = intval($_POST['id'] ?? 0);

// Lấy sản phẩm
$sql = "SELECT * FROM sanpham WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$prod = $stmt->get_result()->fetch_assoc();

if (!$prod) { echo "not_found"; exit(); }

switch ($action) {

    case 'add':
        // Kiểm tra sản phẩm đã có trong giỏ chưa
        $check = $conn->prepare("SELECT * FROM giohang WHERE MaKH = ? AND MaSP = ?");
        $check->bind_param("ii", $MaKH, $id);
        $check->execute();
        $rs = $check->get_result();

        if ($rs->num_rows > 0) {
            // Cập nhật số lượng
            $update = $conn->prepare("UPDATE giohang SET SoLuong = SoLuong + 1 WHERE MaKH = ? AND MaSP = ?");
            $update->bind_param("ii", $MaKH, $id);
            $update->execute();
        } else {
            // Thêm mới
            $insert = $conn->prepare("INSERT INTO giohang(MaKH, MaSP, SoLuong, NgayCapNhat) VALUES (?, ?, 1, NOW())");
            $insert->bind_param("ii", $MaKH, $id);
            $insert->execute();
        }

        echo "success";
        break;

    case 'plus':
        $update = $conn->prepare("UPDATE giohang SET SoLuong = SoLuong + 1 WHERE MaKH = ? AND MaSP = ?");
        $update->bind_param("ii", $MaKH, $id);
        $update->execute();
        echo "success";
        break;

    case 'minus':
        $update = $conn->prepare("
            UPDATE giohang 
            SET SoLuong = SoLuong - 1 
            WHERE MaKH = ? AND MaSP = ? AND SoLuong > 1
        ");
        $update->bind_param("ii", $MaKH, $id);
        $update->execute();

        // Xóa nếu còn 0
        $delete = $conn->prepare("DELETE FROM giohang WHERE MaKH = ? AND MaSP = ? AND SoLuong <= 1");
        $delete->bind_param("ii", $MaKH, $id);
        $delete->execute();

        echo "success";
        break;

    case 'delete':
        $delete = $conn->prepare("DELETE FROM giohang WHERE MaKH = ? AND MaSP = ?");
        $delete->bind_param("ii", $MaKH, $id);
        $delete->execute();
        echo "success";
        break;

    default:
        echo "invalid_action";
}
?>
