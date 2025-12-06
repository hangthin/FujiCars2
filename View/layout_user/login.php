<?php
// login.php
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

            <?php
            $host = ($_SERVER['HTTP_HOST'] === 'localhost') ? 'http://localhost/fujicars' : 'https://fujicars.ct.ws';
            $google_callback = $host . '/Controller/handle-user/google_callback.php';
            ?>

            <!-- Google Login -->
            <div id="g_id_onload"
                 data-client_id="854782132762-039qpgpr889fj141p2bgnbf711uri77s.apps.googleusercontent.com"
                 data-login_uri="<?= $google_callback ?>"
                 data-auto_prompt="false">
            </div>
            <div class="g_id_signin"
                 data-type="standard"
                 data-shape="rectangular"
                 data-theme="outline"
                 data-text="sign_in_with"
                 data-size="large"
                 data-logo_alignment="left">
            </div>

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
        this.classList.toggle("fa-eye-slash");
      });
    </script>

    <script src="https://accounts.google.com/gsi/client" async defer></script>
  </div>
</body>
</html>
