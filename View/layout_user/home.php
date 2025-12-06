<!doctype html>
<html lang="vi">
<head>
<link rel="stylesheet" href="View/css/styleCss.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FujjiCars</title>
<script type="importmap">
  {
    "imports": {
      "three": "https://unpkg.com/three@0.165.0/build/three.module.js",
      "three/addons/": "https://unpkg.com/three@0.165.0/examples/jsm/",
      "gsap": "https://cdn.skypack.dev/gsap@3.12.5"
    }
  } 
  </script>
</head>
<body>
  <!-- 🌟 HIỆU ỨNG LOADING XE CHẠY XỊT KHÓI -->
<div id="loadingOverlay">
  <div class="car-wrapper">
    <i class="fas fa-car-side car-icon"></i>
    <div class="smoke"></div>
    <div class="smoke smoke2"></div>
    <div class="smoke smoke3"></div>
  </div>
</div>
<script>
<?php include "js/car_loading.js"; ?>
</script>
<!-- Search & Filters -->
<!-- 💬 Chat AI tư vấn xe -->
<?php
include 'Controller/config/config.php';
// 🔹 Lấy dữ liệu sản phẩm
$sql = "SELECT TenSP, Gia, LoaiSP, MoTa FROM sanpham";
$result = mysqli_query($conn, $sql);
$products = [];

if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
  }
}
?>
<!-- 🔹 Avatar lơ lửng -->
<div class="chat-avatar" id="chatAvatar" title="Trò chuyện với Fuji AI"></div>
<img src="View/img/chat1.png" width="120" style="border:2px solid red">
  <!-- Tin nhắn nổi -->
  <div class="chat-floating-msg" id="floatingMsg">Tôi có thể giúp gì cho bạn?
  </div>
</div>
<!-- 💬 Hộp chat -->
<div class="chat-ai-wrapper" id="chatBoxContainer">
  <div class="chat-ai-header">
    <i class="fa fa-robot"></i> Fuji AI - Trợ lý tư vấn xe
  </div>

  <div class="chat-ai-box" id="chatBox">
    <div class="chat-ai-msg bot">
      Xin chào 👋! Tôi là <b>Fuji AI</b> – trợ lý tư vấn xe của bạn.<br>
      Hãy hỏi tôi về dòng xe, giá, loại động cơ hoặc gợi ý phù hợp nhé!
    </div>
  </div>
  <div class="chat-ai-input">
    <input type="text" id="chatInput" placeholder="Nhập câu hỏi của bạn...">
    <button id="sendChat"><i class="fa fa-paper-plane"></i></button>
  </div>
</div>
<!-- ✅ Include JavaScript đúng cách -->
<script>
    window.productsData = <?=
        json_encode($products, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    ?>;
</script>
<script src="js/ai.js"></script>

  <!-- 3D -->
<div class="body-3d">
  <div class="xe-huyen-thoai">
          <h3 class="tieu-de-su-kien">
</h3>
      <h3 class="tieu-de-su-kien">
  SỰ KIỆN RA MẮT & TRIỂN LÃM E-CLASS THẾ HỆ MỚI
</h3>
    <div id="khung-3d" class="khung-3d"></div>
  </div>
</div>
<!-- Gọi JS -->
<script type="module" src="js/3d.js"></script>
</br>
</br>
</br>
</br>
</br>
</br>
<?php
include 'Controller/config/config.php'; // file kết nối CSDL
// Các loại xe để tạo tab
$loaiXe = ["Sedan","Hatchback","SUV","Đa dụng","Bán tải"];
?>
<h1 class="main-title" style="text-align:left; font-size:36px; font-weight:700; margin:40px 0 30px; color:black;">

  &nbsp;KHÁM PHÁ CÁC DÒNG XE
</h1>
<br>
<!-- Tabs -->
<div class="tabs">
  <?php foreach ($loaiXe as $i => $loai) { ?>
    <div class="tab <?php echo ($i==0)?'active':''; ?>" data-tab="<?php echo $loai; ?>">
      <?php echo $loai; ?>
    </div>
  <?php } ?>
</div>
<!-- Sản phẩm theo loại -->
<?php
foreach ($loaiXe as $i => $loai) {
    echo "<div class='products-container " . ($i==0?"active":"") . "' id='tab-$loai'>";
    
    // ✅ Giới hạn chỉ lấy 3 sản phẩm
    $sql = "SELECT * FROM sanpham WHERE LoaiSP = '$loai' LIMIT 3";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $imgPath = "View/img/SP/" . $row['HinhAnh'];
            if (!file_exists($imgPath)) $imgPath = "View/img/noimage.png";
?>
    <div class="car-card">
      <a href="index.php?n=product-details&id=<?php echo $row['ID']; ?>">
        <img src="<?php echo $imgPath; ?>" alt="<?php echo htmlspecialchars($row['TenSP']); ?>">
      </a>
      <div class="car-name"><?php echo htmlspecialchars($row['TenSP']); ?></div>
      <div class="specs"><?php echo htmlspecialchars($row['MoTa']); ?></div>
      <div class="price"><?php echo number_format($row['Gia'], 0, ',', '.'); ?><span> VNĐ</span></div>
    </div>
<?php
        }
    } else {
        echo "<p>Không có xe trong dòng này.</p>";
    }
    echo "</div>";
}
?>
<br>
<!-- Script xử lý chuyển tab -->
<script>
<?php include "js/car-filter.js"; ?>
</script>
<!-- VIDEO QUẢNG CÁO Ô TÔ -->
<div class="video-section">
  <div class="video-container">
    <iframe src="https://www.youtube.com/embed/XhV8FQQlsKk"
      title="Quảng cáo Ô tô"
      frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
      allowfullscreen></iframe>
  </div>
  </div>
        <!-- DỊCH VỤ -->  
  <section class="mb-dich-vu">
       <h1 class="main-title">
  &nbsp;    DỊCH VỤ</h1>   
  <div class="mb-container">
    <div class="mb-service-row">
      <!-- Cột trái -->
      <div class="mb-service-item">
        <div class="mb-service-image">
          <img src="View/img/dv1.webp" alt="Chương trình Khách hàng thân thiết">
        </div>
        <h3 class="mb-service-title">Chương trình Khách hàng thân thiết</h3>
        <p class="mb-service-desc">
          Không ngừng nỗ lực đem tới cảm giác an tâm và nâng tầm trải nghiệm, Mercedes-Benz Việt Nam mang đến chương trình Khách hàng thân thiết với ưu đãi lên đến 30% với chủ xe đồng hành trên 4 năm.
        </p>
        <button class="mb-btn-service">Tìm hiểu thêm</button>
      </div>
      <!-- Cột phải -->
      <div class="mb-service-item">
        <div class="mb-service-image">
          <img src="View/img/dv2.avif" alt="Thông tin Dịch vụ Khách hàng">
        </div>
        <h3 class="mb-service-title">Thông tin Dịch vụ Khách hàng</h3>
        <p class="mb-service-desc">
          Chương trình Gia hạn Bảo hành ô tô giúp chủ sở hữu 
an tâm tận hưởng hành trình trước mọi sự cố bất ngờ.
Diễn ra sau khi chế độ bảo hành tiêu chuẩn kết thúc, sửa chữa miễn phí trong phạm vi bảo hành lên đến 2 năm.
        </p>
        <button class="mb-btn-service">Tìm hiểu thêm</button>
      </div>
    </div>
  </div>
</section>
  </br>
<!-- Font Awesome cho icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- anime.js cho animation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<section class="fx-form-section">
  <h3  style="color: red">Đăng ký lái thử xe</h3>
  <form id="fx-formDangKy">
    <!-- Chọn xe -->
    <select name="ID" id="ID" required>
      <option value="">Chọn xe muốn lái thử *</option>
      <?php
      include("Controller/config/config.php");
      $sql = "SELECT ID, TenSP FROM sanpham";
      $result = mysqli_query($conn, $sql);
      while($row = mysqli_fetch_assoc($result)):
      ?>
        <option value="<?= $row['ID'] ?>"><?= htmlspecialchars($row['TenSP']) ?></option>
      <?php endwhile; ?>
    </select>
    <!-- Thông tin khách hàng -->
    <input type="text" name="hoten" placeholder="Họ và tên của bạn *" required>
    <input type="email" name="email" placeholder="Email của bạn *" required>
    <input type="tel" name="sdt" placeholder="Số điện thoại liên hệ *" required>
    <!-- Ngày lái thử -->
<input type="text" id="ngay" name="ngay" placeholder="Chọn ngày lái thử" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" required>
    <!-- Giờ lái thử -->
    <select name="gio" id="gio" required>
      <option value="">Chọn giờ</option>
      <option value="09:00">09:00</option>
      <option value="10:00">10:00</option>
      <option value="11:00">11:00</option>
      <option value="13:00">13:00</option>
      <option value="14:00">14:00</option>
      <option value="15:00">15:00</option>
    </select>
    <!-- Địa chỉ lái thử -->
    <input type="text" name="diachi" placeholder="Nhập địa chỉ lái thử *" required>
    <!-- Ghi chú -->
    <textarea name="ghichu" placeholder="Ghi chú thêm (nếu có)" rows="3"></textarea>
    <!-- Checkbox -->
    <div class="fx-checkbox-group">
      <input type="checkbox" name="agree" checked required>
      Tôi đồng ý với <a href="#">chính sách bảo mật</a>
    </div>
    <button type="submit" class="fx-submit" style="background: linear-gradient(90deg, #e60000, #b30000); color: #fff;">Đăng ký lái thử</button>
  </form>
</section>
<!-- Overlay loading + thông báo -->
<div id="fx-overlay" style="display:none;">
  <div class="fx-message">
    <i id="fx-icon" class="fas fa-spinner fa-spin fa-3x"></i>
    <p id="fx-text">Đang gửi đăng ký...</p>
  </div>
</div>
  <script src="js/register_test-drive.js"></script>
</br>
</br>
<script>
document.querySelectorAll(".mb-btn-service").forEach(btn => {
    btn.addEventListener("click", function () {
        window.location.href = "?n=service";
    });
});
</script>
</body>
</html>
