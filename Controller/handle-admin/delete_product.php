<?php
include '../../Controller/config/config.php';

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    if(mysqli_query($conn,"DELETE FROM sanpham WHERE ID=$id")) echo 'success';
    else echo mysqli_error($conn);
} else echo 'ID không hợp lệ';
?>
