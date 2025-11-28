<?php
include 'Controller/config/config.php';
session_start();

// 🔹 Lấy doanh thu theo sản phẩm
$sql = "
    SELECT 
        sp.ID,
        sp.TenSP,
        sp.HinhAnh,
        IFNULL(SUM(hd.TotalPrice), 0) AS TongDoanhThu
    FROM sanpham sp
    LEFT JOIN hoadon hd ON sp.ID = hd.ID
    GROUP BY sp.ID, sp.TenSP, sp.HinhAnh
    ORDER BY TongDoanhThu DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Báo Cáo Doanh Thu - FUJICARS</title>
<style>
/* ====== BODY ====== */
body {
    font-family: 'Roboto', sans-serif;
    background: #f5f6fa;
    color: #333;
    margin: 0;
    padding: 30px;
}

/* ====== TITLE ====== */
h1 {
    text-align: center;
    color: #e53935;
    margin-bottom: 50px;
    letter-spacing: 2px;
    font-weight: 700;
}

/* ====== CONTAINER ====== */
.baocao-container {
    max-width: 1100px;
    margin: 0 auto;
    background: #fff;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}

/* ====== ITEM ====== */
.baocao-item {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    gap: 25px;
    transition: transform 0.3s, box-shadow 0.3s;
}
.baocao-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

/* ====== IMAGE ====== */
.baocao-item img {
    width: 250px;
    height: 120px;
    border-radius: 10px;
    object-fit: cover;
    background: #fff;
    flex-shrink: 0;
    border: 1px solid #ddd;
    transition: transform 0.3s;
}
.baocao-item img:hover {
    transform: scale(1.05);
}

/* ====== INFO ====== */
.baocao-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.baocao-info h2 {
    font-size: 18px;
    margin: 0;
    font-weight: 600;
    color: #222;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ====== REVENUE DISPLAY ====== */
.bar-value {
    font-size: 15px;
    font-weight: 700;
    color: #000;
}

/* ====== BAR WRAPPER ====== */
.bar-wrapper {
    background: #e0e0e0;
    border-radius: 12px;
    position: relative;
    height: 28px;
    width: 100%;
    overflow: hidden;
}
.bar-wrapper:hover .bar-tooltip {
    opacity: 1;
    visibility: visible;
}

/* ====== BAR ====== */
.bar {
    height: 100%;
    background: linear-gradient(90deg, #e53935, #ff6f61);
    border-radius: 12px 0 0 12px;
    transition: width 0.6s ease;
    position: relative;
}

/* ====== TOOLTIP ====== */
.bar-tooltip {
    position: absolute;
    right: 10px;
    top: -28px;
    background: rgba(0,0,0,0.8);
    color: #fff;
    padding: 4px 8px;
    font-size: 13px;
    border-radius: 6px;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
    white-space: nowrap;
}

/* ====== FOOTER ====== */
.baocao-footer {
    text-align: center;
    color: #999;
    margin-top: 40px;
    font-size: 13px;
}

/* ====== RESPONSIVE ====== */
@media(max-width: 768px){
    .baocao-item {
        flex-direction: column;
        align-items: flex-start;
    }
    .baocao-item img {
        width: 100%;
        height: auto;
    }
    .bar-wrapper {
        height: 22px;
    }
}
</style>
</head>
<body>

<h1>BÁO CÁO DOANH THU - FUJICARS</h1>

<div class="baocao-container">

<?php
// 🔹 Tìm giá trị cao nhất để quy đổi chiều dài thanh
$maxRevenue = 0;
foreach ($result as $r) {
    if ($r['TongDoanhThu'] > $maxRevenue) $maxRevenue = $r['TongDoanhThu'];
}
mysqli_data_seek($result, 0); // Reset con trỏ

// 🔹 Hiển thị từng sản phẩm
while($row = $result->fetch_assoc()) {
    $width = ($maxRevenue > 0) ? ($row['TongDoanhThu'] / $maxRevenue) * 100 : 0;
    $imgPath = !empty($row['HinhAnh']) ? 'View/img/SP/' . $row['HinhAnh'] : 'View/img/SP/noimage.png';
    $formattedRevenue = number_format($row['TongDoanhThu'],0,',','.') . " ₫";

    echo "
    <div class='baocao-item'>
        <img src='{$imgPath}' alt='".htmlspecialchars($row['TenSP'])."'>
        <div class='baocao-info'>
            <h2>".htmlspecialchars($row['TenSP'])."</h2>
            <div class='bar-value'>{$formattedRevenue}</div>
            <div class='bar-wrapper'>
                <div class='bar' style='width: {$width}%;'>
                    <span class='bar-tooltip'>{$formattedRevenue}</span>
                </div>
            </div>
        </div>
    </div>
    ";
}
?>

</div>

<div class="baocao-footer">
    Báo cáo được tổng hợp từ hệ thống FUJICARS. Cập nhật hàng ngày.
</div>

</body>
</html>
