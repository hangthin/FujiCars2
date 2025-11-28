<?php
session_start();
include "../../Controller/config/config.php";

// Kiểm tra quyền admin
if (!isset($_SESSION['Quyen']) || $_SESSION['Quyen'] != '3') {
    die(json_encode(['success'=>false,'message'=>"Bạn không có quyền truy cập"]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_vanchuyen'])) {
    $ID_HoaDon = intval($_POST['ID_HoaDon']);
    $TenTK     = $_POST['TenTK'];
    $Phone     = $_POST['Phone'];
    $Address   = $_POST['Address'];
    $TrangThai = $_POST['TrangThai'];

    $check = $conn->query("SELECT ID FROM vanchuyen WHERE ID_HoaDon = $ID_HoaDon")->fetch_assoc();

    if ($check) {
        $stmt = $conn->prepare("UPDATE vanchuyen SET TenTK=?, Phone=?, Address=?, TrangThai=? WHERE ID_HoaDon=?");
        $stmt->bind_param("ssssi", $TenTK, $Phone, $Address, $TrangThai, $ID_HoaDon);
        $msg_action = "cập nhật";
    } else {
        $stmt = $conn->prepare("INSERT INTO vanchuyen (TenTK, ID_HoaDon, Phone, Address, TrangThai) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $TenTK, $ID_HoaDon, $Phone, $Address, $TrangThai);
        $msg_action = "thêm";
    }

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: vanchuyen_view.php?success=" . urlencode(ucfirst($msg_action)." vận chuyển thành công!"));
        exit;
    } else {
        $stmt->close();
        header("Location: vanchuyen_view.php?error=" . urlencode("Lỗi: ".$stmt->error));
        exit;
    }
} else {
    header("Location: vanchuyen_view.php");
    exit;
}
