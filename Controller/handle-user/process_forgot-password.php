<?php
session_start();
include("../config/config.php");
include("../sendmail_login.php");

$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if($phone == '' || $email == '') {
    $_SESSION['error_msg'] = 'Vui lòng nhập đầy đủ thông tin!';
    header("Location: quenmatkhau.php");
    exit;
}

$sql = "SELECT * FROM khachhang WHERE TRIM(`phone`)='$phone' AND TRIM(`email`)='$email' LIMIT 1";
$kq = mysqli_query($conn, $sql);

if(!$kq){
    $_SESSION['error_msg'] = 'Lỗi SQL: '.mysqli_error($conn);
    header("Location: quenmatkhau.php");
    exit;
}

if(mysqli_num_rows($kq) > 0){
    $row = mysqli_fetch_assoc($kq);

    // Tạo OTP
    $otp = rand(1000, 9999);

    // Lưu thông tin vào session để dùng cho trang OTP
    $_SESSION['email_check'] = $row['email'];
    $_SESSION['phone_check'] = $row['phone'];
    $_SESSION['otp'] = $otp;
    $_SESSION['taikhoan'] = $row['TenTK'];
    $_SESSION['user_id'] = $row['ID']; // session ID để sử dụng nếu cần
    $_SESSION['HinhAnh'] = $row['HinhAnh'];
    $_SESSION['Quyen'] = $row['Quyen'];

    // Gửi OTP qua email
    $send = sendOtp($row['email'], $otp);
    if($send === true){
        // Nếu gửi mail thành công, chuyển hướng sang trang OTP
        header("Location: ../../View/layout_user/otp.php");
        exit;
    } else {
        // Nếu gửi mail thất bại, thông báo lỗi chi tiết
        $_SESSION['error_msg'] = 'Không thể gửi email. Lỗi: ' . $send;
        header("Location: quenmatkhau.php");
        exit;
    }

} else {
    $_SESSION['error_msg'] = "Số điện thoại hoặc email không tồn tại!";
    header("Location: quenmatkhau.php");
    exit;
}
?>
