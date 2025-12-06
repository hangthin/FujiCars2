<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Sửa đường dẫn tới config.php
include __DIR__ . '/../config/config.php'; // Từ handle-user lên ../config/config.php

if (!$conn) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Nhận token từ Google
$token = $_POST['credential'] ?? null;
if (!$token) {
    die("Token không hợp lệ");
}

// Client ID Google của bạn
$client_id = "854782132762-039qpgpr889fj141p2bgnbf711uri77s.apps.googleusercontent.com";

// Xác thực token với Google
$verify_url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $token;
$response = file_get_contents($verify_url);
if (!$response) {
    die("Không thể xác thực token với Google");
}

$user_data = json_decode($response, true);

// Kiểm tra token có hợp lệ và đúng client_id
if (isset($user_data['aud']) && $user_data['aud'] === $client_id && isset($user_data['email'])) {
    $email = $user_data['email'];
    $name_from_google = $user_data['name'] ?? explode('@', $email)[0];

    // Kiểm tra user trong DB
    $stmt = $conn->prepare("SELECT * FROM nguoidung WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        // Tạo user mới nếu chưa tồn tại
        $quyen = 1; // mặc định khách hàng
        $stmt2 = $conn->prepare("INSERT INTO nguoidung (TenTK, email, Quyen) VALUES (?, ?, ?)");
        $stmt2->bind_param("ssi", $name_from_google, $email, $quyen);
        $stmt2->execute();

        $new_id = $conn->insert_id;
        $user = [
            'ID' => $new_id,
            'MaTK' => $new_id,
            'TenTK' => $name_from_google,
            'Quyen' => $quyen,
            'email' => $email,
            'phone' => '',
            'HinhAnh' => '',
            'DiaChi' => ''
        ];
    }

    // Lưu session
    $_SESSION['ID'] = $user['ID'];
    $_SESSION['MaTK'] = $user['MaTK'];
    $_SESSION['TenTK'] = $user['TenTK'];
    $_SESSION['Quyen'] = $user['Quyen'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['phone'] = $user['phone'];
    $_SESSION['HinhAnh'] = $user['HinhAnh'];
    $_SESSION['DiaChi'] = $user['DiaChi'];

    // Redirect về trang chính
    header("Location: ../../index.php");
    exit();
} else {
    die("Không xác thực được Google user hoặc token không hợp lệ");
}

$conn->close();
?>
