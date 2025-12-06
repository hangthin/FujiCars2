<?php
// Controller/sendMail.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Nạp thư viện PHPMailer (đường dẫn theo cấu trúc của bạn)
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

/**
 * Gửi email bằng Gmail SMTP
 * @param string $toEmail - Email người nhận
 * @param string $toName - Tên người nhận
 * @param string $subject - Tiêu đề
 * @param string $body - Nội dung HTML
 * @return bool|string true nếu gửi thành công, chuỗi lỗi nếu thất bại
 */
function sendMail($toEmail, $toName, $subject, $body)
{
    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';           // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'nhthin366@gmail.com';   // 🔹 Thay bằng Gmail thật
        $mail->Password = 'qerw ouap mnmt kfrj';    // 🔹 Dán App Password (16 ký tự)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL/TLS
        $mail->Port = 465;                        // SSL port (nếu dùng TLS thì 587)

        // Thiết lập thông tin người gửi
        $mail->setFrom('FUJICARS@gmail.com', 'FUJICARS'); // 🔹 Phải trùng Username

        // Người nhận
        $mail->addAddress($toEmail, $toName);

        // Nội dung email
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        // Gửi
        $mail->send();
        return true;
    } catch (Exception $e) {
        return 'SMTP Error: ' . $mail->ErrorInfo;
    }
}
?>
