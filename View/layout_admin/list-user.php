<?php
include 'Controller/config/config.php';

// Lấy danh sách người dùng
$search = $_GET['search'] ?? '';
$searchEscaped = mysqli_real_escape_string($conn, $search);
$query = "SELECT * FROM nguoidung WHERE TenTK LIKE '%$searchEscaped%' ORDER BY ID DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Danh sách người dùng</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* Body & container */
body {
    background: #f5f5f5; /* nền sáng giống nxu_container */
    color: #000;
    font-family: "Segoe UI", Tahoma, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    width: 90%;
    max-width: 1400px;
    margin: 30px auto;
}

/* Header */
.header {
    text-align: center;
    font-size: 28px;
    color: red;
    margin-bottom: 20px;
}

/* Topbar & input */
.topbar {
    background: #fff;
    padding: 12px;
    border-radius: 10px;
    display: flex;
    gap: 10px;
    align-items: center;
    margin-bottom: 18px;
}

.input-search {
    flex: 1;
    min-width: 260px;
    padding: 10px;
    border-radius: 8px;
    border: none;
    background: #d3d3d3;
    color: #fff;
}

/* Buttons */
.btn {
    padding: 10px 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    color: #fff;
    font-weight: 600;
}

.btn.search {
    background: linear-gradient(135deg, #ff2e2e, #ff5959);
}

.btn.reset {
    background: linear-gradient(135deg, #f57c00, #ffa726);
}

.btn.save {
    background: linear-gradient(135deg, #43a047, #66bb6a);
}

/* Form & inputs */
.form {
    background: #fff;
    padding: 16px;
    border-radius: 10px;
    margin-bottom: 18px;
}

.row {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.group {
    flex: 1 1 220px;
    display: flex;
    flex-direction: column;
}

.label {
    color: #000;
    margin-bottom: 6px;
}

.input, .textarea {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid black;
    background: #d3d3d3;
    color: #000;
}

/* Table */
.tbl {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
}

.tbl th, .tbl td {
    padding: 10px;
    border-bottom: 1px solid #333;
    text-align: center;
    color: #000;
}

.tbl th {
    background: #ff2e2e;
    color: #fff;
}

</style>
</head>
<body>
<div class="container">
    <h1 class="header"><i class="fa-solid fa-users"></i> DANH SÁCH NGƯỜI DÙNG</h1>

    <div class="topbar">
        <input type="text" id="searchInput" class="input-search" placeholder="Tìm kiếm tài khoản..." value="<?= htmlspecialchars($search) ?>">
        <button class="btn search" id="btnSearch"><i class="fa-solid fa-magnifying-glass"></i> Tìm</button>
    </div>

    <table class="tbl">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên tài khoản</th>
                <th>Quyền</th>
                <th>Hình ảnh</th>
                <th>Địa chỉ</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Ngày cập nhật</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['ID'] ?></td>
                <td><?= htmlspecialchars($row['TenTK']) ?></td>
                <td><?= htmlspecialchars($row['Quyen']) ?></td>
                <td><?= htmlspecialchars($row['HinhAnh']) ?></td>
                <td><?= htmlspecialchars($row['DiaChi']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['NgayCapNhat']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
// Lọc bảng theo input tìm kiếm
const searchInput = document.getElementById('searchInput');
const tableRows = document.querySelectorAll('.tbl tbody tr');
document.getElementById('btnSearch').addEventListener('click', () => {
    const filter = searchInput.value.toLowerCase();
    tableRows.forEach(row => {
        const nameCell = row.cells[1];
        row.style.display = nameCell.textContent.toLowerCase().includes(filter) ? '' : 'none';
    });
});
</script>
</body>
</html>
