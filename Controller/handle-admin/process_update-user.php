<?php
include __DIR__ . 'Controller/config/config.php';

// --- Biến thông báo ---
$message = "";
$is_error = false;
$deleted_id = 0;

// --- Xử lý POST (thêm/sửa/xóa) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // XÓA NGƯỜI DÙNG
    if (isset($_POST['delete_id'])) {
        $deleted_id = intval($_POST['delete_id']);
        $sql_delete = "DELETE FROM nguoidung WHERE ID=$deleted_id";
        if (mysqli_query($conn, $sql_delete)) {
            $message = "Đã xóa tài khoản ID $deleted_id thành công!";
        } else {
            $message = "Xóa thất bại: " . mysqli_error($conn);
            $is_error = true;
        }
    }

    // THÊM / SỬA
    else {
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
}

// LẤY DANH SÁCH NGƯỜI DÙNG
$search = $_GET['search'] ?? '';
$query = "SELECT * FROM nguoidung WHERE TenTK LIKE '%".mysqli_real_escape_string($conn,$search)."%' ORDER BY ID DESC";
$result = mysqli_query($conn, $query);
?>
