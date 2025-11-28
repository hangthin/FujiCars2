<?php
/**
 * emitNewOrder
 * ----------------------------------------------
 * Gửi thông tin đơn hàng mới sang server Node.js (Render)
 * để Node phát sự kiện "newOrder" qua Socket.IO.
 *
 * @param array $orderData
 * @return string|null
 */
function emitNewOrder($orderData)
{
    // ========== URL NODE.JS TRÊN RENDER (DÙNG CHUNG CHO MỌI MÔI TRƯỜNG) ==========
    $url = "https://nodejs-53zg.onrender.com/emit-order";

    // ========== JSON PAYLOAD ==========
    $payload = json_encode($orderData, JSON_UNESCAPED_UNICODE);

    // ========== CURL REQUEST ==========
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => ["Content-Type: application/json"],
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_TIMEOUT        => 2,                 // Không khóa PHP
        CURLOPT_SSL_VERIFYPEER => false,             // Cho phép mọi hosting chạy
        CURLOPT_SSL_VERIFYHOST => false
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
?>
