<?php
session_start();
session_destroy(); // Xóa toàn bộ session
header("Location: index.php"); // Quay lại trang chủ
exit();
?>