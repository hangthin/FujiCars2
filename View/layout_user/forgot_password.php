<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quên Mật Khẩu</title>
<style>
body { font-family: Arial,sans-serif; background:#fff; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; color:#000; }
.container { width:100%; max-width:400px; background:#fff; padding:25px; border-radius:10px; box-shadow:0px 0px 10px rgba(255,0,0,0.2); text-align:center; border:2px solid #e53935; }
h2 { color:#e53935; margin-bottom:20px; }
label { display:block; text-align:left; margin-top:10px; font-weight:bold; }
input[type="text"], input[type="email"] { width:100%; padding:10px; margin:8px 0; border:1px solid #ccc; border-radius:6px; }
button { width:48%; padding:10px; margin:10px 1%; border:none; border-radius:6px; cursor:pointer; font-size:16px; color:white; }
.btn-submit { background:#e53935; } .btn-submit:hover { background:#b71c1c; } 
.btn-close { background:#000; } .btn-close:hover { background:#333; } 
.error { color:red; margin-top:10px; }
</style>
</head>
<body>

<div class="container">
    <h2>Quên Mật Khẩu</h2>
    <form id="forgotForm">
        <label for="sdt">Số Điện Thoại</label>
        <input type="text" id="sdt" name="phone" placeholder="Nhập số điện thoại" required>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Nhập Email" required>

        <div>
            <button type="button" onclick="closeModal()" class="btn-close">Đóng</button>
            <button type="submit" class="btn-submit">Gửi Yêu Cầu</button>
        </div>
        <div class="error" id="errorMsg"></div>
    </form>
</div>

<script>
function closeModal() {
    window.location.href = "index.php?n=login";
}

document.getElementById("forgotForm").addEventListener("submit", function(e){
    e.preventDefault();
    const formData = new FormData(this);

    // Gửi dữ liệu lên server
    fetch("../../Controller/handle-user/process_forgot-password.php", {
        method: "POST",
        body: formData
    })
    .finally(() => {
        // Chuyển thẳng sang trang OTP bất kể kết quả
        window.location.href = "otp.php";
    });
});


</script>
</body>
</html>
