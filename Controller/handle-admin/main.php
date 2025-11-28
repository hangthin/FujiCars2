<?php
$n = isset($_GET["n"]) ? $_GET["n"] : "admin-page";
switch ($n) 
{
	case "admin-page": 
		include("./View/layout_admin/admin-page.php");
		break;
	case "logout":
		session_start();
		session_destroy(); // Xóa toàn bộ session
		header("Location: index.php"); // Quay lại trang chủ
	exit();
	case "logout":
		session_destroy();
		header("localtion: index.php?n=home");
		break;
	case "product":
		include("./View/layout_user/product.php");
		break;
	case "update-user":
		include("./View/layout_admin/update-user.php");
		break;
	case "cart":
		include("./View/layout_admin/cart.php");
		break;
	case "pay-now":
		include("./View/layout_user/pay-now.php");
		break;
	case "product-details":
		include("./View/layout_user/product-details.php");
		break;
	case "add-product":
		include("./View/layout_admin/add-product.php");
		break;
	case "add-user":
		include("./View/layout_admin/add-user.php");
		break;
	case "list-user":
		include("./View/layout_admin/list-user.php");
		break;
	case "update-product":
		include("./View/layout_admin/update-product.php");
		break;
    case "update-invoice":
        include("./View/layout_admin/update-invoice.php");
        break;
	case "register_test-drive":
		include("./View/layout_admin/register_test-drive.php");
		break;
	case "menutop":
		include("./View/layout_admin/menutop.php");
		break;
	case "technical_specifications":
		include("./View/layout_admin/technical_specifications.php");
		break;
	case "product_rating":
		include("./View/layout_admin/product_rating.php");
		break;
	case "list_product":
		include("./View/layout_admin/list_product.php");
		break;	
	case "test-drive_status":
		include("./View/layout_admin/test-drive_status.php");
		break;
	case "car_warehouse":
		include("./View/layout_admin/car_warehouse.php");
		break;
	case"transport":
		include("./View/layout_admin/transport.php");
		break;
	case"revenue":
		include("./View/layout_admin/revenue.php");
		break;

}
?> 