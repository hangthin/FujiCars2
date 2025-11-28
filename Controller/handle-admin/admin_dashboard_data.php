<?php
// admin_dashboard_data.php
include("Controller/config/config.php");
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Lấy lựa chọn khoảng thời gian thống kê
$range = $_GET['range'] ?? 'month';
$labels = [];
$values = [];

// Tính toán dữ liệu biểu đồ
switch($range){
    case 'day':
        for($i=6;$i>=0;$i--){
            $d = new DateTime("-$i day");
            $labels[] = $d->format('d/m');
            $start = $d->format('Y-m-d 00:00:00');
            $end = $d->format('Y-m-d 23:59:59');
            $sum = $conn->query("SELECT SUM(TotalPrice) AS s FROM hoadon WHERE DateCreate BETWEEN '$start' AND '$end'")->fetch_assoc()['s'] ?? 0;
            $values[] = (float)$sum;
        }
        break;
    case 'week':
        for($i=5;$i>=0;$i--){
            $d = new DateTime();
            $d->modify("-$i week");
            $week = $d->format("W");
            $year = $d->format("Y");
            $labels[] = "Tuần $week/$year";
            $monday = new DateTime();
            $monday->setISODate($year, $week);
            $sunday = clone $monday;
            $sunday->modify("+6 days");
            $start = $monday->format('Y-m-d 00:00:00');
            $end = $sunday->format('Y-m-d 23:59:59');
            $sum = $conn->query("SELECT SUM(TotalPrice) AS s FROM hoadon WHERE DateCreate BETWEEN '$start' AND '$end'")->fetch_assoc()['s'] ?? 0;
            $values[] = (float)$sum;
        }
        break;
    case 'year':
        for($i=4;$i>=0;$i--){
            $y = date('Y') - $i;
            $labels[] = $y;
            $sum = $conn->query("SELECT SUM(TotalPrice) AS s FROM hoadon WHERE YEAR(DateCreate)=$y")->fetch_assoc()['s'] ?? 0;
            $values[] = (float)$sum;
        }
        break;
    case 'month':
    default:
        for($i=5;$i>=0;$i--){
            $d = new DateTime("first day of -{$i} month");
            $ym = $d->format('Y-m');
            $labels[] = $d->format('m/Y');
            $sum = $conn->query("SELECT SUM(TotalPrice) AS s FROM hoadon WHERE DATE_FORMAT(DateCreate,'%Y-%m')='$ym'")->fetch_assoc()['s'] ?? 0;
            $values[] = (float)$sum;
        }
        break;
}

// Đếm tổng
$sanpham = $conn->query("SELECT COUNT(*) AS c FROM sanpham")->fetch_assoc()['c'] ?? 0;
$nguoidung = $conn->query("SELECT COUNT(*) AS c FROM nguoidung")->fetch_assoc()['c'] ?? 0;
$dangky = $conn->query("SELECT COUNT(*) AS c FROM dangkilaithe")->fetch_assoc()['c'] ?? 0;
$thongso = $conn->query("SELECT COUNT(*) AS c FROM thongsokithuat")->fetch_assoc()['c'] ?? 0;
$q_hd = $conn->query("SELECT COUNT(*) AS c, SUM(TotalPrice) AS s FROM hoadon");
$row_hd = $q_hd->fetch_assoc() ?? ['c'=>0,'s'=>0];
$sohoadon = $row_hd['c'];
$doanhthu = $row_hd['s'];

// Dữ liệu bảng
$orders = $conn->query("
  SELECT DateCreate AS NgayTao, TotalPrice, Status AS TrangThai
  FROM hoadon
  ORDER BY DateCreate DESC
  LIMIT 6
");

$users = $conn->query("
  SELECT TenTK AS HoTen, email AS Email, NgayCapNhat AS NgayTao
  FROM nguoidung
  ORDER BY NgayCapNhat DESC
  LIMIT 6
");
?>
