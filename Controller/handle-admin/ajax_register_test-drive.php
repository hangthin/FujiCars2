<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("Controller/config/config.php");
mysqli_set_charset($conn,"utf8");

header('Content-Type: application/json; charset=utf-8');

if(isset($_POST['update']) && isset($_POST['id'])){
    $id = intval($_POST['id']);
    $hoten = trim($_POST['hoten']);
    $sdt = trim($_POST['sdt']);
    $tenxe = trim($_POST['tenxe']);
    $ghichu = trim($_POST['ghichu']);
    $ngay = trim($_POST['ngay']);
    $gio = trim($_POST['gio']);
    $diachi = trim($_POST['diachi']);

    if($hoten && $sdt && $tenxe && $ngay && $gio && $diachi){
        // Thêm xe nếu chưa có
        $check_car = mysqli_prepare($conn,"SELECT ID FROM sanpham WHERE TenSP=?");
        mysqli_stmt_bind_param($check_car, "s", $tenxe);
        mysqli_stmt_execute($check_car);
        mysqli_stmt_store_result($check_car);
        if(mysqli_stmt_num_rows($check_car)==0){
            $insert_car = mysqli_prepare($conn,"INSERT INTO sanpham(TenSP) VALUES(?)");
            mysqli_stmt_bind_param($insert_car,"s",$tenxe);
            mysqli_stmt_execute($insert_car);
            mysqli_stmt_close($insert_car);
        }
        mysqli_stmt_close($check_car);

        $stmt = mysqli_prepare($conn,"UPDATE dangkilaithe SET hoten=?, sdt=?, tenxe=?, ghichu=?, ngay=?, gio=?, diachi=? WHERE id=?");
        mysqli_stmt_bind_param($stmt,"sssssssi",$hoten,$sdt,$tenxe,$ghichu,$ngay,$gio,$diachi,$id);
        if(mysqli_stmt_execute($stmt)){
            echo json_encode(["success"=>true]);
        }else{
            echo json_encode(["success"=>false,"msg"=>"Lỗi server: ".mysqli_stmt_error($stmt)]);
        }
        mysqli_stmt_close($stmt);
    }else{
        echo json_encode(["success"=>false,"msg"=>"Vui lòng nhập đầy đủ thông tin!"]);
    }
    exit;
}

echo json_encode(["success"=>false,"msg"=>"Yêu cầu không hợp lệ"]);
