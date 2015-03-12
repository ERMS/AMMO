<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect($con);
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/mystyle.css">
	<link rel="stylesheet" type="text/css" href="styles/style-slide.css">
</head>
<body>

<div class="header-cont header"> 
<img class="center-logo " src="images/logo.png">

</div>

		<div style="margin: 280px 220px 0 220px; text-align:center">	
			
			<ul id="navlist">
			 <li id="add" class="transition"><a href="add.php"></a>  <p class="label">Adding Record: Outgoing, Incoming</p></li>
			 <li id="search" class="transition" ><a href="search.php"></a> <p class="label">Search, Edit and  Delete  Record/s </p></li>
			 <li id="profile" class="transition"><a href="profile.php"></a><p class="label" >View Transaction <br><br></p></li>
			 <li id="adduser" class="transition"> <a href="adduser.php"></a><p class="label">Add User <br><br></p></li>
			</ul>
		</div>


<div class="footer">
	

</div>

</body>
</html>
