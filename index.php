
<?php
session_start();              
ob_start();                

// Xử lý logout
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

if (isset($_SESSION["Quyen"]) && ($_SESSION["Quyen"] == "2" || $_SESSION["Quyen"] == "3"))
	{
   	include ("View/layout_admin/menutop.php");
	include ("Controller/handle-admin/main.php");
} else {
    
   //echo "Vào user"; 
	include ("View/layout_user/menutop.php");
	include ("Controller/handle-user/main.php");
	include ("View/layout_user/footer.php");
}
?>
