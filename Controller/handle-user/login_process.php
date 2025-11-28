<?php
session_start();
include '../config/config.php'; // đường dẫn đến file cấu hình CSDL

if (isset($_POST['dangnhap'])) {
    $TenTK = trim($_POST['username']);
    $MatKhau = trim($_POST['password']);

    // Lấy người dùng từ bảng nguoidung
    $stmt = $conn->prepare("SELECT * FROM nguoidung WHERE TenTK = ?");
    $stmt->bind_param("s", $TenTK);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu hash bcrypt
        if (password_verify($MatKhau, $user['MatKhau'])) {
            $_SESSION['ID'] = $user['ID']; // cột IDChính
            $_SESSION['MaTK'] = $user['MaTK'];
            $_SESSION['TenTK'] = $user['TenTK'];
            $_SESSION['Quyen'] = $user['Quyen'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['HinhAnh'] = $user['HinhAnh'];
            $_SESSION['DiaChi'] = $user['DiaChi'];

            header("Location: ../../index.php");
            exit();
        } else {
            // Sai mật khẩu
            header("Location: ../../index.php?n=login&error=" . urlencode("Mật khẩu không đúng"));
            exit();
        }
    } else {
        // Không tìm thấy tài khoản
        header("Location: ../../index.php?n=login&error=" . urlencode("Tài khoản không tồn tại"));
        exit();
    }
}

$conn->close();
?>
