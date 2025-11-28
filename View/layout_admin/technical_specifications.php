<?php    
include 'Controller/config/config.php';

// Biến hiển thị thông báo
$message = "";
$is_error = false; // thêm biến kiểm tra lỗi

if (isset($_POST['xoa'])) {
    $ID = intval($_POST['ID']);

    mysqli_query($conn, "DELETE FROM thongsokithuat WHERE SanPhamID=$ID");
    mysqli_query($conn, "DELETE FROM sanpham WHERE ID=$ID");

    echo "OK";
    exit;
}


// --- Thêm / Sửa sản phẩm ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    // Map cột bảng sản phẩm
    $map = ['TenSP','MoTa','LoaiSP','Gia','SoLuong','NhienLieu','XuatXu','HinhAnh'];

    if ($id > 0) {

        // CẬP NHẬT SẢN PHẨM
        $fields = [];
        foreach($map as $col){
            $val = $_POST[$col] ?? '';
            $val = is_numeric($val) ? $val : "'" . mysqli_real_escape_string($conn, trim($val)) . "'";
            $fields[] = "$col=$val";
        }
        $fields[] = "NgayCapNhat='".date('Y-m-d')."'";

        mysqli_query($conn, "UPDATE sanpham SET " . implode(',', $fields) . " WHERE ID=$id");

        // Cập nhật thông số kỹ thuật
        $ts_map = ['CongSuat','HopSo','TangToc','TocDoToiDa','TrongLuong'];
        $oldTS = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM thongsokithuat WHERE SanPhamID=$id"));

        if ($oldTS) {
            // CẬP NHẬT
            $ts_fields = [];
            foreach($ts_map as $col){
                $val = "'" . mysqli_real_escape_string($conn, trim($_POST[$col] ?? '')) . "'";
                $ts_fields[] = "$col=$val";
            }
            mysqli_query($conn, "UPDATE thongsokithuat SET ".implode(',', $ts_fields)." WHERE SanPhamID=$id");
        } else {
            // THÊM MỚI (INSERT)
            $ts_cols = "SanPhamID";
            $ts_vals = $id;

            foreach($ts_map as $col){
                $ts_cols .= ",$col";
                $ts_vals .= ",'" . mysqli_real_escape_string($conn, trim($_POST[$col] ?? '')) . "'";
            }

            mysqli_query($conn, "INSERT INTO thongsokithuat($ts_cols) VALUES($ts_vals)");
        }

        $message = "Cập nhật sản phẩm thành công!";
    } else {
        // THÊM MỚI SẢN PHẨM
        $cols = "";
        $vals = "";

        foreach($map as $col){
            $cols .= "$col,";
            $vals .= "'" . mysqli_real_escape_string($conn, trim($_POST[$col] ?? '')) . "',";
        }

        $cols .= "NgayCapNhat";
        $vals .= "'" . date('Y-m-d') . "'";

        // INSERT sản phẩm
        $sql = "INSERT INTO sanpham ($cols) VALUES ($vals)";
        mysqli_query($conn, $sql);

        // Lấy ID vừa thêm
        $newID = mysqli_insert_id($conn);

        // Thêm thông số kỹ thuật
        $ts_map = ['CongSuat','HopSo','TangToc','TocDoToiDa','TrongLuong'];

        $ts_cols = "SanPhamID";
        $ts_vals = $newID;

        foreach($ts_map as $col){
            $ts_cols .= ",$col";
            $ts_vals .= ",'" . mysqli_real_escape_string($conn, trim($_POST[$col] ?? '')) . "'";
        }

        mysqli_query($conn, "INSERT INTO thongsokithuat($ts_cols) VALUES($ts_vals)");

        $message = "Cập nhật sản phẩm thành công!";
    }
}
// --- Lấy danh sách sản phẩm ---
$search = $_GET['search'] ?? '';
$query = "SELECT sp.*, ts.CongSuat, ts.HopSo, ts.TangToc, ts.TocDoToiDa, ts.TrongLuong
          FROM sanpham sp
          LEFT JOIN thongsokithuat ts ON sp.ID = ts.SanPhamID
          WHERE sp.TenSP LIKE '%$search%' OR sp.LoaiSP LIKE '%$search%'
          ORDER BY sp.ID DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý sản phẩm</title>
<link rel="stylesheet" href="View/css/styleCss.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body class="renameBody">
<div class="boxContainer">
    <h1 class="nxu_header"><i class="fa-solid fa-car"></i>  CẬP NHẬT THÔNG SỐ KĨ THUẬT</h2>
   
    <form method="POST" id="productForm" class="formProduct">
        <input type="hidden" name="id" id="id">
        <div class="flexRow">
            <div class="groupItem"><label>Tên sản phẩm</label><input type="text" name="TenSP" id="TenSP"></div>
            <div class="groupItem">
                <label>Mô tả</label>
                <select name="MoTa" id="MoTa">
                    <option value="">Chọn</option>
                    <option value="5 chỗ">5 chỗ</option>
                    <option value="7 chỗ">7 chỗ</option>
                </select>
            </div>
            <div class="groupItem">
                <label>Loại SP</label>
                <select name="LoaiSP" id="LoaiSP">
                    <option value="">Chọn loại</option>
                    <option value="Sedan">Sedan</option>
                    <option value="Suv">Suv</option>
                    <option value="Bán tải">Bán tải</option>
                    <option value="Đa dụng">Đa dụng</option>
                    <option value="Hatchback">Hatchback</option>
                </select>
            </div>
            <div class="groupItem">
                <label>Giá</label>
                <input type="text" name="Gia" id="Gia" value="100000000">
            </div>
            <div class="groupItem">
                <label>Số lượng</label>
                <input type="number" name="SoLuong" id="SoLuong" value="1" min="1" step="1">
            </div>
            <div class="groupItem">
                <label>Nhiên liệu</label>
                <select name="NhienLieu" id="NhienLieu">
                    <option value="">Chọn nhiên liệu</option>
                    <option value="Xăng">Xăng</option>
                    <option value="Điện">Điện</option>
                </select>
            </div>
            <div class="groupItem">
                <label>Xuất xứ</label>
                <select name="XuatXu" id="XuatXu">
                    <option value="">Chọn xuất xứ</option>
                    <option value="Đức">Đức</option>
                    <option value="Thái Lan">Thái Lan</option>
                    <option value="Nhật Bản">Nhật Bản</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Hàn Quốc">Hàn Quốc</option>
                </select>
            </div>
            <div class="groupItem">
                <label>Hình ảnh</label>
                <input type="file" name="HinhAnhFile" id="HinhAnhFile" accept="image/*">
                <input type="text" name="HinhAnh" id="HinhAnh" placeholder="Tên hoặc URL ảnh" readonly>
                <img id="PreviewImg" style="width:120px; margin-top:5px;">
            </div>
            <div class="groupItem"><label>Công suất</label><input type="text" name="CongSuat" id="CongSuat"></div>
            <div class="groupItem"><label>Hộp số</label><input type="text" name="HopSo" id="HopSo"></div>
            <div class="groupItem"><label>Tăng tốc</label><input type="text" name="TangToc" id="TangToc"></div>
            <div class="groupItem"><label>Tốc độ tối đa</label><input type="text" name="TocDoToiDa" id="TocDoToiDa"></div>
            <div class="groupItem"><label>Trọng lượng</label><input type="text" name="TrongLuong" id="TrongLuong"></div>
        </div>
    </form>
     <div class="controlTop">
        <form method="GET" class="formControlTop">
           <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?= htmlspecialchars($search) ?>">
           <button type="button" onclick="resetForm()" class="buttonMain btnReset">
                <i class="fa-solid fa-xmark"></i> Hủy
           </button>
           <button type="submit" form="productForm" class="buttonMain btnAdd"><i class="fa-solid fa-floppy-disk"></i> Lưu / Cập nhật</button>
           <button type="button" style="color:black" class="buttonMain btnPrint" onclick="printTable()">
            <i class="fa-solid fa-print"></i> In danh sách
            </button>
            <button type="button" class="buttonMain btnDeleteMain" style="background:red" onclick="deleteCurrentProduct()">
    <i class="fa-solid fa-trash"></i> Xóa
</button>

        </form>
    </div>
    <table class="tableData">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên SP</th>
                <th>Mô tả</th>
                <th>Loại</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Nhiên liệu</th>
                <th>Xuất xứ</th>
                <th>Thông số kỹ thuật</th>
                <th>Ngày cập nhật</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row=mysqli_fetch_assoc($result)): ?>
            <tr onclick='editRow(<?= json_encode($row) ?>)'>
                <td><?= $row['ID'] ?></td>
                <td><?= htmlspecialchars($row['TenSP']) ?></td>
                <td><?= htmlspecialchars($row['MoTa']) ?></td>
                <td><?= htmlspecialchars($row['LoaiSP']) ?></td>
                <td><?= number_format($row['Gia'],0,',','.') ?>₫</td>
                <td><?= htmlspecialchars($row['SoLuong']) ?></td>
                <td><?= htmlspecialchars($row['NhienLieu']) ?></td>
                <td><?= htmlspecialchars($row['XuatXu']) ?></td>
                <td>
                    <?= "Công suất: {$row['CongSuat']}<br>Hộp số: {$row['HopSo']}<br>Tăng tốc: {$row['TangToc']}<br>Tốc độ: {$row['TocDoToiDa']}<br>Trọng lượng: {$row['TrongLuong']}" ?>
                </td>
                <td><?= $row['NgayCapNhat'] ?></td>

            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<!-- Overlay hiệu ứng mới -->
<div class="nxu_overlay" id="nxuOverlay">
  <div class="nxu_box" id="nxuBox">
    <div class="nxu_spinner" id="nxuSpinner"></div>
    <svg class="nxu_checkmark" id="nxuCheck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="nxu_checkmark__circle" cx="26" cy="26" r="25"/>
      <path class="nxu_checkmark__check" d="M14 27l7 7 17-17"/>
    </svg>
    <svg class="nxu_errormark" id="nxuError" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="nxu_errormark__circle" cx="26" cy="26" r="25"/>
      <path class="nxu_errormark__cross" d="M16 16 36 36 M36 16 16 36"/>
    </svg>
    <h2 id="nxuMsgTitle">Đang xử lý...</h2>
    <p id="nxuMsgText">Vui lòng chờ trong giây lát</p>
  </div>
</div>

<?php if($message): ?>
<script>
document.addEventListener('DOMContentLoaded', ()=>{
    nxuShowLoadingOverlay();
    setTimeout(() => {
        nxuShowOverlayResult(<?= $is_error ? 'false' : 'true' ?>, "<?= addslashes($message) ?>");
    }, 800);
});
</script>
<?php endif; ?>
<script>
<?php include "js/update_technical-specifications.js"; ?>
</script>
</body>
</html>
