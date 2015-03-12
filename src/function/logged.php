<?php
//error_reporting(0);
session_start();
if (!isset($_SESSION['isLogged'])||$_SESSION['isLogged']==0)
	header("location:login.php");

function redirect ($con){
	$id = $_SESSION['user'];
	$query = mysqli_query ($con, "SELECT role FROM user_role WHERE ID_Number='$id'");
	$row = mysqli_fetch_array ($query);
	if (mysqli_num_rows($query)>0){
		if ($row['role']!="SAdmin"&&$row['role']!="Admin")
			header("location:profile.php");
	}
	else 
		header("location:profile.php");
}
?>