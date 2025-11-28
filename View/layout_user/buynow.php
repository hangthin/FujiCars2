<?php
session_start();
include("../../Controller/config.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['ID'])) {
    die("Bạn phải đăng nhập để thanh toán.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);  // ID sản phẩm
    $quantity = intval($_POST['quantity']);     // Số lượng người dùng muốn mua

    // Truy vấn thông tin sản phẩm và số lượng tồn kho
    $sql = "SELECT ID, TenSP, Gia, HinhAnh, SoLuong FROM sanpham WHERE ID = $productId";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        if ($quantity > $row['SoLuong']) {
            echo "Sản phẩm không đủ số lượng. Hiện còn lại: " . $row['SoLuong'];
        } elseif ($quantity <= 0) {
            echo "Số lượng không hợp lệ.";
        } else {
            // Lưu vào session nếu đủ hàng
            $_SESSION['buyNow'] = [
                'ID' => $row['ID'],
                'TenSP' => $row['TenSP'],
                'Gia' => $row['Gia'],
                'HinhAnh' => $row['HinhAnh'],
                'SoLuong' => $quantity
            ];
            echo "success";
        }
    } else {
        echo "Sản phẩm không tồn tại.";
    }
}
?>	