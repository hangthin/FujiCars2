<?php
include 'Controller/config/config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ZoraCars Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
/* ==================== SIDEBAR ==================== */
.zora-sidebar {
  background: black;
  width: 55px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  padding-top: 10px;
  overflow-x: hidden;
  transition: width 0.3s ease;
  z-index: 100;
}

.zora-sidebar:hover { width: 200px; }

/* LOGO */
.zora-logo {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 10px;
  transition: all 0.3s ease;
  overflow: hidden;
}
.zora-logo img {
  width: 40px;
  max-width: 160px;
  height: auto;
  object-fit: contain;
  transition: all 0.3s ease;
}

/* Khi hover sidebar */
.zora-sidebar:hover .zora-logo img {
  width: 160px; /* phóng to logo khi hover */
}

/* MENU */
.zora-menu {
  display: flex;
  flex-direction: column;
  width: 100%;
  margin-top: 5px;
}

/* LINK CƠ BẢN */
.zora-menu a, .zora-drop > a {
  color: #e0e0e0;
  text-decoration: none;
  font-size: 13px;
  height: 45px;
  display: flex;
  align-items: center;
  position: relative;
  transition: all 0.3s ease;
  border-left: 3px solid transparent;
  overflow: hidden;
  padding: 0 10px;
}

/* ICON CỐ ĐỊNH */
.zora-menu a i, .zora-drop > a i.fa-caret-down {
  font-size: 18px;
  width: 35px; /* giữ icon cố định vị trí */
  text-align: center;
  transition: color 0.3s ease;
}

/* TEXT ẨN / HIỆN */
.zora-menu a span, .zora-drop > a span {
  opacity: 0;
  transform: translateX(-10px);
  white-space: nowrap;
  transition: all 0.3s ease;
}

/* Khi hover sidebar => hiện text mượt */
.zora-sidebar:hover .zora-menu a span,
.zora-sidebar:hover .zora-drop > a span {
  opacity: 1;
  transform: translateX(0);
}

/* DROPDOWN ICON */
.zora-drop > a i.fa-caret-down {
  margin-left: auto;
  opacity: 0;
  transition: opacity 0.3s ease;
}
.zora-sidebar:hover .zora-drop > a i.fa-caret-down {
  opacity: 0.8;
}

/* DROPDOWN */
.zora-drop-content {
  display: none;
  flex-direction: column;
  background: #141414;
}
.zora-drop-content a {
  padding: 10px 30px;
  font-size: 12px;
  color: #ccc;
  border-left: 3px solid transparent;
}
.zora-drop-content a:hover {
  background: rgba(229,57,53,0.15);
  color: #fff;
  border-left: 3px solid #e53935;
}
.zora-drop:hover .zora-drop-content { display: flex; }

/* HOVER HIỆU ỨNG */
.zora-menu a:hover {
  background: rgba(229,57,53,0.15);
  color: #fff;
  border-left: 3px solid #e53935;
}


</style>
</head>
<body>
<div class="zora-sidebar">
  <div class="zora-logo">
    <img src="View/img/logo.png" alt="Logo FujiCars">
  </div>
  <div class="zora-menu">
    <a href="index.php"><i class="fa fa-home"></i><span>Home</span></a>
     <a href="?n=revenue"><i class="fa fa-line-chart"></i><span>Revenue</span></a>
    <a href="?n=transport"><i class="fa fa-truck"></i><span>Transport</span></a>
    <div class="zora-drop">
       <a href="?n=update-user"><i class="fa fa-user"></i><span>User</span></a>
      <div class="zora-drop-content">
        <a href="?n=add-user">Add User</a>
        <a href="?n=list-user">List User</a>
      </div>
    </div>
    <div class="zora-drop">
      <a href="?n=product"><i class="fa fa-car"></i><span>Product</span><i class="fa fa-caret-down"></i></a>
      <div class="zora-drop-content">
        <a href="?n=add-product">Add Product</a>
        <a href="?n=list_product">List Product</a>
      </div>
    </div>
    <a href="?n=product_rating"><i class="fa fa-file-text"></i><span>Product Rating</span></a>
    <a href="?n=test-drive_status"><i class="fa fa-tachometer"></i><span>Test Drive Status</span></a>
    <a href="?n=car_warehouse"><i class="fa fa-warehouse"></i><span>Car Warehouse</span></a>
    <a href="?n=cart"><i class="fa fa-shopping-cart"></i><span>Cart</span></a>
    <a href="?n=logout"><i class="fa fa-sign-out"></i><span>Logout</span></a>
  </div>
</div>
</body>
</html>
