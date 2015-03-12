<html>
	<head>
		<link rel="stylesheet" type="text/css" href="styles/style.css">
		<link rel="stylesheet" type="text/css" href="styles/mystyle.css">
		<link rel="stylesheet" type="text/css" href="styles/style-slide.css">
		<link rel="stylesheet" href="styles/jquery-ui.css">
		<meta charset="utf-8">
		<script src="js/jquery-1.9.1.js"></script>
		<script src="js/jquery-ui.js"></script>
	    <link rel="stylesheet" href="/resources/demos/style.css">
	<style >
	</style>
	</head>

	<body>
	</body>
</html>

<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect ($con);
?>
<?php
function genid ($con){
	$year = date('y');
	$initial = "S".$year;

	$query = mysqli_query ($con, "SELECT ID_Number FROM person WHERE ID_Number LIKE '$initial%'");
	
	if (mysqli_num_rows($query)>0) {
		$greater_row = mysqli_fetch_array($query);
		while ($row = mysqli_fetch_array($query)) {
			if ($greater_row['ID_Number']<$row['ID_Number']){
				$greater_row = $row;
			}
		}
		$initial=$greater_row['ID_Number'];
		$num=$year.$initial[3].$initial[4].$initial[5] + 1;
		$num="S".$num;
		return $num;
	}
	else {
		$initial = $year."000" + 1;
		return "S".$initial;
	}
}

if (isset($_GET['delete'])){
	$id = $_GET['delete'];
	$query = "DELETE FROM person WHERE ID_Number ='$id'";
	mysqli_query($con,$query);
	echo "Deleted User: ".$id."<br>";
}

if (isset($_POST['add'])){
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$pass = $_POST['pass'];
	$cpass = $_POST['cpass'];
	$role = $_POST['role'];
	$dept = $_POST['dept'];
	$email = $_POST['email'];

	$a = explode('@', $email);
	$count = 0;
	$domain="";
	foreach ($a as $value) {
		if ($count==1)
			$domain = $value;
		$count++;
	}
	$check = true;

	if ($pass!=$cpass){
		echo "Password did not match!<br>";
		$check = false;
	}

	if ($email=="")
		$email = "none";
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "Not a valid email <br>";
        $check = false;
    }
	else if ($domain!="gmail.com"&&$domain!="adzu.edu.ph"){
		echo "Only google mail account can be used. <br>";
		$check = false;
	}

	$id = genid($con);

	if ($check==true){
		if (mysqli_query ($con, "INSERT INTO person (ID_Number, Password, First_Name, Last_Name, Email, Person_Type, Department_Name) VALUES ('$id', md5('$pass'), '$fname', '$lname', '$email', '$role', '$dept')")){
			echo "Added User: ".$id."<br>";
		}
	}
}
?>

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

	<div class="container" style="margin-top:125px;">
		<div class='form_inner'>
		<br>ADD USER
		<form method='POST' action='adduser.php'>
		First Name: <input type='text' name='fname' required>
		Last Name: <input type='text' name='lname' required> <br>
		Password: <input type='password' name='pass' required>
		Confirm Password: <input type='password' name='cpass' required> <br>
		Email: <input type='text' name='email'> <br>
		User Role: <select name='role'>
		<option value='Employee'> Employee </option>
		</select>
		Department Name:
		<select name='dept' >
			<?php
				$query = mysqli_query($con, "SELECT department FROM department_list ORDER BY department");
				while ($row = mysqli_fetch_array($query)){
					echo "<option value='".$row['department']."'>".$row['department']."</option>";
				} 
			?>
		</select>
		<br><br>
		<input type='submit' name='add' id ='submit' class="add ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
		<a href="viewuser.php" class="see_more" style="float:left; margin-left:10px">View Users</a>
		<a href="assignuser.php" class="see_more" style="float:left; margin-left:20px">Assign Users</a>
		</form>
		</div>
	</div>
</div>
?>