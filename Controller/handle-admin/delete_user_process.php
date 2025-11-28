<?php

	include("Controller/config/config.php");
	// Get the user ID from the POST request
	$userId = $_POST['id'];
	// Query to delete the user from the database
	$sql= "DELETE FROM nguoidung WHERE ID = '$userId'";
	if (mysqli_query($conn, $sql)) 
	{
	echo "Người dùng đã được xóa thành công!";
	}
	else 
	{
	echo "Lỗi khi xóa người dùng: " . mysqli_error($conn);
	}
	
	
	
	
	
	
?>