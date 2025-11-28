<?php
session_start();
include "../../Controller/config/config.php";

$userName = $userPhone = $userAddress = '';

if (isset($_SESSION['user_id'])) {
    $MaTK = $_SESSION['user_id'];
    $sql = "SELECT TenTK, phone, DiaChi FROM nguoidung WHERE MaTK = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $MaTK);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $userName = $row['TenTK'];
        $userPhone = $row['phone'];
        $userAddress = $row['DiaChi'];
    }
    $stmt->close();
}
// Lấy danh sách ID sản phẩm từ URL (?n=1,2,3)
$idsParam = $_GET['n'] ?? ($_GET['MaSP'] ?? '');
if (empty($idsParam)) {
    echo "<script>alert('Không có sản phẩm nào được chọn!'); window.location.href='../../cart.php';</script>";
    exit;
}

$idList = array_filter(array_map('intval', explode(',', $idsParam)));

// Lấy giỏ hàng trong session
$cart = $_SESSION['cart'] ?? [];

// Tạo danh sách sản phẩm cần thanh toán
$cartItems = [];
$tongTien = 0;

foreach ($idList as $id) {
    if (isset($cart[$id])) {
        $item = $cart[$id];
        $item['ThanhTien'] = $item['Gia'] * $item['SoLuong'];
        $tongTien += $item['ThanhTien'];
        $cartItems[] = $item;
    }
}

// Nếu không có sản phẩm hợp lệ, truy vấn trực tiếp DB
if (empty($cartItems)) {
    foreach ($idList as $id) {
        $sql = "SELECT ID, TenSP, Gia, HinhAnh FROM sanpham WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $soluong = intval($_GET['SoLuong'] ?? 1);
            $row['SoLuong'] = $soluong;
            $row['ThanhTien'] = $row['Gia'] * $soluong;
            $cartItems[] = $row;
            $tongTien += $row['ThanhTien'];
        }
    }
    if (empty($cartItems)) {
        echo "<script>alert('Không tìm thấy sản phẩm!'); window.location.href='../../index.php';</script>";
        exit;
    }
}

// Chuyển giỏ hàng sang JSON để gửi sang payment_online.php
$cartJson = json_encode($cartItems);

// Lấy thông tin người dùng nếu đã đăng nhập
$userName = $userPhone = $userAddress = '';
if (isset($_SESSION['user_id'])) {
    $MaTK = $_SESSION['user_id'];
    $sqlUser = "SELECT TenTK, phone, DiaChi FROM nguoidung WHERE MaTK = ?";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->bind_param("s", $MaTK);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();
    if ($rowUser = $resultUser->fetch_assoc()) {
        $userName = $rowUser['TenTK'];
        $userPhone = $rowUser['phone'];
        $userAddress = $rowUser['DiaChi'];
    }
    $stmtUser->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thanh toán giỏ hàng</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<style>
body { font-family: "Segoe UI", sans-serif; margin:0; padding:40px 20px; background:#f5f5f5; color:#333; }
.container { max-width:900px; margin:auto; background:#fff; padding:35px; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.1); }
h2 { text-align:center; color:#d10000; font-size:26px; margin-bottom:30px; text-transform:uppercase; }
.product-list { margin-bottom:30px; }
.product-item { display:flex; gap:20px; padding:15px; background:#fafafa; border-radius:10px; margin-bottom:15px; align-items:center; }
.product-item img { width:100px; border-radius:10px; object-fit:cover; }
.product-info { flex:1; }
.product-info h3 { margin:0; font-size:18px; }
.product-info p { margin:4px 0; font-size:14px; }
.total-price { font-size:20px; font-weight:bold; color:#d10000; text-align:right; margin-top:15px; }
.form-group { margin-top:15px; }
.form-group label { font-weight:bold; display:block; margin-bottom:6px; }
.form-group input, .form-group select, .form-group textarea { width:100%; padding:10px; border-radius:6px; border:1px solid #ccc; font-size:15px; }
.btn-submit { background:#d10000; color:#fff; border:none; padding:14px; border-radius:10px; font-weight:bold; font-size:16px; width:100%; cursor:pointer; margin-top:20px; transition:0.3s; }
.btn-submit:hover { background:#a50000; }
.payment-info { display:none; margin-top:20px; padding:20px; border:1px solid #ccc; border-radius:8px; background:#f9f9f9; }
.payment-info img { width: 180px; height: 180px; margin-bottom: 15px; display: block; }
.payment-info p { margin:6px 0; }
/* Overlay nền mờ */
.fx-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.4);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

/* Hộp thông báo */
.fx-message {
    background: #fffdf6;  /* nền sáng, ấm áp */
    padding: 40px 50px;
    border-radius: 16px;
    text-align: center;
    color: #333;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    transform: scale(0.5);
    opacity: 0;
    transition: transform 0.5s ease, opacity 0.5s ease;
}

/* Khi show popup */
.fx-message.show {
    transform: scale(1);
    opacity: 1;
}

/* Loading spinner vòng tròn */
.fx-message i.spinner {
    display: block;
    margin: 0 auto;
    width: 60px; height: 60px;
    border: 6px solid #f3f3f3;
    border-top: 6px solid #d10000;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Animation xoay */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Icon thành công */
.fx-message i.success {
    color: #28a745; /* xanh tươi */
    font-size: 70px;
    display: block;
    margin: 0 auto;
    animation: pop 0.6s ease forwards;
}

/* Nhún popup */
@keyframes pop {
    0% { transform: scale(0); }
    50% { transform: scale(1.5); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); }
}

/* Thông báo chữ */
.fx-message p {
    margin-top: 20px;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.form-group {
  margin-top: 15px;
  color: #000; /* chữ đen */
}

</style>
</head>
<body>
<div class="container">
    <h2>Thanh toán giỏ hàng</h2>
    <div class="product-list">
        <?php foreach ($cartItems as $item): ?>
        <div class="product-item">
            <img src="../img/SP/<?php echo htmlspecialchars($item['HinhAnh']); ?>" alt="">
            <div class="product-info">
                <h3><?php echo htmlspecialchars($item['TenSP']); ?></h3>
                <p>Giá: <?php echo number_format($item['Gia'],0,',','.'); ?> VNĐ</p>
                <p>Số lượng: <?php echo $item['SoLuong']; ?></p>
                <p><b>Thành tiền:</b> <?php echo number_format($item['ThanhTien'],0,',','.'); ?> VNĐ</p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="total-price">Tổng cộng: <?php echo number_format($tongTien,0,',','.'); ?> VNĐ</div>
    <form id="orderForm">
        <input type="hidden" name="TongTien" value="<?php echo $tongTien; ?>">
        <input type="hidden" name="cartData" value='<?php echo htmlspecialchars($cartJson, ENT_QUOTES); ?>'>
        <?php foreach ($cartItems as $item): ?>
            <input type="hidden" name="MaSP[]" value="<?php echo $item['ID']; ?>">
            <input type="hidden" name="SoLuong[]" value="<?php echo $item['SoLuong']; ?>">
        <?php endforeach; ?>

<div class="form-group" style="background:#fff4f4; padding:15px; border-radius:8px; border:1px solid #d10000;">
    <p><b>Họ và tên:</b> <?php echo htmlspecialchars($userName ?: $_SESSION['TenTK'] ?? 'Chưa có'); ?></p>
    <p><b>Số điện thoại:</b> <?php echo htmlspecialchars($userPhone ?: $_SESSION['phone'] ?? 'Chưa có'); ?></p>
    <p><b>Địa chỉ:</b> <?php echo htmlspecialchars($userAddress ?: $_SESSION['DiaChi'] ?? 'Chưa có'); ?></p>
</div>
        <div class="form-group">
            <label>Phương thức thanh toán</label>
            <select name="method" id="paymentMethod" required>
                <option value="">Chọn phương thức</option>
                <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                <option value="BANK">Chuyển khoản ngân hàng</option>
                <option value="MOMO">Momo</option>
                <option value="VNPAY">VN Pay</option>
                <option value="ZALOPAY">Zalo Pay</option>
            </select>
        </div>
        <button type="submit" class="btn-submit">Xác nhận đặt hàng</button>
    </form>
</div>

<div class="fx-overlay" id="fxOverlay">
    <div class="fx-message">
        <i class="fas fa-check-circle success" id="fxIcon"></i>
        <p id="fxText">Đặt hàng thành công!</p>
    </div>
</div>

<script>
const onlineMethods = ["BANK", "MOMO", "VNPAY", "ZALOPAY"];

document.getElementById('orderForm').addEventListener('submit', function(e){
    e.preventDefault();

    const form = this;
    const method = form.method.value;
    const overlay = document.getElementById('fxOverlay');
    const icon = document.getElementById('fxIcon');
    const text = document.getElementById('fxText');

    // Nếu online -> chuyển trang
    if (onlineMethods.includes(method)) {
        form.action = "payment_online.php";
        form.method = "POST";
        if (!form.querySelector('input[name="is_online"]')) {
            let mk = document.createElement('input');
            mk.type = "hidden"; mk.name = "is_online"; mk.value = "1";
            form.appendChild(mk);
        }
        form.submit();
        return;
    }

    // Hiển thị overlay và spinner
    overlay.style.display = "flex";
    icon.className = "spinner";
    text.textContent = "Đang xử lý đơn hàng...";
    document.querySelector('.fx-message').classList.remove('show');

    fetch('../../Controller/handle-admin/process_pay-now.php', {
        method: "POST",
        body: new FormData(form)
    })
    .then(res => res.text())
    .then(result => {
        if (result.trim().toLowerCase() === "success") {
            icon.className = "fas fa-check-circle success";
            text.textContent = "Đặt hàng thành công!";
            document.querySelector('.fx-message').classList.add('show'); // bật hiệu ứng pop
            form.reset();
            setTimeout(() => {
                overlay.style.display = "none";
                window.location.href = "../../index.php";
            }, 2500);
        } else {
            icon.className = "fas fa-exclamation-triangle";
            text.textContent = "⚠️ Lỗi từ máy chủ: " + result;
            document.querySelector('.fx-message').classList.add('show');
            setTimeout(() => overlay.style.display = "none", 3000);
        }
    })
    .catch(() => {
        icon.className = "fas fa-exclamation-triangle";
        text.textContent = "❌ Không thể kết nối máy chủ!";
        document.querySelector('.fx-message').classList.add('show');
        setTimeout(() => overlay.style.display = "none", 3000);
    });
});

</script>
</body>
</html>
