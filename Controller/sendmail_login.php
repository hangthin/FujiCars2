<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendOtp($address, $otp)
{
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // Gmail gửi
        $mail->Username = 'nhthin366@gmail.com';
        $mail->Password = 'qerw ouap mnmt kfrj';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('nhthin366@gmail.com', 'FUJICARS - Khôi phục mật khẩu');
        $mail->addAddress($address);

        $mail->isHTML(true);
        $mail->Subject = 'Mã OTP Xác Thực';
        $mail->Body = "
            <h2>Mã OTP Xác Thực</h2>
            <p>OTP của bạn là: <b>$otp</b></p>
            <p>Mã có hiệu lực trong 5 phút.</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}
