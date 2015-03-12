<?php
	include "function/database.php";
	$con = amodb();
	include "function/logged.php";

	if (isset($_GET['log'])){
		$id = $_SESSION['user'];
		mysqli_query ($con, "UPDATE user_activity SET isLogged = 0 WHERE id_number='$id'");
		$_SESSION['isLogged']=0;
		header("location:login.php");
	}
?>
<!DOCTYPE html>
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

		<div class="container" style="margin-top:100px; margin-left:100px;">
				
				<?php
					$id = $_SESSION['user'];
					$query = mysqli_query ($con, "SELECT * FROM Person WHERE ID_Number='$id'");
					$row = mysqli_fetch_array ($query);
				?>
				<h2 > <?php echo $row['First_Name']." ".$row['Last_Name']; ?> </h2></span>
						<!--<p>Auxiliary Mail Personel</p> -->
						<p style="margin-top:-10px;" > <?php echo $row['ID_Number']; ?></p>
				<div class='line' style="margin-top:30px;"></div>

				<h3>Recent Log Activity</h3>
				<table cellpadding="10"  style="width:100%; border-collapse:collapse;" border="1">
					<tr style="background-color:#ececec;">
						<td width="50%">
							<span style="float:left;">INCOMING</span>
							<span style="float:right;"><a class="see_more" href="more.php?category=Incoming">see more </a></span>
						</td>
						<td>
							<span style="float:left;">OUTGOING</span>
							<span style="float:right;"><a class="see_more" href="more.php?category=Outgoing">see more </a></span>
						</td>
					</tr>
					<tr>
						<td style="vertical-align: text-top;">
							<?php
								$query = mysqli_query ($con, "SELECT * FROM incoming WHERE ID_Number='$id' ORDER BY Mail_ID DESC LIMIT 3");
								if (mysqli_num_rows($query)>0){
								?><table border='1' width='100%' style='text-align:center; border-collapse:collapse;'>
								<?php
								while ($row = mysqli_fetch_array($query)){
									echo "<tr>
									<td>".$row['Month_Received']."/".$row['Day_Received']."/".$row['Year_Received']."</td>
									<td> You have recieved a mail. <br>From: ".$row['Sender_Name'].". <br>The mail is currently "; if ($row['Mail_Status']==0) echo "UNCLAIMED"; else echo "CLAIMED";  echo"</td>
									<td> <a class='see_more' href='view.php?category=Incoming&id=".$row['Mail_ID']."'> View </a> </td> </tr>";
								}
								?>
								</table>
								<?php
								}
								else 
									echo "No mails recieved";
							?>
						</td>
						<td style="vertical-align: text-top;">
							<?php
								$query = mysqli_query ($con, "SELECT * FROM outgoing WHERE ID_Number='$id' ORDER BY Mail_ID DESC LIMIT 3");
								if (mysqli_num_rows($query)>0){
								?><table border='1' width='100%' style='text-align:center; border-collapse:collapse;'>
								<?php
								while ($row = mysqli_fetch_array($query)){
									echo "<tr><td>".$row['Month_Sent']."/".$row['Day_Sent']."/".$row['Year_Sent']."</td>
									<td> You have sent a mail. <br>To: ".$row['Recipient_Name']." ; <br>Destination: ".$row['Destination']." ; Cost: ".$row['Total_Cost']."</td>
									<td> <a class='see_more' href='view.php?category=Outgoing&id=".$row['Mail_ID']."'> View </a> </td> </tr>";
								}
								?>
								</table>
								<?php
								}
								else 
									echo "No mails sent";
							?>
						</td>
					</tr>
				</table>
		</div>
	</div>

<div class="footer"></div>
</body>
</html>
