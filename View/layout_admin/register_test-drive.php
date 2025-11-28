<?php 
include 'Controller/config/config.php';
mysqli_set_charset($conn, "utf8");

$message = "";
$message_type = "success"; // success | error

// ===== XỬ LÝ XÓA DỮ LIỆU =====
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if ($id > 0) {
        $check = mysqli_query($conn, "SELECT * FROM dangkilaithe WHERE id = $id");
        if (mysqli_num_rows($check) === 0) {
            $message = "Không tìm thấy ID cần xóa!";
            $message_type = "error";
        } else {
            $sql = "DELETE FROM dangkilaithe WHERE id = $id";
            if (mysqli_query($conn, $sql)) {
                $message = "Đã xóa thành công ID: $id";
                $message_type = "success";
            } else {
                $message = "Lỗi khi xóa: " . mysqli_error($conn);
                $message_type = "error";
            }
        }
    } else {
        $message = "Vui lòng chọn bản ghi cần xóa!";
        $message_type = "error";
    }
}

// ===== XỬ LÝ THÊM / SỬA =====
if (isset($_POST['action']) && $_POST['action'] === 'save') {
    $id = intval($_POST['id'] ?? 0);
    $hoten = mysqli_real_escape_string($conn, trim($_POST['hoten']));
    $sdt = mysqli_real_escape_string($conn, trim($_POST['sdt']));
    $tenxe = mysqli_real_escape_string($conn, trim($_POST['tenxe']));
    $ghichu = mysqli_real_escape_string($conn, trim($_POST['ghichu']));
    $ngay = mysqli_real_escape_string($conn, trim($_POST['ngay']));
    $gio = mysqli_real_escape_string($conn, trim($_POST['gio']));
    $diachi = mysqli_real_escape_string($conn, trim($_POST['diachi']));

    if ($id > 0) {
        $sql = "
            UPDATE dangkilaithe 
            SET hoten='$hoten', sdt='$sdt', tenxe='$tenxe', ghichu='$ghichu', ngay='$ngay', gio='$gio', diachi='$diachi'
            WHERE id=$id
        ";
        if(mysqli_query($conn, $sql)){
            $message = "Cập nhật thành công!";
            $message_type = "success";
        } else {
            $message = "Lỗi cập nhật: ".mysqli_error($conn);
            $message_type = "error";
        }
    } else {
        $sql = "
            INSERT INTO dangkilaithe (hoten, sdt, tenxe, ghichu, ngay, gio, diachi)
            VALUES ('$hoten', '$sdt', '$tenxe', '$ghichu', '$ngay', '$gio', '$diachi')
        ";
        if(mysqli_query($conn, $sql)){
            $message = "Thêm đăng ký mới thành công!";
            $message_type = "success";
        } else {
            $message = "Lỗi thêm mới: ".mysqli_error($conn);
            $message_type = "error";
        }
    }
}

// ===== TÌM KIẾM =====
$search = $_GET['search'] ?? '';
$query = "
    SELECT * FROM dangkilaithe
    WHERE hoten LIKE '%$search%' OR sdt LIKE '%$search%' OR tenxe LIKE '%$search%' OR diachi LIKE '%$search%'
    ORDER BY id DESC
";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý đăng ký lái thử</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* ==== BODY ==== */
body.renameBody {
    font-family: "Segoe UI", sans-serif;
    background: #f5f5f5;        /* đổi sang nền sáng */
    color: #000;
    margin: 0;
    padding: 0;
}

/* ==== WRAPPER ==== */
.boxContainer {
    width: 90%;
    max-width: 1450px;
    margin: 30px auto;
}

/* ==== TITLE ==== */
.pageTitle {
    text-align: center;
    font-size: 30px;
    color: #ff2e2e;             /* đồng bộ màu tiêu đề .nxu_header */
    margin-bottom: 25px;
}

/* ==== FORM ==== */
.formProduct {
    background: #fff;           /* form trắng giống .nxu_form */
    padding: 20px;
    border-radius: 12px;
    border: 1px solid #ccc;     /* mềm đẹp */
    box-shadow: 0 0 10px rgba(0,0,0,0.15);
    position: relative;
}

/* GRID INPUT */
.flexRow {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.groupItem {
    flex: 1 1 calc(33.33% - 20px);
    display: flex;
    flex-direction: column;
}

.groupItem label {
    color: #000;                /* đồng bộ label trong .nxu_label */
    font-size: 14px;
    margin-bottom: 6px;
}

/* INPUT + TEXTAREA */
.groupItem input,
.groupItem textarea {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #999;     /* thay border none → giống .nxu_input */
    background: #d3d3d3;        /* xám sáng */
    color: #000;
    transition: .25s;
}

.groupItem input:focus,
.groupItem textarea:focus {
    border-color: #ff2e2e;
    box-shadow: 0 0 5px rgba(255,46,46,0.4);
    background: #e3e3e3;
}

.groupItem textarea {
    resize: vertical;
    height: 45px;
}

/* ==== TABLE ==== */
.tableData {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    margin-top: 25px;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #ccc;
}

/* HEAD + CELL */
.tableData th,
.tableData td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
    color: #000;                /* bảng nền sáng → chữ đen */
}

.tableData th {
    background: #ff2e2e;        /* đồng bộ .nxu_tbl th */
    color: #fff;
    font-weight: 600;
}

/* ROW EVEN */
.tableData tbody tr:nth-child(even) {
    background: #f1f1f1;
}

/* ROW HOVER */
.tableData tbody tr:hover {
    background: #ffe5e5;        /* đỏ nhẹ */
    transition: 0.25s;
}

.buttonMain {display:inline-flex; align-items:center; justify-content:center; gap:6px;
font-weight:600; font-size:14px; border:none; border-radius:8px; padding:10px 18px; cursor:pointer; transition:0.3s; color:#fff;}
.btnAdd {background: linear-gradient(135deg, #43a047, #66bb6a);}
.btnDelete {background: linear-gradient(135deg, #e63946, #d90429);}

/* overlay hiệu ứng thông báo */
.nxu_overlay { position:fixed; inset:0; display:none; align-items:center; justify-content:center; background:rgba(0,0,0,0.75); z-index:9999; }
.nxu_box { background:#1b1b1b; color:#fff; padding:32px 44px; border-radius:14px; text-align:center; border:1px solid #00e676; box-shadow:0 0 20px rgba(0,255,0,0.2); transform:scale(0.95); opacity:0; animation:nxu_boxIn .18s forwards; }
@keyframes nxu_boxIn { to { transform:scale(1); opacity:1; } }
.nxu_spinner { width:56px; height:56px; border:4px solid rgba(255,255,255,0.15); border-top:4px solid #00e676; border-radius:50%; margin:0 auto 14px; animation:nxu_spin .9s linear infinite; display:none; }
@keyframes nxu_spin { to { transform:rotate(360deg); } }
.nxu_checkmark { width:90px; height:90px; margin:0 auto 14px; display:none; }
.nxu_checkmark__circle { fill:none; stroke:#00e676; stroke-width:3; stroke-linecap:round; stroke-linejoin:round; stroke-dasharray:166; stroke-dashoffset:166; }
.nxu_checkmark__check { fill:none; stroke:#fff; stroke-width:3; stroke-linecap:round; stroke-linejoin:round; stroke-dasharray:48; stroke-dashoffset:48; }
.nxu_animate-stroke .nxu_checkmark__circle,
.nxu_animate-stroke .nxu_checkmark__check { animation:nxu_dash 0.6s cubic-bezier(.65,0,.45,1) forwards; }
@keyframes nxu_dash { to { stroke-dashoffset:0; } }
.nxu_box h2 { color:#00e676; margin:0 0 8px; font-size:20px; }
.nxu_box p { color:#ddd; margin:0; }
/* Nút Hủy */
.btnCancel {
    background: linear-gradient(135deg, #555555, #777777);
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    border: none;
    border-radius: 8px;
    padding: 10px 18px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: 0.3s;
}

.btnCancel:hover {
    background: linear-gradient(135deg, #777777, #999999);
}

/* Nút In danh sách */
.btnPrint {
    background: linear-gradient(135deg, #2196f3, #64b5f6);
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    border: none;
    border-radius: 8px;
    padding: 10px 18px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: 0.3s;
}

.btnPrint:hover {
    background: linear-gradient(135deg, #42a5f5, #90caf9);
}

</style>
</head>
<body class="renameBody">

<div class="boxContainer">
    <h2 class="pageTitle"><i class="fa-solid fa-id-card"></i> CẬP NHẬT ĐĂNG KÝ LÁI THỬ</h2>

    <form method="POST" id="formDK" class="formProduct">
        <input type="hidden" name="id" id="id">
        <div class="flexRow">
            <div class="groupItem"><label>Họ tên</label><input type="text" name="hoten" id="hoten" required></div>
            <div class="groupItem"><label>Số điện thoại</label><input type="text" name="sdt" id="sdt" required></div>
            <div class="groupItem"><label>Tên xe</label><input type="text" name="tenxe" id="tenxe" required></div>
            <div class="groupItem"><label>Ngày</label><input type="date" name="ngay" id="ngay" required></div>
            <div class="groupItem"><label>Giờ</label><input type="text" name="gio" id="gio" required></div>
            <div class="groupItem"><label>Địa chỉ</label><input type="text" name="diachi" id="diachi" required></div>
            <div class="groupItem"><label>Ghi chú</label><textarea name="ghichu" id="ghichu"></textarea></div>
        </div>
        <div style="margin-top:20px; display:flex; gap:10px;   justify-content: center; ">
            <button type="submit" name="action" value="save" class="buttonMain btnAdd"><i class="fa-solid fa-floppy-disk"></i> Lưu / Cập nhật</button>
            <button type="submit" name="action" value="delete" class="buttonMain btnDelete"><i class="fa-solid fa-trash"></i> Xóa</button>
              <button type="button" id="btnCancel" class="buttonMain btnCancel"><i class="fa-solid fa-xmark"></i> Hủy</button>
    <button type="button" id="btnPrint" class="buttonMain btnPrint"><i class="fa-solid fa-print"></i> In danh sách</button>
    
        </div>
</br>
        <input type="text" id="searchInput" class="inputSearch" placeholder="Tìm theo họ tên..." style="margin-bottom:15px; padding:8px; border-radius:8px; border:none; background:#fff; color:#000; width:1300px;">

    </form>

    <table class="tableData">
        <thead>
            <tr>
                <th>ID</th><th>Họ tên</th><th>SĐT</th><th>Tên xe</th><th>Ngày</th><th>Giờ</th><th>Địa chỉ</th><th>Ghi chú</th><th>Ngày đăng ký</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr onclick='editRow(<?= json_encode($row) ?>)'>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['hoten']) ?></td>
                <td><?= htmlspecialchars($row['sdt']) ?></td>
                <td><?= htmlspecialchars($row['tenxe']) ?></td>
                <td><?= htmlspecialchars($row['ngay']) ?></td>
                <td><?= htmlspecialchars($row['gio']) ?></td>
                <td><?= htmlspecialchars($row['diachi']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['ghichu'])) ?></td>
                <td><?= $row['ngaydangky'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Overlay -->
<div class="nxu_overlay" id="nxuOverlay">
  <div class="nxu_box">
    <div class="nxu_spinner" id="nxuSpinner"></div>
    <svg class="nxu_checkmark" id="nxuCheck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
      <circle class="nxu_checkmark__circle" cx="26" cy="26" r="25"/>
      <path class="nxu_checkmark__check" d="M14 27l7 7 17-17"/>
    </svg>
    <h2 id="nxuMsgTitle">Thành công</h2>
    <p id="nxuMsgText"></p>
  </div>
</div>

<script>

// Live search - lọc bảng theo họ tên khi nhập
const searchInput = document.getElementById('searchInput');
searchInput.addEventListener('input', function() {
    const filter = searchInput.value.toLowerCase();
    const table = document.querySelector('.tableData tbody');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const td = rows[i].getElementsByTagName('td')[1]; // cột Họ tên (index 1)
        if (td) {
            const txtValue = td.textContent || td.innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
});


// NÚT HỦY - xóa tất cả input
document.getElementById('btnCancel').addEventListener('click', ()=>{
    const form = document.getElementById('formDK');
    form.reset();             // reset các input
    document.getElementById('id').value = ''; // reset id
});

// NÚT IN DANH SÁCH
document.getElementById('btnPrint').addEventListener('click', ()=>{
    const table = document.querySelector('.tableData');
    const newWin = window.open('', '', 'width=1200,height=800');
    newWin.document.write('<html><head><title>In danh sách</title>');
    newWin.document.write('<style>table{width:100%;border-collapse:collapse;} th,td{border:1px solid #000;padding:8px;text-align:center;} th{background:#eee;}</style>');
    newWin.document.write('</head><body>');
    newWin.document.write(table.outerHTML);
    newWin.document.write('</body></html>');
    newWin.document.close();
    newWin.print();
});


function editRow(data){
    for(const key in data){
        if(document.getElementById(key)){
            document.getElementById(key).value = data[key];
        }
    }
    document.getElementById('id').value = data.id;
    window.scrollTo({top:0, behavior:'smooth'});
}

const nxuOverlay = document.getElementById('nxuOverlay');
const nxuSpinner = document.getElementById('nxuSpinner');
const nxuCheck = document.getElementById('nxuCheck');
const nxuTitle = document.getElementById('nxuMsgTitle');
const nxuText = document.getElementById('nxuMsgText');

function nxuShowMessage(message, success=true){
    nxuOverlay.style.display = 'flex';
    nxuSpinner.style.display = 'none';
    nxuCheck.style.display = 'block';
    nxuCheck.classList.remove('nxu_animate-stroke');
    void nxuCheck.offsetWidth; 
    nxuCheck.classList.add('nxu_animate-stroke');
    nxuTitle.textContent = success ? "Thành công" : "Lỗi";
    nxuText.textContent = message;
    setTimeout(()=>nxuOverlay.style.display='none', 2000);
}

// Hiển thị thông báo PHP
<?php if($message): ?>
document.addEventListener('DOMContentLoaded', ()=>{
    nxuShowMessage("<?= addslashes($message) ?>", <?= $message_type=='success'?'true':'false' ?>);
});
<?php endif; ?>
</script>
</body>
</html>
