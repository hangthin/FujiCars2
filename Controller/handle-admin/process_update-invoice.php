<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
include("../../config/config.php");

$message = "";
$is_error = false;
$newInsertedID = 0; // lưu ID để highlight dòng mới

// ===================== THÊM / SỬA HÓA ĐƠN =====================
if (isset($_POST['them'])) {
    $ID = intval($_POST['ID'] ?? 0);
    $Name = $conn->real_escape_string($_POST['Name']);
    $Phone = $conn->real_escape_string($_POST['Phone']);
    $Address = $conn->real_escape_string($_POST['Address']);
    $DateReceive = $_POST['DateReceive'];
    $TimeReceive = $_POST['TimeReceive'];
    $Method = $_POST['Method'];
    $TotalPrice = floatval($_POST['TotalPrice']);

    if ($ID > 0) {
        // UPDATE
        $sql = "UPDATE hoadon SET 
                Name='$Name',
                Phone='$Phone',
                Address='$Address',
                DateReceive='$DateReceive',
                TimeReceive='$TimeReceive',
                Method='$Method',
                TotalPrice='$TotalPrice'
                WHERE ID='$ID'";
        if ($conn->query($sql)) {
            $message = "Cập nhật hóa đơn thành công!";
        } else {
            $message = "Lỗi cập nhật hóa đơn: " . $conn->error;
            $is_error = true;
        }
    } else {
        // INSERT
        $sql = "INSERT INTO hoadon (Name, Phone, Address, DateReceive, TimeReceive, Method, TotalPrice, Status, DateCreate)
                VALUES ('$Name', '$Phone', '$Address', '$DateReceive', '$TimeReceive', '$Method', '$TotalPrice', 0, NOW())";

        if ($conn->query($sql)) {
            $message = "Thêm hóa đơn thành công!";
            $newInsertedID = $conn->insert_id;
        } else {
            $message = "Lỗi thêm hóa đơn: " . $conn->error;
            $is_error = true;
        }
    }
}

// ===================== XÁC NHẬN 1 HÓA ĐƠN =====================
if (isset($_POST['sua'])) {
    $ID = intval($_POST['ID']);
    $sql = "UPDATE hoadon SET Status = 1 WHERE ID=$ID";
    if ($conn->query($sql)) {
        $message = "Xác nhận hóa đơn thành công!";
    } else {
        $message = "Lỗi khi xác nhận hóa đơn: " . $conn->error;
        $is_error = true;
    }
}

// ===================== XÁC NHẬN NHIỀU HÓA ĐƠN =====================
if (isset($_POST['sua_all'])) {
    $ids = $_POST['IDs'] ?? [];

    if (!empty($ids)) {
        $ids = array_map('intval', $ids);
        $sql = "UPDATE hoadon SET Status = 1 WHERE ID IN (" . implode(",", $ids) . ")";
        if ($conn->query($sql)) {
            $message = "Cập nhật trạng thái tất cả hóa đơn thành công!";
        } else {
            $message = "Lỗi cập nhật: " . $conn->error;
            $is_error = true;
        }
    }
}

// ===================== XÓA 1 HÓA ĐƠN =====================
if (isset($_POST['xoa'])) {
    $ID = intval($_POST['ID']);
    $sql = "DELETE FROM hoadon WHERE ID=$ID";

    if ($conn->query($sql)) {
        $message = "Xóa hóa đơn thành công!";
    } else {
        $message = "Lỗi khi xóa: " . $conn->error;
        $is_error = true;
    }
}

// ===================== XÓA NHIỀU HÓA ĐƠN =====================
if (isset($_POST['xoa_all'])) {
    $ids = $_POST['IDs'] ?? [];

    if (!empty($ids)) {
        $ids = array_map('intval', $ids);
        $sql = "DELETE FROM hoadon WHERE ID IN (" . implode(",", $ids) . ")";
        if ($conn->query($sql)) {
            $message = "Xóa tất cả hóa đơn thành công!";
        } else {
            $message = "Lỗi khi xóa: " . $conn->error;
            $is_error = true;
        }
    }
}

// ===================== LẤY DANH SÁCH HÓA ĐƠN =====================
$sql = "SELECT * FROM hoadon ORDER BY ID DESC";
$result = $conn->query($sql);

if (!$result) die("❌ Lỗi truy vấn: " . $conn->error);

// Trả dữ liệu cho trang chính
return [
    "result" => $result,
    "message" => $message,
    "is_error" => $is_error,
    "newInsertedID" => $newInsertedID
];
?>
