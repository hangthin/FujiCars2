<?php
include 'Controller/handle-admin/process_update-user.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý người dùng</title>
<link rel="stylesheet" href="View/css/styleCss.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="nxu_body">
<div class="nxu_container">
  <h1 class="nxu_header"><i class="fa-solid fa-users-gear"></i> CẬP NHẬT NGƯỜI DÙNG</h1>
  <form method="POST" id="nxuUserForm" class="nxu_form">
    <input type="hidden" name="id" id="nxuId">
    <div class="nxu_row">
      <div class="nxu_group"><label class="nxu_label">Tên tài khoản</label><input class="nxu_input" name="TenTK" id="nxuTenTK" required></div>
      <div class="nxu_group"><label class="nxu_label">Mật khẩu</label><input class="nxu_input" name="MatKhau" id="nxuMatKhau"></div>
      <div class="nxu_group">
        <label class="nxu_label">Quyền</label>
        <select class="nxu_input" name="Quyen" id="nxuQuyen" required>
          <option value=""></option>
          <option value="1">1 - Khách Hàng</option>
          <option value="2">2 - Quản Lý</option>
          <option value="3">3 - Admin</option>
          <option value="4">4 - Nhân Viên</option>
        </select>
      </div>
      <div class="nxu_group"><label class="nxu_label">Địa Chỉ</label><textarea class="nxu_input" name="DiaChi" id="nxuDiaChi"></textarea></div>
      <div class="nxu_group"><label class="nxu_label">Số điện thoại</label><input class="nxu_input" name="phone" id="nxuPhone"></div>
      <div class="nxu_group"><label class="nxu_label">Email</label><input class="nxu_input" name="email" id="nxuEmail" type="email"></div>
    </div>
  </form>
  <div class="nxu_topbar">
    <form method="GET" style="display:flex;flex:1;gap:10px;align-items:center;">
     <input type="text" id="nxuSearchInput" class="nxu_input-search" placeholder="Tìm kiếm tài khoản..." value="<?= htmlspecialchars($search) ?>">
     <button class="nxu_btn nxu_btn-reset" type="button" id="nxuBtnReset"><i class="fa-solid fa-xmark"></i> Hủy</button>
     <button class="nxu_btn nxu_btn-save" type="submit" form="nxuUserForm"><i class="fa-solid fa-floppy-disk"></i> Lưu / Cập nhật</button>
     <button type="button" class="nxu_btn nxu_btn-print" onclick="nxuPrintTable()">
      <i class="fa-solid fa-print"></i> In danh sách
    </button>
    </form>
  </div>
  <table class="nxu_tbl">
    <thead>
      <tr><th>ID</th><th>TenTK</th><th>MatKhau</th><th>Quyen</th><th>Địa Chỉ</th><th>Phone</th><th>Email</th><th>Ngày cập nhật</th><th>Xóa</th></tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr onclick='nxuEditRow(<?= json_encode($row, JSON_HEX_APOS|JSON_HEX_QUOT) ?>)'>
        <td><?= $row['ID'] ?></td>
        <td><?= htmlspecialchars($row['TenTK']) ?></td>
        <td><?= htmlspecialchars($row['MatKhau']) ?></td>
        <td><?= htmlspecialchars($row['Quyen']) ?></td>
        <td><?= htmlspecialchars($row['DiaChi']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['NgayCapNhat']) ?></td>
        <td>
          <form method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?');" style="display:inline;">
            <input type="hidden" name="delete_id" value="<?= $row['ID'] ?>">
            <button type="submit" style="background:none;border:none;color:#ff4444;cursor:pointer;font-size:18px;">
              <i class="fa-solid fa-trash"></i>
            </button>
          </form>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<!-- Overlay -->
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

<script>
  // In danh sách //
function nxuPrintTable() {
    let printContents = document.querySelector('.nxu_tbl').outerHTML;

    let win = window.open('', '', 'width=1000,height=700');
    win.document.write(`
        <html>
        <head>
            <title>Danh sách người dùng</title>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-family: Arial, sans-serif;
                    font-size: 14px;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background: #ddd;
                }
                h2 {
                    text-align: center;
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <h2>DANH SÁCH NGƯỜI DÙNG</h2>
            ${printContents}
        </body>
        </html>
    `);

    win.document.close();
    win.focus();
    win.print();
    win.close();
}
// CẬP NHẬT DANH SÁCH //
function nxuEditRow(user) {
    document.getElementById('nxuId').value = user.ID || '';
    document.getElementById('nxuTenTK').value = user.TenTK || '';
    document.getElementById('nxuMatKhau').value = '';
    document.getElementById('nxuQuyen').value = user.Quyen || '';
    document.getElementById('nxuDiaChi').value = user.DiaChi || '';
    document.getElementById('nxuPhone').value = user.phone || '';
    document.getElementById('nxuEmail').value = user.email || '';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

const nxuOverlay = document.getElementById('nxuOverlay');
const nxuSpinner = document.getElementById('nxuSpinner');
const nxuCheck = document.getElementById('nxuCheck');
const nxuError = document.getElementById('nxuError');
const nxuTitle = document.getElementById('nxuMsgTitle');
const nxuText = document.getElementById('nxuMsgText');

function nxuShowLoadingOverlay() {
    nxuOverlay.style.display = 'flex';
    nxuSpinner.style.display = 'block';
    nxuCheck.style.display = 'none';
    nxuError.style.display = 'none';
    nxuTitle.textContent = 'Đang xử lý...';
    nxuText.textContent = 'Vui lòng chờ trong giây lát';
}

function nxuShowOverlayResult(success, message) {
    nxuSpinner.style.display = 'none';
    if(success) {
        nxuCheck.style.display = 'block';
        nxuError.style.display = 'none';
        nxuCheck.classList.remove('nxu_animate-stroke');
        void nxuCheck.offsetWidth;
        nxuCheck.classList.add('nxu_animate-stroke');
        nxuTitle.textContent = 'Thành công';
    } else {
        nxuCheck.style.display = 'none';
        nxuError.style.display = 'block';
        nxuError.classList.remove('nxu_animate-stroke');
        void nxuError.offsetWidth;
        nxuError.classList.add('nxu_animate-stroke');
        nxuTitle.textContent = 'Thất bại';
    }
    nxuText.textContent = message;
    setTimeout(() => nxuOverlay.style.display = 'none', 1500);
}

const nxuSearchInput = document.getElementById('nxuSearchInput');
const nxuBtnSearch = document.getElementById('nxuBtnSearch');
const nxuBtnReset = document.getElementById('nxuBtnReset');
const nxuTable = document.querySelector('.nxu_tbl tbody');

function nxuFilterTable() {
    const filter = nxuSearchInput.value.toLowerCase();
    nxuTable.querySelectorAll('tr').forEach(tr => {
        const txt = tr.children[1].textContent.toLowerCase();
        tr.style.display = txt.includes(filter) ? '' : 'none';
    });
}
// Tự động lọc ngay khi người dùng nhập
nxuSearchInput.addEventListener('input', nxuFilterTable);
nxuBtnReset.addEventListener('click', () => {
    document.getElementById('nxuUserForm').reset();
    document.getElementById('nxuId').value = '';
    nxuSearchInput.value = '';
    nxuFilterTable();
});

<?php if($message): ?>
document.addEventListener('DOMContentLoaded', ()=>{
    nxuShowLoadingOverlay();
    setTimeout(()=>nxuShowOverlayResult(<?= $is_error?'false':'true' ?>, "<?= addslashes($message) ?>"),800);
});
<?php endif; ?>
</script>
</body>
</html>
