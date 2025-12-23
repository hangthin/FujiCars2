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

    // Lấy trạng thái hiện tại (nếu có)
    $currentRow = $conn->query("SELECT TrangThai FROM vanchuyen WHERE ID_HoaDon = $ID_HoaDon")->fetch_assoc();
    $currentStatus = $currentRow['TrangThai'] ?? null;

    // ================================
    //   KIỂM TRA RÀNG BUỘC LOGIC
    // ================================
    if ($currentStatus !== null) {
        $oldIndex = array_search($currentStatus, $statuses);
        $newIndex = array_search($TrangThai, $statuses);

        // Không cho phép lùi
        if ($newIndex < $oldIndex) {
            $message = "Không thể quay lại trạng thái trước đó!";
            $is_error = true;
        }
        // Không cho phép nhảy xa
        elseif ($newIndex > $oldIndex + 1) {
            $message = "Không thể bỏ qua bước! Vui lòng chọn trạng thái kế tiếp.";
            $is_error = true;
        }
    }

    if (!$is_error) {
        // INSERT hoặc UPDATE Vận Chuyển
        $exists = $conn->query("SELECT ID FROM vanchuyen WHERE ID_HoaDon = $ID_HoaDon")->num_rows > 0;

        if ($exists) {
            $stmt = $conn->prepare("
                UPDATE vanchuyen 
                SET TenTK=?, Phone=?, Address=?, TrangThai=?, NgayCapNhat=NOW()
                WHERE ID_HoaDon=?
            ");
            $stmt->bind_param("ssssi", $TenTK, $Phone, $Address, $TrangThai, $ID_HoaDon);
            $msg_action = "Cập nhật";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO vanchuyen (TenTK, ID_HoaDon, Phone, Address, TrangThai, NgayCapNhat)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $stmt->bind_param("sisss", $TenTK, $ID_HoaDon, $Phone, $Address, $TrangThai);
            $msg_action = "Thêm";
        }

        if ($stmt->execute()) {
            $message = "$msg_action vận chuyển thành công!";
        } else {
            $message = "Lỗi SQL: " . $stmt->error;
            $is_error = true;
        }
        $stmt->close();
    }
}

// ================================
//  Lọc danh sách (nếu submit lọc)
// ================================
$filter_status = $_POST['filter_status'] ?? '';
$whereClause = "h.Status = 1";
if ($filter_status && in_array($filter_status, $statuses)) {
    $whereClause .= " AND v.TrangThai = '$filter_status'";
}


// Lấy danh sách hóa đơn đã duyệt Status = 1 và lọc theo trạng thái nếu có
$sql_bills = "SELECT h.ID, h.Name, h.Phone, h.Address, h.TotalPrice, h.DateCreate,
                     v.TrangThai AS VanChuyenStatus
              FROM hoadon h
              LEFT JOIN vanchuyen v ON v.ID_HoaDon = h.ID
              WHERE $whereClause
              ORDER BY h.ID DESC"; // ID cao nhất = hóa đơn mới nhất
$result_bills = $conn->query($sql_bills);

// ================================
//  Lấy toàn bộ danh sách vận chuyển
// ================================
$sql_vanchuyen = "SELECT * FROM vanchuyen ORDER BY NgayCapNhat DESC";
$result_vanchuyen = $conn->query($sql_vanchuyen);

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

<!-- Form lọc trạng thái -->
<form method="POST" class="unq_form_inline_23">
    <label>Lọc trạng thái:</label>
    <select name="filter_status">
        <option value="">Tất cả</option>
        <?php foreach($statuses as $st): ?>
            <option value="<?= $st ?>" <?= $filter_status==$st ? 'selected':'' ?>><?= $st ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn"><i class="fa fa-filter"></i> Lọc</button>
    <button type="button" class="btn" onclick="window.print();"><i class="fa fa-print"></i> In</button>
</form>

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
