<?php
include 'Controller/config/config.php';
$sql = "SELECT * FROM `sanpham` ORDER BY LoaiSP";
$kq = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<link rel="stylesheet" href="View/css/styleCss.css">
<meta charset="UTF-8">
<title>Danh sách sản phẩm</title>
</head>
<body class="ux-body">
</br>
</br>
</br>
<!-- ================== FILTER BUTTONS ================== -->
<div id="spx-btn-box">
  <button class="spx-btn spx-btn-active" onclick="filterSelection('all')">Tất cả</button>
  <button class="spx-btn" onclick="filterSelection('Suv')">Suv</button>
  <button class="spx-btn" onclick="filterSelection('Sedan')">Sedan</button>
  <button class="spx-btn" onclick="filterSelection('Hatchback')">Hatchback</button>
  <button class="spx-btn" onclick="filterSelection('Bán tải')">Bán tải</button>
  <button class="spx-btn" onclick="filterSelection('Đa dụng')">Đa dụng</button>
</div>

<!-- ================== PRODUCT LIST ================== -->
<div class="spx-row">
<?php
if (mysqli_num_rows($kq) > 0) {
  while ($row = mysqli_fetch_array($kq)) {

    $ImgPath = 'View/img/SP/' . $row['HinhAnh'];
    if (file_exists($ImgPath)) {

      $giaGoc = $row['Gia'];
      $giamPhanTram = 0;

      switch ($row['ID']) {
        case 1: case 5: case 14: $giamPhanTram = 10; break;
        case 3: case 12: case 16: $giamPhanTram = 15; break;
      }

      $giaGiam = ($giamPhanTram > 0)
        ? $giaGoc - ($giaGoc * $giamPhanTram / 100)
        : $giaGoc;
?>
  <!-- ⭐⭐ SỬA LỖI QUAN TRỌNG: thêm class spx-col để LỌC HOẠT ĐỘNG ⭐⭐ -->
  <div class="spx-col <?php echo htmlspecialchars($row['LoaiSP']); ?>">
    <div class="ux-card">

      <?php if ($giamPhanTram > 0): ?>
        <span class="ux-discount">-<?php echo $giamPhanTram; ?>%</span>
      <?php endif; ?>

      <a href="index.php?n=product-details&id=<?php echo $row['ID']; ?>">
        <div class="ux-img-box">
          <img src="<?php echo $ImgPath; ?>" class="ux-img" alt="">
        </div>
      </a>

      <div class="ux-name"><?php echo htmlspecialchars($row['TenSP']); ?></div>

      <div class="ux-price-box">
        <?php if ($giamPhanTram > 0): ?>
          <div class="ux-price-old"><?php echo number_format($giaGoc); ?> đ</div>
        <?php endif; ?>
        <div class="ux-price-new"><?php echo number_format($giaGiam); ?> đ</div>
      </div>

      <div class="ux-type"><?php echo htmlspecialchars($row['LoaiSP']); ?></div>

      <div class="ux-info">
        <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($row['MoTa']); ?></p>
        <p><strong>Nhiên liệu:</strong> <?php echo htmlspecialchars($row['NhienLieu'] ?? 'Đang cập nhật'); ?></p>
      </div>

      <a href="index.php?n=product-details&id=<?php echo $row['ID']; ?>" class="ux-btn">Xem chi tiết</a>

    </div>
  </div>

<?php
    }
  }
}
?>
</div>
<script>
<?php include "js/product.js"; ?>
</script>
</body>
</html>
