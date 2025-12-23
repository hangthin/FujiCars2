<?php
include("Controller/config/config.php");
session_start();

$message = "";
$is_error = false;
$LoaiMoiVuaThem = "";

// ===== THÊM LOẠI SẢN PHẨM =====
if (isset($_POST['themLoai'])) {
    $LoaiMoi = trim(mysqli_real_escape_string($conn, $_POST['LoaiMoi']));

    if ($LoaiMoi == "") {
        $message = "Vui lòng nhập tên loại sản phẩm!";
        $is_error = true;
    } else {
        $check = mysqli_query($conn,
            "SELECT DISTINCT LoaiSP FROM sanpham WHERE LoaiSP='$LoaiMoi'"
        );

        if (mysqli_num_rows($check) > 0) {
            $message = "Loại sản phẩm '$LoaiMoi' đã tồn tại!";
            $is_error = true;
        } else {
            $sql = "INSERT INTO sanpham (TenSP, LoaiSP, Gia, SoLuong)
                    VALUES ('Sản phẩm mẫu', '$LoaiMoi', 0, 0)";
            if (mysqli_query($conn, $sql)) {
                $message = "Thêm loại sản phẩm '$LoaiMoi' thành công!";
                $LoaiMoiVuaThem = $LoaiMoi; // đánh dấu loại mới
            } else {
                $message = "Lỗi khi thêm: " . mysqli_error($conn);
                $is_error = true;
            }
        }
    }
}

// ===== XÓA THEO LOẠI =====
if (isset($_POST['xoaLoai'])) {
    $LoaiSP = mysqli_real_escape_string($conn, $_POST['LoaiSPDel']);

    if ($LoaiSP == "") {
        $message = "Vui lòng chọn loại sản phẩm để xóa!";
        $is_error = true;
    } else {
        mysqli_query($conn, "DELETE FROM sanpham WHERE LoaiSP='$LoaiSP'");
        $message = "Xóa tất cả sản phẩm loại '$LoaiSP' thành công!";
    }
}

// ===== DANH SÁCH LOẠI (ƯU TIÊN LOẠI MỚI) =====
$loaiList = [];
$sqlLoai = "
    SELECT DISTINCT LoaiSP
    FROM sanpham
    ORDER BY 
        CASE WHEN LoaiSP='$LoaiMoiVuaThem' THEN 0 ELSE 1 END,
        LoaiSP ASC
";
$resLoai = mysqli_query($conn, $sqlLoai);
while ($row = mysqli_fetch_assoc($resLoai)) {
    $loaiList[] = $row['LoaiSP'];
}

// ===== LẤY SẢN PHẨM =====
$filterLoai = $_GET['loai'] ?? '';
$filterLoai = mysqli_real_escape_string($conn, $filterLoai);

if ($filterLoai != "") {
    $sqlSP = "
        SELECT * FROM sanpham
        WHERE LoaiSP='$filterLoai'
        ORDER BY ID DESC
    ";
} else {
    $sqlSP = "
        SELECT * FROM sanpham
        ORDER BY 
            CASE WHEN LoaiSP='$LoaiMoiVuaThem' THEN 0 ELSE 1 END,
            ID DESC
    ";
}
$result = mysqli_query($conn, $sqlSP);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý loại sản phẩm</title>
<link rel="stylesheet" href="View/css/styleCss.css">
</head>

<body class="zc-page-body">

<h1 style="color:#b91c1c">CẬP NHẬT LOẠI SẢN PHẨM</h1>

<?php if ($message): ?>
<div id="msgBox" class="zc-message <?= $is_error?'zc-message-error':'zc-message-success' ?>">
    <?= htmlspecialchars($message) ?>
</div>
<script>
setTimeout(() => {
    const box = document.getElementById("msgBox");
    if (box) box.style.display = "none";
}, 3000);
</script>
<?php endif; ?>

<form method="POST" class="zc-form">

    <div>
        <input type="text" name="LoaiMoi" placeholder="Nhập loại mới">
        <button name="themLoai" class="zc-btn-red">Thêm</button>
    </div>

    <div>
        <select onchange="location.href='index.php?n=product-type&loai='+this.value">
            <option value="">Tất cả</option>
            <?php foreach ($loaiList as $l): ?>
                <option value="<?= $l ?>" <?= $filterLoai==$l?'selected':'' ?>>
                    <?= $l ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <select name="LoaiSPDel">
            <option value="">Chọn loại xóa</option>
            <?php foreach ($loaiList as $l): ?>
                <option value="<?= $l ?>"><?= $l ?></option>
            <?php endforeach; ?>
        </select>
        <button name="xoaLoai" class="zc-btn-black"
                onclick="return confirm('Xóa toàn bộ sản phẩm loại này?')">Xóa</button>
    </div>

</form>

<table class="zc-table">
<tr>
    <th>ID</th><th>Tên SP</th><th>Loại</th><th>Giá</th><th>SL</th>
</tr>
<?php if (mysqli_num_rows($result)): while ($r = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= $r['ID'] ?></td>
    <td><?= $r['TenSP'] ?></td>
    <td><?= $r['LoaiSP'] ?></td>
    <td><?= number_format($r['Gia'],0,',','.') ?>₫</td>
    <td><?= $r['SoLuong'] ?></td>
</tr>
<?php endwhile; else: ?>
<tr><td colspan="5" align="center">Không có dữ liệu</td></tr>
<?php endif; ?>
</table>

</body>
</html>
