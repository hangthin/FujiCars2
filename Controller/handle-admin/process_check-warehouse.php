<?php
include "../config/config.php";

if(isset($_POST['ID'])){
    $ID = intval($_POST['ID']);
    
    $sql = "SELECT SoLuong_CoSan FROM kho_xe_laythu WHERE MaXe = $ID LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if($row = mysqli_fetch_assoc($result)){
        echo json_encode([
            "SoLuong_CoSan" => intval($row['SoLuong_CoSan'])
        ]);
    } else {
        echo json_encode([
            "SoLuong_CoSan" => 0
        ]);
    }
} else {
    echo json_encode([
        "SoLuong_CoSan" => 0
    ]);
}
?>
