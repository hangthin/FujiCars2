<?php
include("Controller/config/config.php"); 
$message = "";
$is_error = false;

/* ====== XỬ LÝ THÊM ====== */
if (isset($_POST['them'])) {
    $TenSP = mysqli_real_escape_string($conn, $_POST['TenSP']);
    $MoTa = $_POST['MoTa'];
    $NgayCapNhat = $_POST['NgayCapNhat'];
    $LoaiSP = $_POST['LoaiSP'];
    $Gia = $_POST['Gia'];
    $SoLuong = $_POST['SoLuong'];
    $NhienLieu = $_POST['NhienLieu'];
    $XuatXu = $_POST['XuatXu'];

    $HinhAnh = '';
    if (!empty($_POST['HinhAnhURL'])) {
        $HinhAnh = $_POST['HinhAnhURL'];
    } elseif (!empty($_FILES['HinhAnhFile']['name'])) {
        $targetDir = "View/img/SP/";
        if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
        $fileName = basename($_FILES['HinhAnhFile']['name']);
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['HinhAnhFile']['tmp_name'], $targetFile)) {
            $HinhAnh = $fileName;
        } else {
            $message = "Không thể tải ảnh lên.";
            $is_error = true;
        }
    }

    if (!$is_error) {
        $sql = "INSERT INTO sanpham (TenSP, MoTa, NgayCapNhat, HinhAnh, LoaiSP, Gia, SoLuong, NhienLieu, XuatXu)
                VALUES ('$TenSP','$MoTa','$NgayCapNhat','$HinhAnh','$LoaiSP','$Gia','$SoLuong','$NhienLieu','$XuatXu')";
        if (mysqli_query($conn, $sql)) $message = "Thêm sản phẩm thành công!";
        else { $message = "Lỗi khi thêm: ".mysqli_error($conn); $is_error = true; }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm sản phẩm ô tô</title>
<link rel="stylesheet" href="View/css/styleCss.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="nxadmin-body">
<!-- Overlay thông báo -->
<div class="nx-overlay" id="nxOverlay">
  <div class="nx-box" id="nxBox">
    <div class="spinner" id="nxSpinner"></div>
    <svg class="checkmark" id="nxCheck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="checkmark__circle" cx="26" cy="26" r="25"/>
      <path class="checkmark__check" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
    </svg>
    <svg class="errormark" id="nxError" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="errormark__circle" cx="26" cy="26" r="25"/>
      <path class="errormark__cross" d="M16 16 36 36 M36 16 16 36"/>
    </svg>
    <h2 id="nxMsgTitle">Đang xử lý...</h2>
    <p id="nxMsgText">Vui lòng chờ trong giây lát</p>
  </div>
</div>
<div class="nxadmin-wrapper">
<h2 class="nxadmin-title"><i class="fa-solid fa-cube"></i> THÊM SẢN PHẨM</h2>
<form class="nxadmin-form" method="POST" enctype="multipart/form-data">
    <div class="nxadmin-row">
      <div class="nxadmin-group">
        <label>Tên sản phẩm:</label>
        <input type="text" id="TenSP" name="TenSP" value="" required>
      </div>
      <div class="nxadmin-group">
        <label>Loại SP:</label>
        <select name="LoaiSP" id="LoaiSP" required>
          <option value="">Chọn loại</option>
          <option value="Sedan">Sedan</option>
          <option value="Suv">Suv</option>
          <option value="Bán tải">Bán tải</option>
          <option value="Đa dụng">Đa dụng</option>
          <option value="Hatchback">Hatchback</option>
        </select>
      </div>
    </div>
    <div class="nxadmin-row">
      <div class="nxadmin-group">
        <label>Giá:</label>
        <input type="text" name="Gia" id="Gia" value="100000000" required>
      </div>
      <div class="nxadmin-group">
        <label>Số lượng:</label>
        <input type="number" name="SoLuong" id="SoLuong" value="1" required>
      </div>
    </div>
    <div class="nxadmin-row">
      <div class="nxadmin-group">
        <label>Nhiên liệu:</label>
        <select name="NhienLieu" id="NhienLieu" required>
          <option value="">Chọn nhiên liệu</option>
          <option value="Xăng">Xăng</option>
          <option value="Điện">Điện</option>
        </select>
      </div>
      <div class="nxadmin-group">
        <label>Xuất xứ:</label>
        <select name="XuatXu" id="XuatXu" required>
          <option value="">Chọn xuất xứ</option>
          <option value="Đức">Đức</option>
          <option value="Thái Lan">Thái Lan</option>
          <option value="Nhật Bản">Nhật Bản</option>
          <option value="Indonesia">Indonesia</option>
          <option value="Hàn Quốc">Hàn Quốc</option>
        </select>
      </div>
    </div>
    <div class="nxadmin-row">
      <div class="nxadmin-group">
        <label>Ngày cập nhật:</label>
        <input type="date" id="NgayCapNhat" name="NgayCapNhat" value="<?= date('Y-m-d') ?>" required>
      </div>
      <div class="nxadmin-group nx-imgbox">
        <label>Hình ảnh:</label>
        <div class="nx-img-input">
          <input type="file" name="HinhAnhFile" id="HinhAnhFile" accept="image/*">
          <input type="text" name="HinhAnhURL" id="HinhAnhURL" placeholder="Hoặc dán URL hình ảnh">
          <div class="nx-img-preview">
            <img id="PreviewImg" src="View/img/SP/mau.png" alt="preview">
          </div>
        </div>
      </div>
    </div>
    <div class="nxadmin-group">
      <label>Mô tả:</label>
      <select name="MoTa" id="MoTa" required>
        <option value="">Chọn</option>
        <option value="5 chỗ">5 chỗ</option>
        <option value="7 chỗ">7 chỗ</option>
      </select>
    </div>
    <div class="nxadmin-controls">
      <button class="nxadmin-btn nxadmin-btn-add" name="them"><i class="fa-solid fa-plus"></i> Thêm sản phẩm</button>
      <button type="button" class="nxadmin-btn nxadmin-btn-cancel" id="btnHuy"><i class="fa-solid fa-xmark"></i> Hủy</button>
    </div>
</form>
</div>
<script>
// Xem trước ảnh khi chọn file
document.getElementById('HinhAnhFile').addEventListener('change', function(e){
    const preview = document.getElementById('PreviewImg');
    const file = e.target.files[0];
    if(file){
        preview.src = URL.createObjectURL(file);
    } else {
        preview.src = 'View/img/SP/mau.png';
    }
});
// Nút hủy reset form
document.getElementById('btnHuy').addEventListener('click', function(){
    document.querySelector('.nxadmin-form').reset();
    document.getElementById('PreviewImg').src = 'View/img/SP/mau.png';
});
// Hiển thị overlay thông báo
<?php if($message): ?>
document.addEventListener('DOMContentLoaded',()=>{
  const overlay=document.getElementById('nxOverlay');
  const box=document.getElementById('nxBox');
  const spinner=document.getElementById('nxSpinner');
  const check=document.getElementById('nxCheck');
  const err=document.getElementById('nxError');
  const title=document.getElementById('nxMsgTitle');
  const text=document.getElementById('nxMsgText');

  overlay.style.display='flex';
  spinner.style.display='block';
  check.style.display='none';
  err.style.display='none';
  title.innerText='Đang xử lý...';
  text.innerText='Vui lòng chờ trong giây lát';

  setTimeout(()=>{
    spinner.style.display='none';
    if(<?= $is_error ? 'true':'false' ?>){
      err.style.display='block';
      title.innerText='Thất bại';
      text.innerText="<?= addslashes($message) ?>";
    } else {
      check.style.display='block';
      title.innerText='Thành công';
      text.innerText="<?= addslashes($message) ?>";
    }
    setTimeout(()=>{ box.style.animation='zoomOut 0.4s ease forwards'; setTimeout(()=> overlay.style.display='none',350); },2500);
  },1500);
});
<?php endif; ?>
</script>
</body>
</html>
