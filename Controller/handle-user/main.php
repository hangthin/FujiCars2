<?php
$n = isset($_GET["n"]) ? $_GET["n"] : "home";
switch ($n) 
{
	case "home": 
		include("./View/layout_user/home.php");
		break;
	case "login":
		include("./View/layout_user/login.php");
		break;
	case "forgot_password":
		include("./View/layout_user/forgot_password.php");
		break;
	case "change_password":
		include("./View/layout_user/change_password.php");
		break;
	case "otp":
		include("./View/layout_user/otp.php");
		break;
	case "logout":
		session_destroy();
		header("localtion: index.php?n=home");
		break;
	case "product":
		include("./View/layout_user/product.php");
		break;
	case "cart":
		include("./View/layout_user/cart.php");
		break;
	case "pay-now":
		include("./View/layout_user/pay-now.php");
		break;
	case "product-details":
		include("./View/layout_user/product-details.php");
		break;
	case "register":
		include("./View/layout_user/register.php");
		break;
	case"account":
		include("./View/layout_user/account.php");
		break;
	case"logout":
		include("./View/layout_admin/logout.php");
		break;
	case"introduce":
		include("./View/layout_user/introduce.php");
		break;
}
?>