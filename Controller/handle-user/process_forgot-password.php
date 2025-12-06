<?php
session_start();
header("Content-Type: text/plain; charset=UTF-8");

require "../config/config.php";
require "../sendmail_login.php";

$phone = trim($_POST['phone'] ?? "");
$email = trim($_POST['email'] ?? "");

// ======================
// CHỐNG SPAM (60 GIÂY)
// ======================
if (isset($_SESSION['last_otp_request']) && time() - $_SESSION['last_otp_request'] < 60) {
    $wait = 60 - (time() - $_SESSION['last_otp_request']);
    echo "Vui lòng đợi $wait giây trước khi yêu cầu lại.";
    exit;
}

if ($phone == "" || $email == "") {
    echo "Vui lòng nhập đầy đủ thông tin!";
    exit;
}

// ======================
// Tìm user
// ======================
$sql = "SELECT * FROM khachhang 
        WHERE TRIM(phone) = ? AND TRIM(email) = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $phone, $email);
$stmt->execute();
$kq = $stmt->get_result();

if ($kq->num_rows == 0) {
    echo "Không tìm thấy tài khoản phù hợp!";
    exit;
}

$user = $kq->fetch_assoc();

// ======================
// Tạo OTP
// ======================
$otp = rand(1000, 9999);

// Lưu session
$_SESSION['email_check'] = $user['email'];
$_SESSION['phone_check'] = $user['phone'];
$_SESSION['otp'] = $otp;
$_SESSION['otp_time'] = time();


// ======================
// Gửi email
// ======================
$send = sendOtp($user['email'], $otp);

if ($send === true) {
    $_SESSION['last_otp_request'] = time(); // đánh dấu chống spam
    echo "OTP_OK";
    exit;
} else {
    echo "Gửi Email thất bại: " . $send;
    exit;
}
