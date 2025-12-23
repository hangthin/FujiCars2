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
<link rel="stylesheet" href="View/css/styleCss.css">
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
       <a href="?n=product-type">Product Type</a> 
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
