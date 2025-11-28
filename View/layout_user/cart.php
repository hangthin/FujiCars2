<?php
session_start();
include "Controller/config/config.php";

// Kiểm tra đăng nhập
$loggedIn = isset($_SESSION['ID']);
$MaKH = $loggedIn ? $_SESSION['ID'] : null;

// Nếu đăng nhập thì lấy giỏ hàng từ database
$cart = [];
if ($loggedIn) {
    $cartQuery = $conn->prepare("
        SELECT g.MaSP, g.SoLuong, s.TenSP, s.HinhAnh, s.Gia
        FROM giohang g
        JOIN sanpham s ON g.MaSP = s.ID
        WHERE g.MaKH = ?
    ");
    $cartQuery->bind_param("i", $MaKH);
    $cartQuery->execute();
    $cart = $cartQuery->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Giỏ hàng của bạn</title>
<link rel="stylesheet" href="View/css/styleCss.css">
</head>
<body class="cartx-body">
</br><br><br><br>

<div class="cartx-container">
  <h1 class="cartx-title">GIỎ HÀNG CỦA BẠN</h1>

  <?php if (!$loggedIn): ?>

      <!-- 🟥 CHƯA ĐĂNG NHẬP —> HIỆN THÔNG BÁO -->
      <div class="cartx-empty-box">
          <img src="https://cdn-icons-png.flaticon.com/512/102/102661.png">
          <div class="cartx-empty-text">
              Giỏ hàng trống!<br>Bạn cần đăng nhập để xem giỏ hàng.
          </div>
          <a class="cartx-login-btn" href="index.php?n=login">Đăng nhập ngay</a>
      </div>

  <?php elseif (!empty($cart)): ?>

      <!-- 🟦 ĐÃ ĐĂNG NHẬP & CÓ GIỎ HÀNG -->
      <?php  
          $ids = array_column($cart, 'MaSP');
          $idsString = implode(",", $ids);
      ?>

      <table class="cartx-table">
        <thead>
          <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Hành động</th>
          </tr>
        </thead>

        <tbody>
        <?php 
        $tongTien = 0;
        foreach ($cart as $item):
            $thanhTien = $item['Gia'] * $item['SoLuong'];
            $tongTien += $thanhTien;
        ?>
          <tr data-id="<?= $item['MaSP'] ?>">
            <td><img src="View/img/SP/<?= htmlspecialchars($item['HinhAnh']) ?>" alt=""></td>
            <td><?= htmlspecialchars($item['TenSP']) ?></td>
            <td><?= number_format($item['Gia']) ?> VNĐ</td>
            <td><?= $item['SoLuong'] ?></td>
            <td><?= number_format($thanhTien) ?> VNĐ</td>
            <td class="cartx-actions">
              <button class="cartx-plus">+</button>
              <button class="cartx-minus">−</button>
              <button class="cartx-delete">Xóa</button>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>

      <br>

      <div class="cartx-summary">
          <div class="cartx-total">Tổng cộng: <?= number_format($tongTien) ?> VNĐ</div>

          <a href="View/layout_user/pay-now.php?n=<?= $idsString ?>" class="cartx-checkout">
              Thanh toán
          </a>
      </div>

  <?php else: ?>

      <!-- 🟨 ĐĂNG NHẬP NHƯNG GIỎ HÀNG TRỐNG -->
      <div class="cartx-empty-box">
          <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png">
          <div class="cartx-empty-text">Giỏ hàng của bạn đang trống!</div>
      </div>

  <?php endif; ?>
</div>

<?php if ($loggedIn): ?>
<script>
// AJAX cộng trừ xóa
document.querySelectorAll('.cartx-actions button').forEach(btn => {
  btn.addEventListener('click', () => {
    const row = btn.closest('tr');
    const id = row.dataset.id;

    let action = '';
    if (btn.classList.contains('cartx-plus')) action = 'plus';
    if (btn.classList.contains('cartx-minus')) action = 'minus';
    if (btn.classList.contains('cartx-delete')) action = 'delete';

    fetch('Controller/handle-admin/process_add_to_cart.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'action=' + action + '&id=' + id
    })
    .then(r => r.text())
    .then(d => {
      if (d.trim() === 'success') location.reload();
      else alert('Lỗi: ' + d);
    });
  });
});
</script>
<?php endif; ?>

</body>
</html>
