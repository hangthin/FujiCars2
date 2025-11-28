<?php
include("Controller/config/config.php");

// Lấy dữ liệu sản phẩm
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM sanpham WHERE TenSP LIKE '%$search%' ORDER BY ID ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Danh sách sản phẩm ô tô</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="View/css/styleCss.css">
</head>
<body class="bodycnsp">

<div class="nxadmin-wrapper">

    <!-- Tiêu đề -->
    <h2 class="nxadmin-title">DANH SÁCH SẢN PHẨM</h2>

    <!-- Form tìm kiếm + nút in -->
    <div class="nxadmin-form">
        <input type="text" id="searchInput" placeholder="Tìm tên sản phẩm..." value="<?= htmlspecialchars($search) ?>">
        <button type="button" class="nxadmin-btn nxadmin-btn-search" id="searchBtn">
            <i class="fa-solid fa-magnifying-glass"></i> Tìm
        </button>
        <button class="nxadmin-btn nxadmin-btn-print" id="printBtn">
            <i class="fa-solid fa-print"></i> In danh sách
        </button>
    </div>

    <!-- Bảng sản phẩm -->
    <table class="nxadmin-table" id="productTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tên SP</th>
            <th>Mô tả</th>
            <th>Ngày cập nhật</th>
            <th>Hình ảnh</th>
            <th>Loại SP</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Nhiên liệu</th>
            <th>Xuất xứ</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($r = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $r['ID'] ?></td>
            <td><?= htmlspecialchars($r['TenSP']) ?></td>
            <td><?= htmlspecialchars($r['MoTa']) ?></td>
            <td><?= $r['NgayCapNhat'] ?></td>
            <td>
                <?php if(!empty($r['HinhAnh'])): ?>
                    <div class="nx-img-preview">
                        <img src="View/img/SP/<?= $r['HinhAnh'] ?>" alt="Hình SP">
                    </div>
                <?php else: ?>
                    Không có hình
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($r['LoaiSP']) ?></td>
            <td><?= number_format($r['Gia'],0,",",".") ?>₫</td>
            <td><?= $r['SoLuong'] ?></td>
            <td><?= htmlspecialchars($r['NhienLieu']) ?></td>
            <td><?= htmlspecialchars($r['XuatXu']) ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

<script>
// --- JS tìm kiếm và in ---
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const printBtn = document.getElementById('printBtn');
    const table = document.querySelector('.nxadmin-table');
    const rows = Array.from(table.querySelectorAll('tbody tr'));

    // Tìm kiếm trực tiếp
    function filterTable() {
        const filter = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const nameCell = row.cells[1].textContent.toLowerCase();
            row.style.display = nameCell.includes(filter) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    searchBtn.addEventListener('click', filterTable);

    // In danh sách hiển thị
    printBtn.addEventListener('click', function() {
        const visibleRows = rows.filter(r => r.style.display !== 'none');
        const printWindow = window.open('', '', 'width=1000,height=600');
        const html = `
            <html>
            <head>
                <title>In danh sách sản phẩm</title>
                <style>
                    body{font-family: Arial, sans-serif; padding:20px; background:#fff; color:#000;}
                    table{width:100%; border-collapse:collapse;}
                    th, td{border:1px solid #ccc; padding:8px; text-align:center;}
                    th{background-color:#ff2e2e; color:#fff;}
                    img{width:100px; height:60px; object-fit:cover;}
                </style>
            </head>
            <body>
                <h2>Danh sách sản phẩm ô tô</h2>
                <table>
                    <tr>
                        <th>ID</th><th>Tên SP</th><th>Mô tả</th><th>Ngày cập nhật</th>
                        <th>Hình ảnh</th><th>Loại SP</th><th>Giá</th><th>Số lượng</th>
                        <th>Nhiên liệu</th><th>Xuất xứ</th>
                    </tr>
                    ${visibleRows.map(r => r.outerHTML).join('')}
                </table>
            </body>
            </html>
        `;
        printWindow.document.write(html);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    });
});
</script>

</body>
</html>
