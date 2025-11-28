<?php
// Chức năng: Gửi dữ liệu đơn hàng sang server Node.js
// để kích hoạt sự kiện realtime Socket.IO
/**
 * emitNewOrder
 * ----------------------------------------------
 * Hàm này dùng để gửi thông tin đơn hàng mới 
 * từ PHP sang server Node.js qua HTTP POST.
 * Khi Node nhận được, nó sẽ phát (emit) 
 * sự kiện "newOrder" đến tất cả client admin.
 * 
 * @param array $orderData  Mảng dữ liệu đơn hàng mới
 * @return mixed            Phản hồi từ server Node (nếu có)
 */
function emitNewOrder($orderData) {

    // URL API trên server Node.js dùng để phát sự kiện
    $url = "http://localhost:3000/emit-order";

    // Chuyển mảng PHP thành JSON để gửi đi
    $payload = json_encode($orderData);

    // Cấu hình request POST gửi tới Node.js
    $opts = [
        "http" => [
            "method"  => "POST",                        // Gửi bằng POST
            "header"  => "Content-Type: application/json\r\n", // Gửi dữ liệu kiểu JSON
            "content" => $payload,                      // JSON chứa thông tin đơn hàng
            "timeout" => 3                              // Timeout sau 3 giây nếu Node.js không phản hồi
        ]
    ];

    // Tạo context request HTTP theo cấu hình trên
    $context = stream_context_create($opts);

    // Gửi request đến Node.js
    // @ dùng để tránh hiển thị warning nếu Node.js tắt hoặc lỗi
    return @file_get_contents($url, false, $context);
}
?>
