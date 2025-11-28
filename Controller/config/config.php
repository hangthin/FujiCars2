<?php
    global $conn;

    // Kiểm tra đang chạy ở local hay hosting
    $isLocal = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);

    if ($isLocal) {
        // 👉 Cấu hình LOCAL
        $servername = "127.0.0.1";
        $database = "oto";      // tên database local
        $username = "root";
        $password = "rootroot";
    } else {
        // 👉 Cấu hình HOSTING InfinityFree (Mới)
        $servername = "sql301.infinityfree.com";   // 🔥 Hostname mới
        $database = "if0_40485819_oto";            // 🔥 Database mới
        $username = "if0_40485819";                // 🔥 Username mới
        $password = "hangthien2105";               // 🔥 Password mới
    }

    // Kết nối đến database
    $conn = mysqli_connect($servername, $username, $password, $database);

    // Kiểm tra kết nối
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Thiết lập bảng mã UTF-8
    mysqli_set_charset($conn, "utf8");
?>
