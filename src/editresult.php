<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect($con);
include "function/resultfunc.php";
if (!isset($_GET['Mail_ID'])){
	header("location:search.php");
	exit();
}

	$mail_id = $_GET['Mail_ID'];
	$destination = $_GET['Destination'];
	$mailtype = $_GET['Mail_Type'];
	$month= $_GET['m']; $day= $_GET['d']; $year=$_GET['y'];
	$date = "$month/$day/$year";
	$id=$_GET['ID_Number'];
	$query=mysqli_query($con, "SELECT * FROM mail WHERE Mail_ID='$mail_id'");
	$row = mysqli_fetch_array($query);
	
	if ($_GET['Category']=="Incoming"){
		if ($mailtype=="Ordinary"){
			if ($row['Mail_Type']=="Ordinary"){
				$query2 = mysqli_query($con, "SELECT * FROM incoming WHERE Mail_ID='$mail_id'");
				$row2 = mysqli_fetch_array($query2);
				$mailnum=$row2['Mail_Number'];
			}
			else
				$mailnum=generate_ornum ($con, $year);
		}
		else
			$mailnum= $_GET['Mail_Number'];
		$sender = $_GET['Sender_Name'];
		if ($sender == "")
			$sender = "Not specified";
	
		mysqli_query ($con, "UPDATE mail SET Mail_Type='$mailtype', Category='Incoming' WHERE Mail_ID='$mail_id'");	
	
		mysqli_query ($con, "UPDATE incoming SET Mail_Number='$mailnum', Day_Received='$day', Month_Received='$month', Year_Received='$year', Department='$destination', Sender_Name='$sender' WHERE Mail_ID='$mail_id'");
	
	}
	else{
		$recipient = $_GET['Recipient_Name'];
		if ($recipient == "")
			$recipient = "Not specified";
		$weight = $_GET['Weight'];
		$total = $_GET['Total_Cost'];
	
		mysqli_query ($con, "UPDATE mail SET Mail_Type='$mailtype', Category='Outgoing' WHERE Mail_ID='$mail_id'");	
	
		mysqli_query ($con, "UPDATE outgoing SET Day_Sent='$day', Month_Sent='$month', Year_Sent='$year',  Destination='$destination', Recipient_Name='$recipient',Weight='$weight', Total_Cost='$total' WHERE Mail_ID='$mail_id'");
	
	}
	
	mysqli_close ($con);
	$con=amodb();
		$query=mysqli_query($con,"SELECT First_Name,Last_Name FROM person WHERE ID_Number='$id'");
		$row=mysqli_fetch_array($query);
		if($_GET['Category']=="Outgoing")
		{
			$x=array('name'=>$row['Last_Name'].", ".$row['First_Name'],'id'=>$mail_id);
		}
		else
		{
			$x=array('name'=>$row['Last_Name'].", ".$row['First_Name'],'id'=>$mail_id,'num'=>$mailnum);
		}
		header('Content-Type: application/json');
		echo json_encode($x);
?>
