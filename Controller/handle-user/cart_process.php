<?php
session_start();
include("Controller/config/config.php");

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity <= 0) {
        $quantity = 1;
    }

    if (isset($_POST['add_cart'])) {
        // Thêm vào giỏ hàng
        $_SESSION['giohang'][$product_id] = $_SESSION['giohang'][$product_id] ?? 0;
        $_SESSION['giohang'][$product_id] += $quantity;
        echo "<script>alert('Đã thêm sản phẩm vào giỏ hàng!');window.location.href='giohang.php';</script>";
    }
    elseif (isset($_POST['order_now'])) {
        // Mua ngay
        $_SESSION['giohang'][$product_id] = $quantity;
        echo "<script>alert('Mua ngay thành công!');window.location.href='thanhtoan.php';</script>";
    }
} else {
    echo "<script>alert('Dữ liệu không hợp lệ!');history.back();</script>";
}
?>
