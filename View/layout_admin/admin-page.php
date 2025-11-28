<?php
include "Controller/handle-admin/admin_dashboard_data.php";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<!-- Icons + Animation + Styles -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="View/css/styleCss.css">

<meta charset="UTF-8" />
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width,initial-scale=1" />
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>
<body>

<!-- LOADING ANIMATION -->
<div id="loadingOverlay">
  <div class="car-wrapper">
    <i class="fas fa-car-side car-icon"></i>
    <div class="smoke"></div>
    <div class="smoke smoke2"></div>
    <div class="smoke smoke3"></div>
  </div>
</div>

<!-- include socket.io client -->
<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
<!-- CHATBOX ICON -->
<div id="orderChatbox">
    <i class="fa-solid fa-comment-dots chat-icon"></i>
    <div class="badge" id="orderBadge">1</div>
</div>

<!-- NOTIFICATION -->
<div id="orderNotification">
    <span id="orderCount">Bạn có 1 đơn hàng mới!</span> 
    <span id="viewDetail">Chi tiết</span>
</div>

<!-- POPUP -->

<!-- load your admin JS after socket.io -->













<!-- ================= DASHBOARD ================= -->
<div class="container">
<h1>DASHBOARD ADMIN</h1>

<!-- ===== STATS ===== -->
<div class="stats-wrapper">
  <div class="stat-item">
    <div class="icon"><i class="fa-solid fa-users"></i></div>
    <div class="label">Tổng người dùng</div>
    <div class="value"><?= number_format($nguoidung) ?> ND</div>
    <div class="desc">Tổng số tài khoản người dùng</div>
    <a class="btn-detail" href="?n=update-user">Chi tiết</a>
  </div>

  <div class="stat-item">
    <div class="icon"><i class="fa-solid fa-box-open"></i></div>
    <div class="label">Tổng sản phẩm</div>
    <div class="value"><?= number_format($sanpham) ?> SP</div>
    <div class="desc">Sản phẩm đang có trong kho</div>
    <a class="btn-detail" href="?n=update-product">Chi tiết</a>
  </div>

  <div class="stat-item">
    <div class="icon"><i class="fa-solid fa-cart-shopping"></i></div>
    <div class="label">Tổng đơn hàng</div>
    <div class="value"><?= number_format($sohoadon) ?> Đơn</div>
    <div class="desc">Doanh thu: <?= number_format($doanhthu,0,',','.') ?> đ</div>
    <a class="btn-detail" href="?n=update-invoice">Chi tiết</a>
  </div>

  <div class="stat-item">
    <div class="icon"><i class="fa-solid fa-car-side"></i></div>
    <div class="label">Đăng ký lái thử</div>
    <div class="value"><?= number_format($dangky) ?> Lượt</div>
    <div class="desc">Yêu cầu lái thử</div>
    <a class="btn-detail" href="?n=register_test-drive">Chi tiết</a>
  </div>

  <div class="stat-item">
    <div class="icon"><i class="fa-solid fa-gears"></i></div>
    <div class="label">Thông số kỹ thuật</div>
    <div class="value"><?= number_format($thongso) ?> Mục</div>
    <div class="desc">Mục thông số xe</div>
    <a class="btn-detail" href="?n=technical_specifications">Chi tiết</a>
  </div>
</div>

<!-- ===== CHART ===== -->
<div class="chart-area">
  <div class="chart-card">
    <div style="font-weight:800;color:var(--main-red);font-size:18px">Thống kê doanh thu</div>

    <form id="rangeForm" method="get">
    <div class="range-wrapper">
      <label for="range-select">Chọn khoảng thời gian:</label>
      <select name="range" id="range-select" onchange="document.getElementById('rangeForm').submit();">
          <option value="day"   <?= $range=='day'?'selected':'' ?>>7 ngày gần nhất</option>
          <option value="week"  <?= $range=='week'?'selected':'' ?>>6 tuần gần nhất</option>
          <option value="month" <?= $range=='month'?'selected':'' ?>>6 tháng gần nhất</option>
          <option value="year"  <?= $range=='year'?'selected':'' ?>>5 năm gần nhất</option>
      </select>
    </div>
    </form>

    <canvas id="chart" height="160"></canvas>
  </div>

  <div class="right-widgets">
    <div class="card" style="padding:12px;">
      <div style="font-size:13px;color:black;margin-bottom:8px">Tổng doanh thu</div>
      <div style="font-weight:800;color:var(--main-red);font-size:18px"><?= number_format($doanhthu,0,',','.') ?> đ</div>
      <div style="font-size:12px;color:black;margin-top:8px">Số liệu cộng dồn</div>
    </div>

    <div class="card" style="padding:12px;">
      <div style="font-size:13px;color:black;margin-bottom:8px">Khách hàng mới</div>
      <div style="font-weight:800;color:var(--main-red);font-size:18px"><?= number_format($nguoidung) ?></div>
      <div style="font-size:12px;color:black;margin-top:8px">Tính đến hiện tại</div>
    </div>
  </div>
</div>

<!-- ===== TABLE ===== -->
<div class="tables">
  <div class="table-card">
    <h3>Tình trạng đơn hàng</h3>
    <div class="table-inner">
      <table>
      <thead>
        <tr><th>Ngày</th><th>Tổng</th><th>Trạng thái</th></tr>
      </thead>
      <tbody>
        <?php if($orders && $orders->num_rows):while($o=$orders->fetch_assoc()):?>
        <tr>
          <td><?= date('d/m/Y',strtotime($o['NgayTao'])) ?></td>
          <td><?= number_format($o['TotalPrice'],0,',','.') ?> đ</td>
          <td>
            <?php if ($o['TrangThai'] == 1): ?>
                <i class="fa-solid fa-circle-check" style="color:green;"></i> Đã nhận
            <?php else: ?>
                <i class="fa-solid fa-hourglass-half" style="color:orange;"></i> Đang xử lý
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="3">Không có đơn hàng</td></tr>
        <?php endif;?>
      </tbody>
      </table>
    </div>
  </div>

  <div class="table-card">
    <h3>Khách hàng mới</h3>
    <div class="table-inner">
      <table>
      <thead>
        <tr><th>Họ tên</th><th>Email</th><th>Ngày tạo</th></tr>
      </thead>
      <tbody>
        <?php if($users && $users->num_rows):while($u=$users->fetch_assoc()):?>
        <tr>
          <td><?= htmlspecialchars($u['HoTen']) ?></td>
          <td><?= htmlspecialchars($u['Email']) ?></td>
          <td><?= date('d/m/Y',strtotime($u['NgayTao'])) ?></td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="3">Không có người dùng</td></tr>
        <?php endif;?>
      </tbody>
      </table>
    </div>
  </div>
</div>

<!-- DỮ LIỆU CHART -->
<script>
window.chartData = {
    labels: <?= json_encode($labels) ?>,
    values: <?= json_encode($values, JSON_NUMERIC_CHECK) ?>
};
</script>

<!-- DASHBOARD JS (bao gồm realtime) -->
<script src="js/admin_dashboard.js"></script>
<script src="js/update-invoice.js"></script>
<script src="js/check_new_oder.js"></script>

<!-- LOADING JS -->
<script><?php include "js/car_loading.js"; ?></script>

</body>
</html>
