<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
if (!isset($_GET['id']))
	header("location:profile.php");
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

<?php
		$id = $_SESSION['user'];
		$query = mysqli_query ($con, "SELECT role FROM user_role WHERE ID_Number='$id'");
		$row = mysqli_fetch_array ($query);
?>


<div id="nav-right">
	<ul id="right-nav">
	<img class="img-nav" src="images/home.png" width="45px">
	<li><a style="margin-left:40px; " href="index.php">HOME</a></li>
<?php
if($row['role']!="Admin"&&$row['role']!="SAdmin")
{	
	?>
	
	<img class='img-nav' style='top:55px;' src='images/logout.png' width='45px'>
	<li><a style='margin-left:40px' href='profile.php?log=out'>LOGOUT</a></li>
	</ul>
	<?php
}
else
{
	?>

	<img class='img-nav' style='top:55px;' src='images/add.png' width='45px'>
	<li ><a  style='margin-left:30px;' href='add.php'>ADD</a></li>
	<img class='img-nav' style='top:110px;' src='images/search.png' width='45px'>
	<li><a style='margin-left:40px' href='search.php'>SEARCH</a></li>
	<img class='img-nav' style='top:165px;' src='images/profile.png' width='45px'>
	<li><a style='margin-left:40px' href='profile.php'>PROFILE</a></li>
	<img class='img-nav' style='top:220px;' src='images/logout.png' width='45px'>
	<li><a style='margin-left:40px' href='profile.php?log=out'>LOGOUT</a></li>
	</ul>
	<?php
}
?>
</div>
<div style=" position:relative; width:900px; display:block; margin: 0 auto;">
	<div style=" max-height:auto; position:relative; width:500px; display:block; margin: 0px auto;">
<div class="container" style="margin-top:140px;">

<?php
				$id = $_SESSION['user'];
					$query = mysqli_query ($con, "SELECT * FROM Person WHERE ID_Number='$id'");
					$row = mysqli_fetch_array ($query);
				?>
				<span><h1> <?php echo $row['First_Name']." ".$row['Last_Name']; ?> </h1></span>
						<!--<p>Auxiliary Mail Personel</p> -->
						<p> <?php echo $row['ID_Number']; ?></p>

				<div class='line'></div>

<?php
	$mail_id = $_GET['id'];
	$category = $_GET['category'];

	if ($category=="Incoming") {
		$query = mysqli_query ($con, "SELECT * FROM incoming LEFT JOIN person USING (ID_Number) LEFT JOIN mail USING (Mail_ID) WHERE Mail_ID = '$mail_id'");
		$row = mysqli_fetch_array ($query);

		echo "
		<br><strong> Mail_ID:</strong> ".$row['Mail_ID']."
		<br><strong> Mail Type: </strong>".$row['Mail_Type']." Mail
		<br><strong> From:</strong> ".$row['Sender_Name']." 
		<br><strong> Date:</strong> ".$row['Month_Received']."/".$row['Day_Received']."/".$row['Year_Received']."
		<br><strong> Status:</strong>";
		if ($row['Mail_Status']==0)
			echo "Unclaimed";
		else
			echo "Claimed";

		?>
		<br><br> *note: Take note of the Mail ID when claiming your mail in the Auxilliary Office
		<?php
	}
	else {
		$query = mysqli_query ($con, "SELECT * FROM outgoing LEFT JOIN person USING (ID_Number) LEFT JOIN mail USING (Mail_ID) WHERE Mail_ID = '$mail_id'");
		$row = mysqli_fetch_array ($query);

		echo "
		<br> Mail ID: ".$row['Mail_ID']."
		<br> Mail Type: ".$row['Mail_Type']." Mail 
		<br> To: ".$row['Recipient_Name']."
		<br> Date: ".$row['Month_Sent']."/".$row['Day_Sent']."/".$row['Year_Sent']." 
		<br> Destination: ".$row['Destination']."
		<br> Total Cost: ".$row['Total_Cost']." Php";
	}
?>
<br/><br/>
<a class='see_more' href='profile.php' style="float:right;">Back to Profile</a>
<br/>
</div>
</div>
</div>
<div class="footer"></div>
</body>
</html>