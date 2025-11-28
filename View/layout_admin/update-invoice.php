<?php
$data = include("Controller/handle-admin/process_update-invoice.php");
$result = $data["result"];
$message = $data["message"];
$is_error = $data["is_error"];
$newInsertedID = $data["newInsertedID"];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý hóa đơn</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="View/css/styleCss.css">
<style>
.wrapbox{max-width:1300px;margin:auto;background:#fff;padding:20px;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.1);}
.tabstyle{width:100%;border-collapse:collapse;margin-top:20px;}
.tabstyle th, .tabstyle td{border:1px solid #ccc;padding:8px;text-align:center;}
.rowstyle{display:flex;gap:10px;margin-bottom:10px;}
.groupstyle{flex:1;display:flex;flex-direction:column;}
.ctrlstyle{margin-top:10px;}
.btnstyle{padding:6px 10px;margin-right:5px;cursor:pointer;border:none;border-radius:5px;}
.btnadd{background:#28a745;color:#fff;width:150px;height:50px;}
.btnedit{background:#ffc107;color:#fff;width:150px;height:50px;}
.btndel{background:#dc3545;color:#fff;width:150px;height:50px;}
.searchbox{padding:6px;width:1250px;}
.highlight-new{background-color:#fff3cd !important; transition: background 1s;}
</style>
</head>
<body>
<div class="wrapbox">
    <h1><i class="fa-solid fa-file-invoice"></i> CẬP NHẬT HÓA ĐƠN</h1>
    <?php if($message): ?>
        <p style="color:<?= $is_error ? 'red':'green' ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <!-- Form Thêm / Sửa -->
    <form method="POST" class="formstyle" id="invoiceFormNX">
        <input type="hidden" name="ID" id="invoiceIDNX">
        <div class="rowstyle">
            <div class="groupstyle"><label>Name</label><input type="text" name="Name" id="invoiceNameNX" required></div>
            <div class="groupstyle"><label>Phone</label><input type="text" name="Phone" id="invoicePhoneNX" required></div>
            <div class="groupstyle"><label>Địa Chỉ</label><input type="text" name="Address" id="invoiceAddressNX" required></div>
        </div>
        <div class="rowstyle">
            <div class="groupstyle"><label>Ngày nhận</label><input type="date" name="DateReceive" id="invoiceDateReceiveNX" required></div>
            <div class="groupstyle"><label>Giờ nhận</label><input type="time" name="TimeReceive" id="invoiceTimeReceiveNX" required></div>
            <div class="groupstyle">
                <label>Phương thức</label>
                <select name="Method" id="invoiceMethodNX">
                    <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                    <option value="Chuyển khoản ngân hàng">Chuyển khoản ngân hàng</option>
                </select>
            </div>
        </div>
        <div class="rowstyle"><div class="groupstyle"><label>Tổng tiền</label><input type="number" name="TotalPrice" id="invoiceTotalPriceNX" required></div></div>
    </form>
    <!-- Nút hành động -->
    <div class="ctrlstyle">
        <button type="submit" form="invoiceFormNX" name="them" class="btnstyle btnadd" id="submitButtonNX">Thêm / Sửa</button>
        <form method="POST" id="multiActionForm" style="display:inline;">
            <div id="multiHiddenInputs"></div>
            <button type="submit" name="sua_all" class="btnstyle btnedit"><i class="fa-solid fa-check"></i> Xác nhận tất cả</button>
            <button type="submit" name="xoa_all" class="btndel" onclick="return confirm('Bạn có chắc muốn xóa tất cả hóa đơn đã chọn?');"><i class="fa-solid fa-trash"></i> Xóa tất cả</button>
        </form>
    </div>

    <br>
    <div class="ctrlstyle">
        <input type="text" id="searchInputNX" class="searchbox" placeholder="Tìm theo tên..." title="Nhập tên để lọc danh sách hóa đơn">
    </div>

    <!-- Table hóa đơn -->
    <table class="tabstyle" id="invoiceTableNX">
        <thead>
        <tr>
            <th><input type="checkbox" id="selectAllNX" title="Chọn tất cả"></th>
            <th>ID</th><th>Name</th><th>Phone</th><th>Địa Chỉ</th><th>Ngày nhận</th><th>Giờ nhận</th>
            <th>Phương thức</th><th>Trạng thái</th><th>Tổng tiền</th><th>Ngày tạo</th><th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row=$result->fetch_assoc()): 
            $displayDateCreate = !empty($row['DateCreate']) ? date('Y-m-d', strtotime($row['DateCreate'])) : '';
            $displayDateReceive = !empty($row['DateReceive']) ? date('Y-m-d', strtotime($row['DateReceive'])) : '';
        ?>
        <tr data-id="<?= $row['ID'] ?>" 
            data-name="<?= htmlspecialchars($row['Name']) ?>" 
            data-phone="<?= htmlspecialchars($row['Phone']) ?>" 
            data-address="<?= htmlspecialchars($row['Address']) ?>" 
            data-datereceive="<?= $displayDateReceive ?>" 
            data-timereceive="<?= $row['TimeReceive'] ?>" 
            data-method="<?= htmlspecialchars($row['Method']) ?>" 
            data-total="<?= $row['TotalPrice'] ?>" 
            data-status="<?= $row['Status'] ?>"
            <?= $row['Status']==0 ? 'class="highlight-new"' : '' ?> 
            >
            <td><input type="checkbox" class="selectNX"></td>
            <td><?= $row['ID'] ?></td>
            <td><?= htmlspecialchars($row['Name']) ?></td>
            <td><?= htmlspecialchars($row['Phone']) ?></td>
            <td><?= htmlspecialchars($row['Address']) ?></td>
            <td><?= $displayDateReceive ?></td>
            <td><?= $row['TimeReceive'] ?></td>
            <td><?= htmlspecialchars($row['Method']) ?></td>
            <td><?= $row['Status']==1 ? '<i class="fa-solid fa-circle-check" style="color:lime"></i> Đã nhận' : '<i class="fa-solid fa-hourglass-half" style="color:red"></i> Đang xử lý' ?></td>
            <td><?= number_format($row['TotalPrice']) ?> VND</td>
            <td><?= $displayDateCreate ?></td>
            <td>
                <div class="btncolstyle">
                    <form method="POST" style="margin:0;">
                        <input type="hidden" name="ID" value="<?= $row['ID'] ?>">
                        <input type="hidden" name="Status" value="1">
                        <button type="submit" name="sua" class="btnedit" <?= $row['Status']==1?'disabled':'' ?>><i class="fa-solid fa-check"></i> Xác nhận</button>
                    </form>
                    <form method="POST" style="margin:0;">
                        <input type="hidden" name="ID" value="<?= $row['ID'] ?>">
                        <button type="submit" name="xoa" class="btndel" onclick="return confirm('Bạn có chắc muốn xóa?');"><i class="fa-solid fa-trash"></i> Xóa</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="js/update-invoice.js"></script>
</body>
</html>
