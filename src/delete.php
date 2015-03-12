<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect($con);
if (!isset($_GET['Mail_ID'])){
	header("location:search.php");
	exit();
}
	foreach ($_GET['Mail_ID'] as $value) {
		$query = "DELETE FROM mail WHERE Mail_ID ='$value'";
		mysqli_query($con,$query);
	}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/mystyle.css">
	<link rel="stylesheet" type="text/css" href="styles/style-slide.css">
</head>
<body>

<div class="header-cont-small header-small"> 
<img style="float:left; margin-left:80px;" class="center-logo" src="images/logo150.png">
</div>
<div id="nav-right">
	<ul id="right-nav">
	<img class="img-nav" src="images/home.png" width="45px">
	<li><a style="margin-left:40px; " href="index.php">HOME</a></li>
	<img class="img-nav" style="top:55px;" src="images/add.png" width="45px">
	<li ><a  style="margin-left:30px;"href="add.php">ADD</a></li>
	<img class="img-nav" style="top:110px;" src="images/search.png" width="45px">
	<li><a style="margin-left:40px" href="search.php">SEARCH</a></li>
	<img class="img-nav" style="top:165px;" src="images/profile.png" width="45px">
	<li><a style="margin-left:40px" href="profile.php">PROFILE</a></li>
	<img class="img-nav" style="top:220px;" src="images/logout.png" width="45px">
	<li><a style="margin-left:40px" href="profile.php?log=out">LOGOUT</a></li>
	</ul>
</div>
<div style=" position:relative; width:400px; display:block; margin: 0 auto;">
	<div class="container" style="margin-top:150px;">
		<h3 id="delete" style="text-align:center;">Data Has Been Deleted!</h3>
		<a class='see_more' href="index.php" style="float:right;"> Back to Home </a>
		<br/>
	</div>
</div>
<div class="footer"></div>
</body>
</html>