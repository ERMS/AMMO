<?php
include 'function/database.php';
$con = amodb();
error_reporting(0);
session_start();
if (isset($_SESSION['isLogged'])&&$_SESSION['isLogged']==1)
		header("location:index.php");
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/mystyle.css">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body style="background-color: rgb(186, 213, 244);">


<div class="form_container" style="margin-top:200px;">
<div style="position:absolute; margin: -120px 120px 0 120px "> <img class="center-logo" src="images/logo150.png"></div>
	<form action='login.php' method='POST'>
		<div class="form_inner" style="padding:5px; ">
			<h2>Log in</h2>
			<?php
			if (isset($_POST['logname'])&&isset($_POST['logpass'])){
				$id=$_POST['logname'];
				$pass = $_POST['logpass'];
				
				$query = mysqli_query ($con, "SELECT id_number FROM person WHERE id_number='$id'");
				if (mysqli_num_rows($query)>0){
					;
				}
				else {
					$con2=	adzudb ();
					$query2 = mysqli_query ($con2, "SELECT * FROM person WHERE id_number='$id'");
					$row = mysqli_fetch_array($query2);
					
					$id_num =$row['ID_Number']; $pass=$row['Password']; $email=$row['Email']; $first=$row['First_Name']; $last=$row['Last_Name']; $type=$row['Person_Type']; $dept=$row['Department_Name'];
					if (mysqli_num_rows($query2)>0)
						mysqli_query ($con, "INSERT INTO person (ID_Number, Password, Email, First_Name, Last_Name, Person_Type, Department_Name) VALUES ('$id_num', '$pass', '$email', '$first', '$last', '$type', '$dept')");
	
					mysqli_close ($con2);
				}
				
				$query=mysqli_query ($con, "SELECT * FROM person WHERE id_number='$id' AND password=md5('$pass')");
				if (mysqli_num_rows($query)>0) {
					$_SESSION['isLogged'] = 1;
					$_SESSION['user'] = $id;
					$query = mysqli_query($con, "SELECT * FROM user_activity WHERE id_number='$id'");
					if (mysqli_num_rows($query)>0){
						mysqli_query ($con, "UPDATE user_activity SET isLogged = 1 WHERE id_number='$id'");

					}
					else {
						mysqli_query ($con,"INSERT INTO user_activity (id_number, isLogged) VALUES ((SELECT id_number FROM person WHERE id_number='$id'),1)");

					}
					header("location:index.php");
				}
				else {
					echo " <div style='text-align:center; background-color:rgba(253, 228, 213, 0.65); height:25px; padding-top:2px;  padding-left:10px; border:red 2px solid; color:red; top:0;'> Wrong username or password! </div>";
				}
			}
			?>
			<div style="margin-top:15px;">
			<input type="text" name='logname' style="border-bottom-left-radius:0px; border-bottom-right-radius:0px; height:50px; font-size: 18px;" placeholder="Username" autofocus required>
			<input type="password" name='logpass' style=" margin-top: 5px; border-top-left-radius:0px; border-top-right-radius:0px;height:50px; font-size: 18px;" required placeholder="Password"> <br/><br/>
			<input type="submit" style=" margin-top: 5px; float:right; cursor:pointer; " value="Login"> <br/><br/>
			</div>
			
		</div>
	</form>
</div>

</body>
</html>