<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect($con);
include "function/resultfunc.php";
//include "email.php";
if (!isset($_GET['ID_Number'])){
	header("location:add.php");
	exit();
}
	
	$id=$_GET['ID_Number'];
	$query = mysqli_query ($con, "SELECT id_number FROM person WHERE id_number='$id'");
	if (mysqli_num_rows($query)>0){
		;
	}
	else {
		$con2=	adzudb ();
		$query2 = mysqli_query ($con2, "SELECT * FROM person WHERE id_number='$id'");
		$row = mysqli_fetch_array($query2);
		
		$id_num =$row['ID_Number']; $pass=$row['Password']; $email=$row['Email']; $first=$row['First_Name']; $last=$row['Last_Name']; $type=$row['Person_Type']; $dept=$row['Department_Name'];
		mysqli_query ($con, "INSERT INTO person (ID_Number, Password, Email, First_Name, Last_Name, Person_Type, Department_Name) VALUES ('$id_num', '$pass', '$email', '$first', '$last', '$type', '$dept')");
	
		mysqli_close ($con2);
	}
	
	$destination = $_GET['Destination'];
	$mailtype = $_GET['Mail_Type'];
	$month= $_GET['m']; $day= $_GET['d']; $year=$_GET['y'];
	$date = "$month/$day/$year";
	$mail_id = generate_mailid ($con, $year);
	if ($_GET['Category']=="Incoming"){
		if ($mailtype=="Ordinary")
			$mailnum=generate_ornum ($con, $year);
		else
			$mailnum= $_GET['Mail_Number'];
		$sender = $_GET['Sender_Name'];
		if ($sender == "")
			$sender = "Not specified";
	
		mysqli_query ($con, "INSERT INTO mail (Mail_ID, Mail_Type, Category) VALUES ('$mail_id', '$mailtype', 'Incoming')");	
	
		mysqli_query ($con, "INSERT INTO incoming (Mail_ID,  Mail_Number, Day_Received, Month_Received, Year_Received, Department, Sender_Name, ID_Number) VALUES ((SELECT Mail_ID FROM mail WHERE Mail_ID='$mail_id'),'$mailnum','$day','$month','$year','$destination', '$sender', (SELECT ID_Number FROM person WHERE ID_Number='$id'))");
		
		//emailin($con, $sender, $date, $mailtype, $id, $mail_id);
	}
	else{
		$recipient = $_GET['Recipient_Name'];
		if ($recipient == "")
			$recipient = "Not specified";
		$weight = $_GET['Weight'];
		$total = $_GET['Total_Cost'];
	
		mysqli_query ($con, "INSERT INTO mail (Mail_ID, Mail_Type, Category) VALUES ('$mail_id','$mailtype', 'Outgoing')");	
	
		mysqli_query ($con, "INSERT INTO outgoing (Mail_ID, Day_Sent, Month_Sent, Year_Sent, Destination, Recipient_Name, ID_Number, Weight, Total_Cost) VALUES ((SELECT Mail_ID FROM mail WHERE Mail_ID='$mail_id'),'$day','$month','$year', '$destination', '$recipient', (SELECT ID_Number FROM person WHERE ID_Number='$id'), '$weight', '$total')");
	
		//emailout($con, $recipient, $date, $mailtype, $total, $destination, $id, $mail_id);
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
