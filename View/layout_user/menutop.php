<?php
include 'Controller/config/config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FujiCars</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="View/css/styleCss.css">
</head>
<body class="fjx-body">
  <div class="fjx-navbar">
    <div class="fjx-left">
      <a href="index.php" data-key="home">Trang Chủ</a>
      <a href="?n=introduce" data-key="product">Giới Thiệu</a>
      <a href="?n=product" data-key="product">Sản Phẩm</a>
      <a href="?n=register" data-key="register">Đăng Ký</a>
      <a href="?n=cart" data-key="cart">Giỏ Hàng</a>
    </div>
<div class="fjx-center">
  <a href="index.php" class="fjx-logo-link">
    <img src="View/img/logo.png" alt="Logo FujiCars">
    <span class="fjx-logo-text">FujiCars</span>
  </a>
</div>
<div class="fjx-right">
  <a href="#" id="fjx-search-icon"><i class="fa fa-search"></i></a>
  <button class="fjx-lang-btn" id="fjx-open-lang"><i class="fa fa-globe"></i></button>

  <?php if(isset($_SESSION['TenTK'])): ?>
<div class="fjx-account">
    <a href="?n=account" class="fjx-username-link">
        <i class="fa fa-user-circle" style="font-size:24px;color:#fff;"></i>
        <?= htmlspecialchars($_SESSION['TenTK']) ?>
    </a>
    <a href="?logout=1" class="fjx-logout-link">
        <i class="fa fa-sign-out" style="font-size:18px;color:#fff;"></i> Đăng Xuất
    </a>
</div>
<?php else: ?>
<a href="?n=login" class="fjx-account-link">
    <i class="fa fa-user-circle" style="font-size:24px;color:#fff;"></i>
    <span data-key="login">Đăng Nhập</span>
</a>
<?php endif; ?>
</div>
  </div>
  <!-- Ô tìm kiếm -->
  <form class="fjx-search-box" id="fjx-search-box" method="get" action="index.php">
    <input type="hidden" name="search" value="1">
    <input type="text" name="TenSP" placeholder="Nhập tên xe ô tô...">
    <button type="submit"><i class="fa fa-search"></i></button>
  </form>
  <!-- Popup chọn ngôn ngữ -->
  <div class="fjx-overlay" id="fjx-overlay"></div>
  <div class="fjx-lang-popup" id="fjx-lang-popup">
    <span class="fjx-close-popup" id="fjx-close-lang">&times;</span>
    <h3>Chọn ngôn ngữ của bạn</h3>
    <div class="fjx-lang-option" data-lang="en">English</div>
    <div class="fjx-lang-option" data-lang="vi">Tiếng Việt</div>
  </div>
<!-- ============ PHP HIỂN THỊ KẾT QUẢ ============ -->
<?php
if (isset($_GET['search'])) {
    $TenSP = trim($_GET['TenSP']);
    $sql = "SELECT * FROM sanpham WHERE TenSP LIKE '%$TenSP%'";
    $kq = mysqli_query($conn, $sql);
    echo "<h2 style='text-align:center;color:#000;margin-top:120px;'>KẾT QUẢ TÌM KIẾM: 
          <span style=\"color:red;\">$TenSP</span></h2>";
    echo "<div class='fjx-result-area'>";
    if (mysqli_num_rows($kq) > 0) {
        while ($row = mysqli_fetch_assoc($kq)) {
            $link = "?n=product-details&id=" . $row['MaSP'];
            echo "<div class='fjx-product-card'>";
            // Nhấn ảnh → chuyển trang chi tiết
            echo "<a href='$link'>";
            echo "<img src='View/img/SP/" . $row['HinhAnh'] . "' alt='" . $row['TenSP'] . "'>";
            echo "</a>";
            echo "<h4>" . $row['TenSP'] . "</h4>";
            echo "<p>" . number_format($row['Gia'], 0, ',', '.') . "₫</p>";
            echo "</div>";
        }
    } else {
        echo "<p style='text-align:center;color:#555;'>Không tìm thấy sản phẩm nào.</p>";
    }
    echo "</div>";
}
?>
  <script>
<?php include "js/menu-user.js"; ?>
  </script>
</body>
</html>
