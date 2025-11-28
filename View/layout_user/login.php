<?php
include 'Controller/config/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập tài khoản | FujiCars</title>
<link rel="stylesheet" href="View/css/styleCss.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.5.1/css/all.css">
</head>
<body>
  <div class="fx-page">
    <main class="fx-content fx-login-page">
      <div class="fx-box">
        <div class="fx-login">
          <div class="fx-loginBx">
            <h2><i class="fa-solid fa-user-lock"></i>ĐĂNG NHẬP</h2>
            <?php if (isset($_GET['error'])): ?>
              <div class="fx-error"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>
            <form action="Controller/handle-user/login_process.php" method="POST">
              <input type="text" name="username" placeholder="Tên tài khoản" required>
          <div class="password-wrapper">
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <i class="fa-solid fa-eye toggle-password"></i>
          </div>
              <input type="submit" name="dangnhap" value="Đăng nhập">
              <div class="fx-group">
                <a href="View/layout_user/forgot_password.php">Quên mật khẩu?</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
<script>
  const togglePassword = document.querySelector(".toggle-password");
  const passwordInput = document.querySelector(".password-wrapper input");
  togglePassword.addEventListener("click", function () {
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
    this.classList.toggle("fa-eye-slash"); // đổi icon khi toggle
  });
</script>
  </div>
</body>
</html>
