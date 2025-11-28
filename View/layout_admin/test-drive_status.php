<?php
include "Controller/config/config.php";
ini_set('display_errors',1);
error_reporting(E_ALL);

$statusText = [
    "Chờ xác nhận" => "Chờ xác nhận",
    "Đang láy thử" => "Đang lái thử",
    "Hoàn tất"     => "Hoàn tất",
    "Hủy"          => "Hủy"
];

$msg = "";
if(isset($_POST['updateStatusForm'])){
    $id = intval($_POST['id']);
    $newStatus = $_POST['status'];
    
    if(in_array($newStatus, array_keys($statusText))){
        $check = $conn->query("SELECT 1 FROM trangthai_laythu WHERE DangKyID=$id LIMIT 1");
        if($check->num_rows>0){
            $conn->query("UPDATE trangthai_laythu SET TrangThai='$newStatus', NgayCapNhat=CURRENT_TIMESTAMP WHERE DangKyID=$id");
        } else {
            $conn->query("INSERT INTO trangthai_laythu (DangKyID, TrangThai) VALUES ($id, '$newStatus')");
        }
        $msg = "Cập nhật trạng thái thành công!";
    } else {
        $msg = "Trạng thái không hợp lệ!";
    }
}

$sqlOrders = "SELECT * FROM dangkilaithe ORDER BY ngay DESC, gio ASC";
$rsOrders = $conn->query($sqlOrders);

$orders = [];

while($row = $rsOrders->fetch_assoc()){
    $sqlStatus = "SELECT TrangThai FROM trangthai_laythu WHERE DangKyID = ".$row['id'];
    $rsStatus = $conn->query($sqlStatus);
    if($rsStatus->num_rows > 0){
        $status = $rsStatus->fetch_assoc()['TrangThai'];
    } else {
        $conn->query("INSERT INTO trangthai_laythu (DangKyID, TrangThai) VALUES (".$row['id'].", 'Chờ xác nhận')");
        $status = 'Chờ xác nhận';
    }

    $sqlImg = "SELECT HinhAnh FROM sanpham WHERE TenSP = '". $conn->real_escape_string($row['tenxe']) ."' LIMIT 1";
    $rsImg = $conn->query($sqlImg);
    $img = ($rsImg && $rsImg->num_rows>0) ? $rsImg->fetch_assoc()['HinhAnh'] : 'default.png';

    $orders[] = [
        "id" => (int)$row["id"],
        "name" => $row["hoten"],
        "car" => $row["tenxe"],
        "date" => $row["ngay"],
        "time" => $row["gio"],
        "address" => $row["diachi"],
        "img" => "/../View/img/SP/" . $img,
        "status" => $status,
        "statusText" => $statusText[$status] ?? "Không rõ"
    ];
}
$jsonOrders = json_encode($orders, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<link rel="stylesheet" href="View/css/styleCss.css">
<meta charset="UTF-8">
<title>Quản lý lịch lái thử xe</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="gxA1body">
<div class="gxA1wrap">
<h2 style="text-align:center;margin:25px 0 10px;font-size:30px;font-weight:700;color:red;">CẬP NHẬT LỊCH LÁI THỬ XE</h2>
<p style="text-align:center;margin-top:0;margin-bottom:25px;font-size:15px;color:#fff;">Quản lý danh sách khách hàng đăng ký lái thử và theo dõi lịch theo khung giờ.</p>

<?php if($msg): ?>
    <p class="gxA1msg"><?= $msg ?></p>
<?php endif; ?>

<div class="gxA1layout">
    <div class="gxA1left">
        <h3 style="font-size:18px;font-weight:600;color:#444;margin-bottom:10px;">Danh Sách Đơn Đăng Ký Lái Thử</h3>
        <p style="font-size:14px;color:#777;margin-top:-8px;margin-bottom:15px;">Nhấp vào đơn để xem chi tiết.</p>
        <div id="gxA1orderList"></div>
    </div>
    <div class="gxA1right">
        <h3 style="font-size:18px;font-weight:600;color:#444;margin-bottom:10px;">Lịch Lái Thử Theo Khung Giờ</h3>
        <p style="font-size:14px;color:#777;margin-top:-8px;margin-bottom:10px;">Giờ hoạt động: 07:00 – 12:00 | 13:00 – 17:00 </p>
        <div class="gxA1filterPanel">
            <select id="gxA1filterDateType">
                <option value="all">Tất cả ngày</option>
                <option value="day">Ngày</option>
                <option value="week">Tuần</option>
                <option value="month">Tháng</option>
                <option value="year">Năm</option>
            </select>
            <input type="date" id="gxA1filterDate">
            <input type="text" id="gxA1filterCar" placeholder="Tên xe">
            <button class="gxA1btn" onclick="applyFilters()">Lọc</button>
            <button class="gxA1btn" onclick="resetFilters()">Reset</button>
        </div>
        <div class="gxA1statusLegend">
            <div><div class="gxA1statusColor gxA1pendingColor"></div> Chờ xác nhận</div>
            <div><div class="gxA1statusColor gxA1doingColor"></div> Đang lái thử</div>
            <div><div class="gxA1statusColor gxA1doneColor"></div> Hoàn tất</div>
            <div><div class="gxA1statusColor gxA1cancelColor"></div> Hủy</div>
        </div>
        <br>
        <div>
            <div class="gxA1timelineHours" id="gxA1hoursRow1"></div>
            <div class="gxA1timelineRow" id="gxA1rowRow1"></div>
            <div class="gxA1timelineHours" id="gxA1hoursRow2"></div>
            <div class="gxA1timelineRow" id="gxA1rowRow2"></div>
        </div>
    </div>
</div>
</div>

<div class="gxA1modalBg" id="gxA1modal">
    <div class="gxA1modalBox">
        <form method="POST">
            <input type="hidden" name="id" id="gxA1updateStatusID">
            <button type="button" class="gxA1btn gxA1btnClose" onclick="closeModal()">Đóng</button>
            <h3>Chi tiết đơn lái thử</h3>
            <div id="gxA1modalContent"></div>
            <div style="margin-top:10px;">
                <label>Trạng thái:</label>
                <select name="status" id="gxA1updateStatusSelect">
                    <option value="Chờ xác nhận">Chờ xác nhận</option>
                    <option value="Đang láy thử">Đang láy thử</option>
                    <option value="Hoàn tất">Hoàn tất</option>
                    <option value="Hủy">Hủy</option>
                </select>
                <button type="submit" name="updateStatusForm" class="gxA1btn">Cập nhật</button>
            </div>
        </form>
    </div>
</div>
<script>
    window.jsonOrders = <?= $jsonOrders ?>;
</script>
<script src="js/test-drive_status.js"></script>
</body>
</html>
