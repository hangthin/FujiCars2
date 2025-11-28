<?php
session_start();
include "../../Controller/config/config.php";

// Kiểm tra quyền admin
if (!isset($_SESSION['Quyen']) || $_SESSION['Quyen'] != '3') {
    die("Bạn không có quyền truy cập trang này.");
}

// Trạng thái vận chuyển
$statuses = [
    'Đang lấy hàng',
    'Đã lấy hàng',
    'Đang vận chuyển',
    'Đã đến kho',
    'Đang giao hàng',
    'Đã giao hàng'
];

// Xử lý thêm / cập nhật vận chuyển
$message = '';
$is_error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_vanchuyen'])) {
    $ID_HoaDon = intval($_POST['ID_HoaDon']);
    $TenTK     = $_POST['TenTK'];
    $Phone     = $_POST['Phone'];
    $Address   = $_POST['Address'];
    $TrangThai = $_POST['TrangThai'];

    $check = $conn->query("SELECT ID FROM vanchuyen WHERE ID_HoaDon = $ID_HoaDon")->fetch_assoc();

    if ($check) {
        $stmt = $conn->prepare("UPDATE vanchuyen SET TenTK=?, Phone=?, Address=?, TrangThai=? WHERE ID_HoaDon=?");
        $stmt->bind_param("ssssi", $TenTK, $Phone, $Address, $TrangThai, $ID_HoaDon);
        $msg_action = "cập nhật";
    } else {
        $stmt = $conn->prepare("INSERT INTO vanchuyen (TenTK, ID_HoaDon, Phone, Address, TrangThai) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $TenTK, $ID_HoaDon, $Phone, $Address, $TrangThai);
        $msg_action = "thêm";
    }

    if ($stmt->execute()) {
        $message = ucfirst($msg_action) . " vận chuyển thành công!";
    } else {
        $message = "Lỗi: " . $stmt->error;
        $is_error = true;
    }
    $stmt->close();
}

// Lấy danh sách hóa đơn đã duyệt Status = 1
$sql_bills = "SELECT h.ID, h.Name, h.Phone, h.Address, h.TotalPrice, h.DateCreate,
                     v.TrangThai AS VanChuyenStatus
              FROM hoadon h
              LEFT JOIN vanchuyen v ON v.ID_HoaDon = h.ID
              WHERE h.Status = 1
              ORDER BY h.DateCreate DESC";
$result_bills = $conn->query($sql_bills);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý vận chuyển</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="View/css/styleCss.css">
</head>
<body class="unq_body_23">
<div class="unq_container_23">
 <h1 class="nxu_header"><i class="fa fa-truck"></i> CẬP NHẬT VẬN CHUYỂN</h1>
<!-- Form cập nhật vận chuyển -->
<?php while($bill = $result_bills->fetch_assoc()): ?>
<form method="POST" class="unq_form_inline_23">
    <input type="hidden" name="ID_HoaDon" value="<?= $bill['ID'] ?>">
    <label>Tên khách:</label>
    <input type="text" name="TenTK" value="<?= htmlspecialchars($bill['Name']) ?>" required>
    <label>Phone:</label>
    <input type="text" name="Phone" value="<?= htmlspecialchars($bill['Phone']) ?>" required>
    <label>Địa chỉ:</label>
    <input type="text" name="Address" value="<?= htmlspecialchars($bill['Address']) ?>" required>
    <label>Trạng thái:</label>
    <select name="TrangThai" required>
        <option value="" disabled <?= empty($bill['VanChuyenStatus']) ? 'selected':'' ?>>Chọn trạng thái</option>
        <?php foreach($statuses as $st): ?>
            <option value="<?= $st ?>" <?= $bill['VanChuyenStatus']==$st ? 'selected':'' ?>><?= $st ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="save_vanchuyen"><i class="fa fa-truck"></i> Cập nhật</button>
</form>
<?php endwhile; ?>

<!-- Bảng danh sách vận chuyển -->
<h2 class="unq_h2_23">Danh sách vận chuyển hiện có</h2>
<table class="unq_table_23">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tài khoản</th>
            <th>ID Hóa đơn</th>
            <th>Phone</th>
            <th>Địa chỉ</th>
            <th>Trạng thái</th>
            <th>Ngày cập nhật</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql_vanchuyen = "SELECT * FROM vanchuyen ORDER BY NgayCapNhat DESC";
    $result_vanchuyen = $conn->query($sql_vanchuyen);
    while($v = $result_vanchuyen->fetch_assoc()):
    ?>
        <tr>
            <td><?= $v['ID'] ?></td>
            <td><?= htmlspecialchars($v['TenTK']) ?></td>
            <td><?= htmlspecialchars($v['ID_HoaDon']) ?></td>
            <td><?= htmlspecialchars($v['Phone']) ?></td>
            <td><?= htmlspecialchars($v['Address']) ?></td>
            <td><?= $v['TrangThai'] ?></td>
            <td><?= $v['NgayCapNhat'] ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>

<!-- OVERLAY -->
<div class="unq_overlay_23" id="unqOverlay_23">
  <div class="unq_box_23" id="unqBox_23">
    <div class="unq_spinner_23" id="unqSpinner_23"></div>
    <svg class="unq_checkmark_23" id="unqCheck_23" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="unq_checkmark_circle_23" cx="26" cy="26" r="25"/>
      <path class="unq_checkmark_check_23" d="M14 27l7 7 17-17"/>
    </svg>
    <svg class="unq_errormark_23" id="unqError_23" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="unq_errormark_circle_23" cx="26" cy="26" r="25"/>
      <path class="unq_errormark_cross_23" d="M16 16 36 36 M36 16 16 36"/>
    </svg>
    <h2 id="unqMsgTitle_23">Đang xử lý...</h2>
    <p id="unqMsgText_23">Vui lòng chờ trong giây lát</p>
  </div>
</div>

<script>
<?php if($message): ?>
const VANCHUYEN_MESSAGE = "<?= addslashes($message) ?>";
const VANCHUYEN_ISERROR = <?= $is_error ? 'true' : 'false' ?>;
<?php endif; ?>
</script>
<script src="js/transport.js"></script>
</body>
</html>
