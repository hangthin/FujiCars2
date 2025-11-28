<?php
// register.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Đăng Ký Người Dùng | FujiCars</title>
<link rel="stylesheet" href="View/css/styleCss.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
</head>
<body>
<div class="fx-page">
  <main class="fx-content fx-login-page">
    <div class="fx-box">
      <div class="fx-login">
        <div class="fx-loginBx">
          <h2><i class="fa-solid fa-user-plus"></i>ĐĂNG KÝ</h2>
          <form action="Controller/handle-user/process_register.php" method="post">
            <input type="text" name="TenTK" placeholder="Tên tài khoản" required>
            <div class="password-wrapper">
              <input type="password" name="MatKhau" placeholder="Mật khẩu" required>
              <i class="fa-solid fa-eye toggle-password"></i>
            </div>
            <input type="text" name="DiaChi" placeholder="Địa chỉ..">
            <input type="email" name="email" placeholder="Email..">
            <input type="text" name="phone" placeholder="Phone..">
            <div class="fx-group" style="justify-content: space-between;">
              <button type="button" class="cancel" onclick="resetForm()">HỦY</button>
              <button type="submit" class="submit">ĐĂNG KÝ</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</div>
<script>
// Toggle password con mắt
const togglePassword = document.querySelector(".toggle-password");
const passwordInput = document.querySelector(".password-wrapper input");
togglePassword.addEventListener("click", function () {
  const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
  passwordInput.setAttribute("type", type);
  this.classList.toggle("fa-eye-slash");
});
// Reset form
function resetForm() {
  const form = document.querySelector("form");
  if (form) form.reset();
  passwordInput.setAttribute("type", "password");
  togglePassword.classList.remove("fa-eye-slash");
}
</script>
</body>
</html>
