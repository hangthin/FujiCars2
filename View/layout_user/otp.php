<?php
session_start();

if(!isset($_SESSION['otp'])){
    header("Location: forgot_password.php");
    exit;
}

$err = '';
if(isset($_POST['btn_confirm'])){
    $otp = $_POST['otp'];
    if($_SESSION['otp'] != $otp){
        $err = "Mã xác nhận không chính xác!";
    } else {
        header("Location: change_password.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Nhập OTP</title>
<style>
/* === RESET CƠ BẢN === */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* === TOÀN TRANG === */
body {
    background: linear-gradient(135deg, #1a1a1a, #2c2c2c);
    font-family: 'Segoe UI', Arial, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* === KHUNG NGOÀI === */
.main-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

/* === FORM CONTAINER === */
.container {
    background: #ffffff;
    width: 100%;
    max-width: 420px;
    padding: 35px 30px;
    border-radius: 12px;
    box-shadow: 0 6px 25px rgba(255, 0, 0, 0.25);
    text-align: center;
    border-top: 5px solid #d32f2f;
}

/* === TIÊU ĐỀ FORM === */
.form-title {
    font-size: 24px;
    font-weight: 700;
    color: #d32f2f;
    margin-bottom: 25px;
}

/* === THÔNG BÁO LỖI === */
.form-message {
    color: #ff0000;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 15px;
    display: block;
}

/* === NHÓM INPUT === */
.form-group {
    text-align: left;
    margin-bottom: 18px;
}

.form-group label {
    font-weight: 600;
    display: block;
    margin-bottom: 6px;
    color: #111;
}

.form-group input {
    width: 100%;
    padding: 10px;
    font-size: 15px;
    border-radius: 6px;
    border: 1px solid #bbb;
    background-color: #fafafa;
    transition: border 0.3s;
}

.form-group input:focus {
    border-color: #d32f2f;
    outline: none;
    box-shadow: 0 0 5px rgba(211, 47, 47, 0.3);
}

/* === NÚT XÁC NHẬN === */
.form-submit {
    width: 100%;
    padding: 12px;
    background-color: #d32f2f;
    border: none;
    border-radius: 6px;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

.form-submit:hover {
    background-color: #b71c1c;
}

/* === NÚT QUAY LẠI === */
.btn-cancel {
    display: inline-block;
    width: 100%;
    margin-top: 12px;
    padding: 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 2px solid #d32f2f;
    background: white;
    color: #d32f2f;
    font-weight: 600;
    text-decoration: none;
    transition: 0.3s ease;
}

.btn-cancel:hover {
    background: #d32f2f;
    color: white;
}

/* === HIỆU ỨNG NHẸ === */
.container:hover {
    transform: translateY(-3px);
    transition: 0.3s ease-in-out;
}

</style>
</head>
<body>
<div class="main-wrapper">
    <div class="container">
        <div class="form-wrapper">
            <h3 class="form-title">Nhập mã xác nhận</h3>
            <form action="" method="post" class="login-form">
                <span class="form-message"><?php if($err) echo $err; ?></span>
                <div class="form-group">
                    <label for="otp">OTP</label>
                    <input type="text" id="otp" name="otp" placeholder="Mã xác nhận gửi vào email..." required>
                </div>
                <button name="btn_confirm" type="submit" class="form-submit">XÁC NHẬN</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
