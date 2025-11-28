<?php
include("../config/config.php");
include("../sendmail.php"); // Gọi file sendmail

header("Content-Type: text/plain; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "❌ Yêu cầu không hợp lệ.";
    exit;
}

// Lấy dữ liệu từ form
$id      = intval($_POST['ID'] ?? 0);
$hoten   = trim($_POST['hoten'] ?? '');
$email   = trim($_POST['email'] ?? '');
$sdt     = trim($_POST['sdt'] ?? '');
$ngay    = trim($_POST['ngay'] ?? '');
$gio     = trim($_POST['gio'] ?? '');
$diachi  = trim($_POST['diachi'] ?? '');
$ghichu  = trim($_POST['ghichu'] ?? '');

// Validate dữ liệu bắt buộc
if (!$id || !$hoten || !$email || !$sdt || !$ngay || !$gio || !$diachi) {
    echo "❗ Thiếu thông tin bắt buộc.";
    exit;
}

// Kiểm tra email hợp lệ
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "❗ Email không hợp lệ.";
    exit;
}

// Lấy thông tin sản phẩm
$stmt = $conn->prepare("SELECT * FROM sanpham WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$sp = $result->fetch_assoc();
$stmt->close();

if (!$sp) {
    echo "❌ Không tìm thấy sản phẩm có ID $id.";
    exit;
}

// Lưu đăng ký lái thử
$stmt2 = $conn->prepare("INSERT INTO dangkilaithe (hoten, sdt, tenxe, ghichu, ngay, gio, diachi, ngaydangky)
                         VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt2->bind_param("sssssss", $hoten, $sdt, $sp['TenSP'], $ghichu, $ngay, $gio, $diachi);
if(!$stmt2->execute()){
    echo "❌ Lỗi lưu dữ liệu: " . $stmt2->error;
    exit;
}
$stmt2->close();

// Chuẩn bị nội dung email HTML
$subject = "Xác nhận đăng ký lái thử xe: {$sp['TenSP']}";
$body = "
<html>
<head>
<style>
body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:0; }
.container { max-width:600px; margin:20px auto; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
.header { background:red; color:#fff; text-align:center; padding:20px; font-size:24px; font-weight:bold; }
.content { padding:20px; }
.content h2 { color:red; margin-top:0; }
.content p { line-height:1.6; margin:10px 0; }
.info-section { margin:15px 0; }
.info-item { margin-bottom:10px; }
.info-item span.label { display:inline-block; width:150px; font-weight:bold; color:red; vertical-align:top; }
.info-item span.value { display:inline-block; }
.footer { background:#000; color:#fff; text-align:center; padding:15px; font-size:12px; }
</style>
</head>
<body>
<div class='container'>
  <div class='header'>FUJICARS</div>
  <div class='content'>
    <h2>Xin chào {$hoten},</h2>
    <p>Cảm ơn bạn đã đăng ký lái thử mẫu xe <b>{$sp['TenSP']}</b>.</p>

    <div class='info-section'>
      <div class='info-item'><span class='label'>Mô tả:</span> <span class='value'>{$sp['MoTa']}</span></div>
      <div class='info-item'><span class='label'>Loại xe:</span> <span class='value'>{$sp['LoaiSP']}</span></div>
      <div class='info-item'><span class='label'>Giá:</span> <span class='value'>".number_format($sp['Gia'])." VND</span></div>
      <div class='info-item'><span class='label'>Nhiên liệu:</span> <span class='value'>{$sp['NhienLieu']}</span></div>
      <div class='info-item'><span class='label'>Xuất xứ:</span> <span class='value'>{$sp['XuatXu']}</span></div>
      <div class='info-item'><span class='label'>Ngày lái thử:</span> <span class='value'>{$ngay}</span></div>
      <div class='info-item'><span class='label'>Khung giờ:</span> <span class='value'>{$gio}</span></div>
      <div class='info-item'><span class='label'>Địa chỉ lái thử:</span> <span class='value'>{$diachi}</span></div>
      <div class='info-item'><span class='label'>Ghi chú:</span> <span class='value'>{$ghichu}</span></div>
    </div>

    <p>Chúng tôi sẽ liên hệ qua số <b>{$sdt}</b> để xác nhận lịch hẹn.</p>
  </div>
  <div class='footer'>Thư này được gửi tự động từ hệ thống FUJICARS</div>
</div>
</body>
</html>
";

// Gửi mail
$mailResult = sendMail($email, $hoten, $subject, $body);

if ($mailResult === true) {
    echo "success";
} else {
    echo "⚠️ Thông tin đã lưu, nhưng gửi email thất bại: $mailResult";
}

$conn->close();
?>
