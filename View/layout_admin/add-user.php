<?php
include 'Controller/config/config.php';

// --- Biến thông báo ---
$message = "";
$is_error = false;

// --- Xử lý POST (thêm/sửa) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $TenTK = trim($_POST['TenTK']);
    $MatKhau = trim($_POST['MatKhau']);
    $Quyen = trim($_POST['Quyen']);
    $NgayCapNhat = date('Y-m-d H:i:s');
    $DiaChi = trim($_POST['DiaChi']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);

    if (!empty($MatKhau)) {
        $MatKhau = password_hash($MatKhau, PASSWORD_DEFAULT);
    } elseif ($id > 0) {
        $old = mysqli_query($conn, "SELECT MatKhau FROM nguoidung WHERE ID = $id");
        $oldPass = mysqli_fetch_assoc($old);
        $MatKhau = $oldPass['MatKhau'] ?? '';
    }

    $emailCheck = mysqli_real_escape_string($conn, $email);
    $phoneCheck = mysqli_real_escape_string($conn, $phone);
    $idCheck = $id > 0 ? "AND ID != $id" : "";

    $sqlExist = "SELECT * FROM nguoidung WHERE (email='$emailCheck' OR phone='$phoneCheck') $idCheck LIMIT 1";
    $resExist = mysqli_query($conn, $sqlExist);

    if (mysqli_num_rows($resExist) > 0) {
        $message = "Email hoặc số điện thoại đã tồn tại!";
        $is_error = true;
    } else {
        if ($id > 0) {
            $sql = "UPDATE nguoidung 
                    SET TenTK='".mysqli_real_escape_string($conn,$TenTK)."',
                        MatKhau='".mysqli_real_escape_string($conn,$MatKhau)."',
                        Quyen='".mysqli_real_escape_string($conn,$Quyen)."',
                        NgayCapNhat='$NgayCapNhat',
                        DiaChi='".mysqli_real_escape_string($conn,$DiaChi)."',
                        phone='".mysqli_real_escape_string($conn,$phone)."',
                        email='".mysqli_real_escape_string($conn,$email)."'
                    WHERE ID=$id";
            $message = "Cập nhật người dùng thành công!";
        } else {
            $sql = "INSERT INTO nguoidung (TenTK, MatKhau, Quyen, NgayCapNhat, DiaChi, phone, email)
                    VALUES ('".mysqli_real_escape_string($conn,$TenTK)."',
                            '".mysqli_real_escape_string($conn,$MatKhau)."',
                            '".mysqli_real_escape_string($conn,$Quyen)."',
                            '$NgayCapNhat',
                            '".mysqli_real_escape_string($conn,$DiaChi)."',
                            '".mysqli_real_escape_string($conn,$phone)."',
                            '".mysqli_real_escape_string($conn,$email)."')";
            $message = "Thêm người dùng mới thành công!";
        }

        if (!mysqli_query($conn, $sql)) {
            $message = "Lỗi SQL: " . mysqli_error($conn);
            $is_error = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm / Cập nhật người dùng</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* ----- FORM ----- */
body {font-family: "Segoe UI", sans-serif; background:#f4f6f9; margin:0; padding:0;}
.nxu_container {max-width:700px; margin:50px auto; background:#fff; border-radius:15px; padding:30px; box-shadow:0 8px 20px rgba(0,0,0,0.15);}
.nxu_header {text-align:center; font-size:24px; font-weight:600; color:red; margin-bottom:25px;}
.nxu_form {display:flex; flex-direction:column; gap:18px;}
.nxu_row {display:grid; grid-template-columns:1fr 1fr; gap:20px;}
.nxu_group {display:flex; flex-direction:column;}
.nxu_label {margin-bottom:6px; font-weight:500; color:#333;}
.nxu_input, .nxu_input textarea, .nxu_input select {padding:10px 12px; border-radius:8px; border:1px solid #ccc; font-size:14px; width:100%; box-sizing:border-box; transition:0.2s;}
.nxu_input:focus, .nxu_input textarea:focus, .nxu_input select:focus {border-color:#0f1940; box-shadow:0 0 5px rgba(15,25,64,0.3); outline:none;}
.nxu_input textarea {resize:vertical; min-height:80px;}
.nxu_btn-save {background:red; color:#fff; border:none; padding:12px 0; font-size:16px; font-weight:600; border-radius:10px; cursor:pointer; transition:0.3s; margin-top:15px;}
.nxu_btn-save:hover {background:black;}
@media(max-width:600px){.nxu_row{grid-template-columns:1fr;}}

/* ----- OVERLAY ----- */
.nxu_overlay {position:fixed; inset:0; display:none; align-items:center; justify-content:center; background:rgba(0,0,0,0.75); z-index:9999;}
.nxu_box {background:#1b1b1b; color:#fff; padding:32px 44px; border-radius:14px; text-align:center; border:1px solid #ff2e2e; box-shadow:0 0 20px rgba(255,0,0,0.2); transform:scale(0.95); opacity:0; animation:nxu_boxIn .18s forwards;}
@keyframes nxu_boxIn { to { transform:scale(1); opacity:1; } }
.nxu_spinner {width:56px;height:56px; border:4px solid rgba(255,255,255,0.15); border-top:4px solid #ff2e2e; border-radius:50%; margin:0 auto 14px; animation:nxu_spin .9s linear infinite; display:none;}
@keyframes nxu_spin { to { transform:rotate(360deg); } }
.nxu_checkmark, .nxu_errormark {width:90px;height:90px; margin:0 auto 14px; display:none;}
.nxu_checkmark__circle, .nxu_errormark__circle {fill:none; stroke-width:3; stroke-linecap:round; stroke-linejoin:round; stroke-dasharray:166; stroke-dashoffset:166;}
.nxu_checkmark__check, .nxu_errormark__cross {fill:none; stroke-width:3; stroke-linecap:round; stroke-linejoin:round; stroke-dasharray:48; stroke-dashoffset:48;}
.nxu_checkmark__circle {stroke:#00e676;} .nxu_checkmark__check{stroke:#fff;}
.nxu_errormark__circle{stroke:#ff2e2e;} .nxu_errormark__cross{stroke:#fff;}
.nxu_animate-stroke .nxu_checkmark__circle, .nxu_animate-stroke .nxu_errormark__circle {animation:nxu_dash 0.6s cubic-bezier(.65,0,.45,1) forwards;}
.nxu_animate-stroke .nxu_checkmark__check, .nxu_animate-stroke .nxu_errormark__cross {animation:nxu_dash 0.3s cubic-bezier(.65,0,.45,1) 0.6s forwards;}
@keyframes nxu_dash { to {stroke-dashoffset:0;} }
.nxu_box h2 {color:#ff2e2e; margin:0 0 8px; font-size:20px;} .nxu_box p{color:#ddd; margin:0;}
</style>
</head>
<body>
</br>
</br>
<div class="nxu_container">
  <h1 class="nxu_header"><i class="fa-solid fa-user-plus"></i> THÊM / CẬP NHẬT NGƯỜI DÙNG</h1>
  <form method="POST" id="nxuUserForm" class="nxu_form">
    <input type="hidden" name="id" id="nxuId">
    <div class="nxu_row">
      <div class="nxu_group"><label class="nxu_label">Tên tài khoản</label><input class="nxu_input" name="TenTK" id="nxuTenTK" required></div>
      <div class="nxu_group"><label class="nxu_label">Mật khẩu</label><input class="nxu_input" name="MatKhau" id="nxuMatKhau" placeholder="Để trống nếu không đổi"></div>
      <div class="nxu_group">
        <label class="nxu_label">Quyền</label>
        <select class="nxu_input" name="Quyen" id="nxuQuyen" required>
          <option value=""></option>
          <option value="1">1 - Khách Hàng</option>
          <option value="2">2 - Quản Lý</option>
          <option value="3">3 - Admin</option>
          <option value="4">4 - Nhân Viên</option>
        </select>
      </div>
      <div class="nxu_group"><label class="nxu_label">Địa Chỉ</label><textarea class="nxu_input" name="DiaChi" id="nxuDiaChi"></textarea></div>
      <div class="nxu_group"><label class="nxu_label">Số điện thoại</label><input class="nxu_input" name="phone" id="nxuPhone"></div>
      <div class="nxu_group"><label class="nxu_label">Email</label><input class="nxu_input" name="email" id="nxuEmail" type="email"></div>
    </div>
    <button class="nxu_btn-save" type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu / Cập nhật</button>
  </form>
</div>

<!-- OVERLAY -->
<div class="nxu_overlay" id="nxuOverlay">
  <div class="nxu_box" id="nxuBox">
    <div class="nxu_spinner" id="nxuSpinner"></div>
    <svg class="nxu_checkmark" id="nxuCheck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="nxu_checkmark__circle" cx="26" cy="26" r="25"/>
      <path class="nxu_checkmark__check" d="M14 27l7 7 17-17"/>
    </svg>
    <svg class="nxu_errormark" id="nxuError" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="nxu_errormark__circle" cx="26" cy="26" r="25"/>
      <path class="nxu_errormark__cross" d="M16 16 36 36 M36 16 16 36"/>
    </svg>
    <h2 id="nxuMsgTitle">Đang xử lý...</h2>
    <p id="nxuMsgText">Vui lòng chờ trong giây lát</p>
  </div>
</div>

<script>
const nxuOverlay = document.getElementById('nxuOverlay');
const nxuSpinner = document.getElementById('nxuSpinner');
const nxuCheck = document.getElementById('nxuCheck');
const nxuError = document.getElementById('nxuError');
const nxuTitle = document.getElementById('nxuMsgTitle');
const nxuText = document.getElementById('nxuMsgText');

function nxuShowLoadingOverlay() {
    nxuOverlay.style.display = 'flex';
    nxuSpinner.style.display = 'block';
    nxuCheck.style.display = 'none';
    nxuError.style.display = 'none';
    nxuTitle.textContent = 'Đang xử lý...';
    nxuText.textContent = 'Vui lòng chờ trong giây lát';
}

function nxuShowOverlayResult(success, message) {
    nxuSpinner.style.display = 'none';
    if(success) {
        nxuCheck.style.display = 'block';
        nxuError.style.display = 'none';
        nxuCheck.classList.remove('nxu_animate-stroke');
        void nxuCheck.offsetWidth;
        nxuCheck.classList.add('nxu_animate-stroke');
        nxuTitle.textContent = 'Thành công';
    } else {
        nxuCheck.style.display = 'none';
        nxuError.style.display = 'block';
        nxuError.classList.remove('nxu_animate-stroke');
        void nxuError.offsetWidth;
        nxuError.classList.add('nxu_animate-stroke');
        nxuTitle.textContent = 'Thất bại';
    }
    nxuText.textContent = message;
    setTimeout(() => nxuOverlay.style.display = 'none', 1500);
}

// Nếu có thông báo PHP
<?php if($message): ?>
document.addEventListener('DOMContentLoaded', ()=>{
    nxuShowLoadingOverlay();
    setTimeout(()=> nxuShowOverlayResult(<?= $is_error ? 'false':'true' ?>, "<?= addslashes($message) ?>"), 800);
});
<?php endif; ?>
</script>

</body>
</html>
