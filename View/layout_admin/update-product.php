  <?php
  include("Controller/config/config.php"); 
  $message = "";
  $is_error = false;

  /* ====== XỬ LÝ THÊM ====== */
  if (isset($_POST['them'])) {
      $TenSP = mysqli_real_escape_string($conn, $_POST['TenSP']);
      $MoTa = mysqli_real_escape_string($conn, $_POST['MoTa']);
      $NgayCapNhat = $_POST['NgayCapNhat'];
      $LoaiSP = $_POST['LoaiSP'];
      $Gia = $_POST['Gia'];
      $SoLuong = $_POST['SoLuong'];
      $NhienLieu = $_POST['NhienLieu'];
      $XuatXu = $_POST['XuatXu'];

      $HinhAnh = '';
      if (!empty($_POST['HinhAnhURL'])) {
          $HinhAnh = $_POST['HinhAnhURL'];
      } elseif (!empty($_FILES['HinhAnhFile']['name'])) {
          $targetDir = "View/img/SP/";
          if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
          $fileName = basename($_FILES['HinhAnhFile']['name']);
          $targetFile = $targetDir . $fileName;
          if (move_uploaded_file($_FILES['HinhAnhFile']['tmp_name'], $targetFile)) {
              $HinhAnh = $fileName;
          } else {
              $message = "Không thể tải ảnh lên.";
              $is_error = true;
          }
      }

      if (!$is_error) {
          $sql = "INSERT INTO sanpham (TenSP, MoTa, NgayCapNhat, HinhAnh, LoaiSP, Gia, SoLuong, NhienLieu, XuatXu)
                  VALUES ('$TenSP','$MoTa','$NgayCapNhat','$HinhAnh','$LoaiSP','$Gia','$SoLuong','$NhienLieu','$XuatXu')";
          if (mysqli_query($conn, $sql)) $message = "Thêm sản phẩm thành công!";
          else { $message = "Lỗi khi thêm: ".mysqli_error($conn); $is_error = true; }
      }
  }

  /* ====== XỬ LÝ SỬA ====== */
  if (isset($_POST['sua'])) {
      $ID = $_POST['ID'];
      $TenSP = mysqli_real_escape_string($conn, $_POST['TenSP']);
      $MoTa = mysqli_real_escape_string($conn, $_POST['MoTa']);
      $NgayCapNhat = $_POST['NgayCapNhat'];
      $LoaiSP = $_POST['LoaiSP'];
      $Gia = $_POST['Gia'];
      $SoLuong = $_POST['SoLuong'];
      $NhienLieu = $_POST['NhienLieu'];
      $XuatXu = $_POST['XuatXu'];
      $HinhAnh = $_POST['HinhAnh'] ?? '';

      if (!empty($_FILES['HinhAnhFile']['name'])) {
          $targetDir = "View/img/SP/";
          if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
          $fileName = basename($_FILES['HinhAnhFile']['name']);
          $targetFile = $targetDir . $fileName;
          if (move_uploaded_file($_FILES['HinhAnhFile']['tmp_name'], $targetFile))
              $HinhAnh = $fileName;
          else { $message = "Không thể tải ảnh mới."; $is_error = true; }
      }

      if (!$is_error) {
          $sql = "UPDATE sanpham SET 
                    TenSP='$TenSP', MoTa='$MoTa', NgayCapNhat='$NgayCapNhat',
                    HinhAnh='$HinhAnh', LoaiSP='$LoaiSP', Gia='$Gia',
                    SoLuong='$SoLuong', NhienLieu='$NhienLieu', XuatXu='$XuatXu'
                  WHERE ID='$ID'";
          if (mysqli_query($conn, $sql)) $message = "Sửa sản phẩm thành công!";
          else { $message = "Lỗi khi sửa: ".mysqli_error($conn); $is_error = true; }
      }
  }

  /* ====== XÓA ====== */
  if (isset($_POST['xoa'])) {
      $ID = $_POST['ID'];
      mysqli_query($conn, "DELETE FROM thongsokithuat WHERE SanPhamID='$ID'");
          mysqli_query($conn, "DELETE FROM kho_xe_laythu WHERE MaXe='$ID'"); // <-- thêm dòng này
      if (mysqli_query($conn, "DELETE FROM sanpham WHERE ID='$ID'")) 
          $message = "Xóa sản phẩm thành công!";
      else { $message = "Lỗi khi xóa: ".mysqli_error($conn); $is_error = true; }
  }

  $search = $_POST['search'] ?? '';
  $result = mysqli_query($conn, "SELECT * FROM sanpham WHERE TenSP LIKE '%$search%' ORDER BY ID ASC");
  ?>
  <!DOCTYPE html>
  <html lang="vi">
  <head>
  <meta charset="UTF-8">
  <title>Quản lý sản phẩm ô tô</title>
  <link rel="stylesheet" href="View/css/styleCss.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  </head>
  <body class="bodycnsp">
  <body class="nxadmin-body">

  <!-- Overlay thông báo -->
  <div class="nx-overlay" id="nxOverlay">
    <div class="nx-box" id="nxBox">
      <div class="spinner" id="nxSpinner"></div>

      <!-- Tick xanh -->
      <svg class="checkmark" id="nxCheck" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
        <circle class="checkmark__circle" cx="26" cy="26" r="25"/>
        <path class="checkmark__check" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
      </svg>

      <!-- Dấu X đỏ -->
      <svg class="errormark" id="nxError" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
        <circle class="errormark__circle" cx="26" cy="26" r="25"/>
        <path class="errormark__cross" d="M16 16 36 36 M36 16 16 36"/>
      </svg>

      <h2 id="nxMsgTitle">Đang xử lý...</h2>
      <p id="nxMsgText">Vui lòng chờ trong giây lát</p>
    </div>
  </div>

  <div class="nxadmin-wrapper">
   <h1 class="nxu_header"><i class="fa-solid fa-cube"></i> CẬP NHẬT SẢN PHẨM</h2>

  <form class="nxadmin-form" method="POST" enctype="multipart/form-data">
      <input type="hidden" id="ID" name="ID">
      <input type="hidden" id="HinhAnh" name="HinhAnh">

      <div class="nxadmin-row">
        <div class="nxadmin-group">
          <label>Tên sản phẩm:</label>
          <input type="text" id="TenSP" name="TenSP" value="">
        </div>
        <div class="nxadmin-group">
          <label>Loại SP:</label>
          <select name="LoaiSP" id="LoaiSP">
            <option value="">Chọn loại</option>
            <option value="Sedan">Sedan</option>
            <option value="Suv">Suv</option>
            <option value="Bán tải">Bán tải</option>
            <option value="Đa dụng">Đa dụng</option>
            <option value="Hatchback">Hatchback</option>
          </select>
        </div>
      </div>

      <div class="nxadmin-row">
        <div class="nxadmin-group">
          <label>Giá:</label>
          <input type="text" name="Gia" id="Gia" value="100000000">
        </div>
        <div class="nxadmin-group">
          <label>Số lượng:</label>
          <input type="number" name="SoLuong" id="SoLuong" value="1">
        </div>
      </div>

      <div class="nxadmin-row">
        <div class="nxadmin-group">
          <label>Nhiên liệu:</label>
          <select name="NhienLieu" id="NhienLieu">
            <option value="">Chọn nhiên liệu</option>
            <option value="Xăng">Xăng</option>
            <option value="Điện">Điện</option>
          </select>
        </div>
        <div class="nxadmin-group">
          <label>Xuất xứ:</label>
          <select name="XuatXu" id="XuatXu">
            <option value="">Chọn xuất xứ</option>
            <option value="Đức">Đức</option>
            <option value="Thái Lan">Thái Lan</option>
            <option value="Nhật Bản">Nhật Bản</option>
            <option value="Indonesia">Indonesia</option>
            <option value="Indonesia">Hàn Quốc</option>
          </select>
        </div>
      </div>

      <div class="nxadmin-row">
        <div class="nxadmin-group">
          <label>Ngày cập nhật:</label>
          <input type="date" id="NgayCapNhat" name="NgayCapNhat" value="<?= date('Y-m-d') ?>">
        </div>
        <div class="nxadmin-group nx-imgbox">
    <label>Hình ảnh:</label>
    <div class="nx-img-input">
      <input type="file" name="HinhAnhFile" id="HinhAnhFile" accept="image/*">
      <input type="text" name="HinhAnhURL" id="HinhAnhURL" placeholder="Hoặc dán URL hình ảnh">
      <div class="nx-img-preview">
        <img id="PreviewImg" src="View/img/SP/mau.png" alt="preview">
      </div>
    </div>
  </div>
      </div>
      <div class="nxadmin-group">
        <label>Mô tả:</label>
        <select name="MoTa" id="MoTa">
          <option value="">Chọn</option>
          <option value="5 chỗ">5 chỗ</option>
          <option value="7 chỗ">7 chỗ</option>
        </select>
      </div>
      <div class="nxadmin-controls">
        <input type="text" name="search" class="nxadmin-search" placeholder="Nhập tên sản phẩm..." value="<?= htmlspecialchars($search) ?>">
        <button class="nxadmin-btn nxadmin-btn-add" name="them"><i class="fa-solid fa-plus"></i> Thêm</button>
        <button class="nxadmin-btn nxadmin-btn-edit" name="sua"><i class="fa-solid fa-pen"></i> Sửa</button>
        <button class="nxadmin-btn nxadmin-btn-del" name="xoa"><i class="fa-solid fa-trash"></i> Xóa</button>
        <button type="button" class="nxadmin-btn nxadmin-btn-cancel" id="btnHuy">
        <i class="fa-solid fa-xmark"></i> Hủy
        </button>
        <button type="button" class="nxadmin-btn nxadmin-btn-print" id="btnIn">
        <i class="fa-solid fa-print"></i> In danh sách
        </button>


      </div>
  </form>
  <table class="nxadmin-table">
  <tr>
  <th>ID</th><th>Tên SP</th><th>Mô tả</th><th>Ngày cập nhật</th><th>Hình ảnh</th>
  <th>Loại SP</th><th>Giá</th><th>Số lượng</th><th>Nhiên liệu</th><th>Xuất xứ</th>
  </tr>
  <?php while ($r = mysqli_fetch_assoc($result)) { ?>
  <tr onclick="nxFillForm(this)">
    <td><?= $r['ID'] ?></td>
    <td><?= htmlspecialchars($r['TenSP']) ?></td>
    <td><?= htmlspecialchars($r['MoTa']) ?></td>
    <td><?= $r['NgayCapNhat'] ?></td>
    <td><?= $r['HinhAnh'] ?></td>
    <td><?= htmlspecialchars($r['LoaiSP']) ?></td>
    <td><?= $r['Gia'] ?></td>
    <td><?= $r['SoLuong'] ?></td>
    <td><?= htmlspecialchars($r['NhienLieu']) ?></td>
    <td><?= htmlspecialchars($r['XuatXu']) ?></td>
  </tr>
  <?php } ?>
  </table>
  </div>

  <script>

  // ===== SEARCH REALTIME =====
  document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.nxadmin-search');
    const tableRows = document.querySelectorAll('.nxadmin-table tr:not(:first-child)');
    
    if (searchInput) {
      searchInput.addEventListener('keyup', () => {
        const keyword = searchInput.value.toLowerCase().trim();
        tableRows.forEach(row => {
          const tenSP = row.cells[1].innerText.toLowerCase();
          row.style.display = tenSP.includes(keyword) ? '' : 'none';
        });
      });
    }
  });


  document.getElementById('btnIn').addEventListener('click', function() {
      const table = document.querySelector('.nxadmin-table');
      if (!table) return;

      const printWindow = window.open('', '', 'width=1000,height=600');
      const html = `
      <html>
      <head>
          <title>In danh sách sản phẩm</title>
          <style>
              body { font-family: Arial, sans-serif; padding: 20px; }
              table { width: 100%; border-collapse: collapse; }
              th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
              th { background-color: #f4f4f4; }
              img { width: 100px; height: 60px; object-fit: cover; }
          </style>
      </head>
      <body>
          <h2>Danh sách sản phẩm ô tô</h2>
          ${table.outerHTML}
      </body>
      </html>
      `;
      printWindow.document.write(html);
      printWindow.document.close();
      printWindow.focus();
      printWindow.print();
  });


  document.addEventListener('DOMContentLoaded', function() {
      const btnHuy = document.getElementById('btnHuy');

      btnHuy.addEventListener('click', function() {
          // Reset các input text và hidden
          ['ID','TenSP','Gia','SoLuong','HinhAnh','HinhAnhURL','NgayCapNhat'].forEach(id => {
              const el = document.getElementById(id);
              if(el) el.value = '';
          });

          // Reset các select về option đầu tiên
          ['LoaiSP','NhienLieu','XuatXu','MoTa'].forEach(id => {
              const el = document.getElementById(id);
              if(el) el.selectedIndex = 0;
          });

          // Reset preview hình
          const preview = document.getElementById('PreviewImg');
          if(preview) preview.src = 'View/img/SP/mau.png';

          // Xóa file input hiện tại
          const fileInput = document.getElementById('HinhAnhFile');
          if(fileInput) fileInput.value = '';

          // Nếu muốn reset overlay/ thông báo (nếu có)
          const overlay = document.getElementById('nxOverlay');
          if(overlay) overlay.style.display = 'none';
      });
  });

  <?php if($message): ?>
  document.addEventListener('DOMContentLoaded',()=>{
    const overlay=document.getElementById('nxOverlay');
    const box=document.getElementById('nxBox');
    const spinner=document.getElementById('nxSpinner');
    const check=document.getElementById('nxCheck');
    const err=document.getElementById('nxError');
    const title=document.getElementById('nxMsgTitle');
    const text=document.getElementById('nxMsgText');

    overlay.style.display='flex';
    spinner.style.display='block';
    check.style.display='none';
    err.style.display='none';
    title.innerText='Đang xử lý...';
    text.innerText='Vui lòng chờ trong giây lát';

    setTimeout(()=>{
      spinner.style.display='none';
      if(<?= $is_error ? 'true':'false' ?>){
        err.style.display='block';
        title.innerText='Thất bại';
        text.innerText="<?= addslashes($message) ?>";
      } else {
        check.style.display='block';
        title.innerText='Thành công';
        text.innerText="<?= addslashes($message) ?>";
      }
      // animation biến mất
      setTimeout(()=>{
        box.style.animation='zoomOut 0.4s ease forwards';
        setTimeout(()=> overlay.style.display='none',350);
      },2500);
    },1500);
  });
  <?php endif; ?>
  <?php include "js/product_update.js"; ?>
  </script>
  </body>
  </html>
