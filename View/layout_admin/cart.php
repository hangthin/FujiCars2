<?php
session_start();
include "Controller/config/config.php";

$message = '';
$is_error = false;

/* =======================
   XỬ LÝ XÓA GIỎ HÀNG TRỰC TIẾP QUA POST
======================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $MaGioHang = $_POST['delete_id'];

    $sqlCheck = "SELECT MaGioHang FROM giohang WHERE MaGioHang = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param(is_numeric($MaGioHang) ? "i" : "s", $MaGioHang);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if($stmtCheck->num_rows > 0){
        $sqlDelete = "DELETE FROM giohang WHERE MaGioHang = ?";
        $stmtDel = $conn->prepare($sqlDelete);
        $stmtDel->bind_param(is_numeric($MaGioHang) ? "i" : "s", $MaGioHang);
        if($stmtDel->execute()){
            $message = "Xóa giỏ hàng thành công!";
            $is_error = false;
        } else {
            $message = "Xóa thất bại: " . $stmtDel->error;
            $is_error = true;
        }
    } else {
        $message = "Mã giỏ hàng không tồn tại!";
        $is_error = true;
    }
}

/* =======================
   LẤY THỐNG KÊ THEO NGƯỜI DÙNG
======================= */
$sql = "
    SELECT 
        nd.ID AS MaNguoiDung,
        nd.TenTK,
        nd.email,
        nd.phone,
        gh.MaGioHang,
        sp.TenSP,
        sp.Gia,
        sp.HinhAnh,
        gh.SoLuong,
        gh.NgayCapNhat,
        (sp.Gia * gh.SoLuong) AS ThanhTien
    FROM nguoidung nd
    LEFT JOIN giohang gh ON nd.ID = gh.MaKH
    LEFT JOIN sanpham sp ON gh.MaSP = sp.ID
    ORDER BY nd.ID, gh.NgayCapNhat DESC
";

$result = $conn->query($sql);
$allData = $result->fetch_all(MYSQLI_ASSOC);

// Gom dữ liệu theo user
$users = [];
foreach ($allData as $row) {
    $uid = $row['MaNguoiDung'];
    if (!isset($users[$uid])) {
        $users[$uid] = [
            'MaNguoiDung' => $uid,
            'TenTK' => $row['TenTK'],
            'email' => $row['email'],
            'products' => [],
        ];
    }
    if ($row['MaGioHang']) {
        $users[$uid]['products'][] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thống kê giỏ hàng người dùng</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="View/css/styleCss.css">
<script>
function toggleDetail(id) {
    const el = document.getElementById('detail-'+id);
    el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'table-row' : 'none';
}

/* ==== Overlay JS ==== */
function nxuShowLoadingOverlay() {
    const overlay = document.getElementById('nxuOverlay');
    const spinner = document.getElementById('nxuSpinner');
    const check = document.getElementById('nxuCheck');
    const error = document.getElementById('nxuError');
    const title = document.getElementById('nxuMsgTitle');
    const text = document.getElementById('nxuMsgText');

    overlay.style.display = 'flex';
    spinner.style.display = 'block';
    check.style.display = 'none';
    error.style.display = 'none';
    title.textContent = 'Đang xử lý...';
    text.textContent = 'Vui lòng chờ trong giây lát';
}

function nxuShowOverlayResult(success, message) {
    const overlay = document.getElementById('nxuOverlay');
    const spinner = document.getElementById('nxuSpinner');
    const check = document.getElementById('nxuCheck');
    const error = document.getElementById('nxuError');
    const title = document.getElementById('nxuMsgTitle');
    const text = document.getElementById('nxuMsgText');

    spinner.style.display = 'none';
    if(success){
        check.style.display = 'block';
        error.style.display = 'none';
        check.classList.remove('nxu_animate-stroke'); void check.offsetWidth; check.classList.add('nxu_animate-stroke');
        title.textContent = 'Thành công';
    } else {
        check.style.display = 'none';
        error.style.display = 'block';
        error.classList.remove('nxu_animate-stroke'); void error.offsetWidth; error.classList.add('nxu_animate-stroke');
        title.textContent = 'Thất bại';
    }
    text.textContent = message;
    setTimeout(()=>overlay.style.display='none',1500);
}

/* ==== Nếu có message từ PHP, hiển thị overlay ==== */
<?php if($message): ?>
document.addEventListener('DOMContentLoaded', ()=>{
    nxuShowLoadingOverlay();
    setTimeout(()=>nxuShowOverlayResult(<?= $is_error ? 'false' : 'true' ?>, "<?= addslashes($message) ?>"), 500);
});
<?php endif; ?>
</script>
</head>
<body class="kbx-body">
<div class="kbx-container">
<h1 class="kbx-title">THỐNG KÊ NGƯỜI DÙNG & GIỎ HÀNG</h1>

<button onclick="window.print()" class="kbx-btn-print">🖨️ In danh sách</button>

<table class="kbx-table">
<thead>
<tr>
<th>ID User</th>
<th>Tên tài khoản</th>
<th>Email</th>
<th>Số sản phẩm</th>
<th>Tổng số lượng</th>
<th>Tổng tiền</th>
<th>Chi tiết</th>
</tr>
</thead>
<tbody>
<?php foreach($users as $user): 
    $products = $user['products'];
    if(count($products) == 0) continue;

    $totalQty = array_sum(array_column($products, 'SoLuong'));
    $totalMoney = array_sum(array_column($products, 'ThanhTien'));
?>
<tr>
<td><?= $user['MaNguoiDung'] ?></td>
<td><?= htmlspecialchars($user['TenTK']) ?></td>
<td><?= htmlspecialchars($user['email']) ?></td>
<td><?= count($products) ?></td>
<td><?= $totalQty ?></td>
<td><?= number_format($totalMoney) ?> VNĐ</td>
<td><span class="kbx-eye" onclick="toggleDetail(<?= $user['MaNguoiDung'] ?>)">👁️</span></td>
</tr>
<tr id="detail-<?= $user['MaNguoiDung'] ?>" class="kbx-detail">
<td colspan="7">
<table>
<thead>
<tr>
<th>Sản phẩm</th>
<th>Hình ảnh</th>
<th>Giá</th>
<th>Số lượng</th>
<th>Thành tiền</th>
<th>Ngày cập nhật</th>
<th>Xóa</th>
</tr>
</thead>
<tbody>
<?php foreach($products as $p): ?>
<tr>
<td><?= htmlspecialchars($p['TenSP']) ?></td>
<td><img src="View/img/SP/<?= htmlspecialchars($p['HinhAnh']) ?>" width="50"></td>
<td><?= number_format($p['Gia']) ?> VNĐ</td>
<td><?= $p['SoLuong'] ?></td>
<td><?= number_format($p['ThanhTien']) ?> VNĐ</td>
<td><?= date("d/m/Y H:i", strtotime($p['NgayCapNhat'])) ?></td>
<td>
<form method="post" style="margin:0;" onsubmit="return confirm('Bạn có chắc muốn xóa?');">
<input type="hidden" name="delete_id" value="<?= $p['MaGioHang'] ?>">
<button type="submit" class="kbx-btn-delete">❌ Xóa</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<!-- ==== Overlay HTML ==== -->
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
</body>
</html>
