<?php
include("../../Controller/config/config.php");

if(isset($_POST['TenSP'])){
    $TenSP = $_POST['TenSP'];
    $MoTa = $_POST['MoTa'];
    $NgayCapNhat = $_POST['NgayCapNhat'];
    $HinhAnh = $_POST['HinhAnh'];
    $LoaiSP = $_POST['LoaiSP'];
    $Gia = $_POST['Gia'];
    $SoLuong = $_POST['SoLuong'];
    $NhienLieu = $_POST['NhienLieu'];
    $XuatXu = $_POST['XuatXu'];

    $sql = "INSERT INTO sanpham (TenSP, MoTa, NgayCapNhat, HinhAnh, LoaiSP, Gia, SoLuong, NhienLieu, XuatXu)
            VALUES ('$TenSP','$MoTa','$NgayCapNhat','$HinhAnh','$LoaiSP','$Gia','$SoLuong','$NhienLieu','$XuatXu')";
    if(mysqli_query($conn, $sql)){
        $id = mysqli_insert_id($conn);
        echo json_encode(['status'=>'success','ID'=>$id]);
    } else {
        echo json_encode(['status'=>'error','msg'=>mysqli_error($conn)]);
    }
}
?>
