<?php
// process_register.php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../Controller/config/config.php';

// Lấy dữ liệu POST
$TenTK   = isset($_POST["TenTK"]) ? trim($_POST["TenTK"]) : "";
$MatKhau = isset($_POST["MatKhau"]) ? trim($_POST["MatKhau"]) : "";
$Quyen   = "1"; // quyền mặc định
$DiaChi  = isset($_POST["DiaChi"]) ? trim($_POST["DiaChi"]) : "";
$email   = isset($_POST["email"]) ? trim($_POST["email"]) : "";
$phone   = isset($_POST["phone"]) ? trim($_POST["phone"]) : "";
$NgayCapNhat = date("Y-m-d H:i:s");

// Kiểm tra bắt buộc
if($TenTK == "" || $MatKhau == "") {
    echo "<script>alert('Tên tài khoản và mật khẩu không được để trống'); window.history.back();</script>";
    exit();
}

// Escape dữ liệu
$TenTK   = mysqli_real_escape_string($conn, $TenTK);
$MatKhau = mysqli_real_escape_string($conn, $MatKhau);
$DiaChi  = mysqli_real_escape_string($conn, $DiaChi);
$email   = mysqli_real_escape_string($conn, $email);
$phone   = mysqli_real_escape_string($conn, $phone);

// Kiểm tra tên tài khoản tồn tại
$check_sql = "SELECT TenTK FROM nguoidung WHERE TenTK = '$TenTK'";
$result = mysqli_query($conn, $check_sql);
if(!$result){
    die("SQL Error (check): ".mysqli_error($conn));
}
if(mysqli_num_rows($result) > 0){
    echo "<script>alert('Tên tài khoản đã tồn tại'); window.history.back();</script>";
    exit();
}

// Hash mật khẩu
$MatKhauHash = password_hash($MatKhau, PASSWORD_DEFAULT);

// Thêm vào bảng nguoidung
$sql_insert = "INSERT INTO nguoidung (TenTK, MatKhau, Quyen, DiaChi, NgayCapNhat, phone, email)
               VALUES ('$TenTK', '$MatKhauHash', '$Quyen', '$DiaChi', '$NgayCapNhat', '$phone', '$email')";

if(mysqli_query($conn, $sql_insert)){
    // Lấy thông tin người dùng vừa đăng ký
    $last_id = mysqli_insert_id($conn);
    $user_sql = "SELECT * FROM nguoidung WHERE ID = $last_id";
    $user_result = mysqli_query($conn, $user_sql);
    if($user_result && mysqli_num_rows($user_result) > 0){
        $user = mysqli_fetch_assoc($user_result);
        // Lưu thông tin vào session
        $_SESSION['ID']      = $user['ID'];
        $_SESSION['TenTK']   = $user['TenTK'];
        $_SESSION['Quyen']   = $user['Quyen'];
        $_SESSION['DiaChi']  = $user['DiaChi'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['phone']   = $user['phone'];
        // Redirect về index.php
        echo "<script>alert('Đăng ký thành công, bạn đã được đăng nhập'); window.location.href='../../index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Đăng ký thành công nhưng không thể đăng nhập tự động'); window.location.href='../../index.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Lỗi thêm người dùng: ".mysqli_error($conn)."'); window.history.back();</script>";
}

mysqli_close($conn);
?>
