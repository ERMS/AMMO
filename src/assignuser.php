<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect ($con);
?>
<?php
if (isset($_GET['assign'])){
	$id = $_GET['id'];
	$role = $_GET['role'];
	$query = mysqli_query ($con, "SELECT id_number FROM person WHERE id_number='$id'");
	if (mysqli_num_rows($query)<=0){
		$con2=	adzudb ();
		$query2 = mysqli_query ($con2, "SELECT * FROM person WHERE id_number='$id'");
		$row = mysqli_fetch_array($query2);
		
		$id_num =$row['ID_Number']; $pass=$row['Password']; $email=$row['Email']; $first=$row['First_Name']; $last=$row['Last_Name']; $type=$row['Person_Type']; $dept=$row['Department_Name'];
		mysqli_query ($con, "INSERT INTO person (ID_Number, Password, Email, First_Name, Last_Name, Person_Type, Department_Name) VALUES ('$id_num', '$pass', '$email', '$first', '$last', '$type', '$dept')");
	
		mysqli_close ($con2);
	}

	$query = mysqli_query($con, "SELECT ID_Number FROM user_role WHERE ID_Number='$id'");
	if (mysqli_num_rows($query)>0){
		mysqli_query($con,"UPDATE user_role SET role='$role' WHERE ID_Number='$id'");
		echo "User ".$id." is now a/an".$role.". <br>";
	}
	else{
		mysqli_query($con,"INSERT INTO user_role (ID_Number,role) VALUES ((SELECT ID_Number FROM person WHERE ID_Number='$id'), '$role')");
		echo "User ".$id." is now a/an ".$role.".";
	}
}
if (isset($_GET['delete'])){
	$id = $_GET['delete'];
	$query = "DELETE FROM user_role WHERE ID_Number ='$id'";
	mysqli_query($con,$query);
	echo "Deleted User: ".$id." as authorized user. <br>";
}
?>

<html>
<head>
	<title></title>
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


<div style=" position:relative; width:700px; display:block; margin: 0 auto;">

	<div class="container" style="margin-top:125px;">
		<?php
		$id = $_SESSION['user'];
		$query = mysqli_query ($con, "SELECT role FROM user_role WHERE ID_Number='$id'");
		$row = mysqli_fetch_array ($query);
			if (mysqli_num_rows($query)>0){
				if ($row['role']=="SAdmin"){
					?>
						<br>ASSIGN USER
						<form method='GET' action='assignuser.php'>
						<select name='id'>
							<?php
								$query = mysqli_query($con, "SELECT ID_Number, First_Name, Last_Name, Department_Name FROM amodb.Person UNION SELECT ID_Number, First_Name, Last_Name, Department_Name FROM psuedoadzudb.person");
								while ($row = mysqli_fetch_array($query)){
									echo "<option value='".$row['ID_Number']."'>".$row['Last_Name'].", ".$row['First_Name']."  (".$row['Department_Name'].") ; ".$row['ID_Number']."</option>";
								}
							?>
						</select>
						<select name='role'>
							<option value='Admin'> Admin </option>
						</select>
						<input type='submit' name='assign'>
						</form>
				<?php
				$query = mysqli_query($con, "SELECT * FROM user_role LEFT JOIN person USING(ID_Number)");
				if (mysqli_num_rows($query)>0){

					?>
					<div id='table-wrapper' >
				<div id='table-scroll'>	<table width="100%" border="1" style="text-align:center">
						<tr>
						<td> ID Number </td>
						<td> Name </td>
						<td> Department/Office </td>
						<td> Role </td>
						<td> DELETE </td>
						</tr>
						<tr>
					<?php
				while ($row = mysqli_fetch_array($query)){
					echo "<tr><td>".$row['ID_Number']."</td>";
					echo "<td>".$row['Last_Name'].", ".$row['First_Name']."</td>";
					echo "<td>".$row['Department_Name']."</td>";
					echo "<td>".$row['role']."</td>";
					echo "<td><form method='GET' action='assignuser.php'> <button name='delete' value='".$row['ID_Number']."''> Delete </button> </form></td></tr>";	
				}
				?>
				</table>
			</div></div>
			<br>
			<a href="index.php" class="see_more" style="float:right">Back to Home</a>
				<?php
			}
				}
				else {
					echo "You are not authorized for this feature";
				}
					
			}
		?>
	</div>
</div>
</body>
</html>