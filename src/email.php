<?php
include "function/database.php";
$con = amodb();
if (isset($_GET['category'])){
	$id = $_GET['id'];
	if ($_GET['category']=="Incoming"){
		$query = mysqli_query($con, "SELECT * FROM Incoming LEFT JOIN person USING (ID_Number) LEFT JOIN mail USING (Mail_ID) WHERE Mail_ID = '$id' ");
		$row = mysqli_fetch_array($query);
		$sender = $row['Sender_Name'];
		$mailtype = $row['Mail_Type'];
		$mail_id = $_GET['id'];
		$id = $row['ID_Number'];
		$date = $_GET['date'];
		emailin($con, $sender, $date, $mailtype, $id, $mail_id);
	}
	else {
		$query = mysqli_query($con, "SELECT * FROM Outgoing LEFT JOIN person USING (ID_Number) LEFT JOIN mail USING (Mail_ID) WHERE Mail_ID = '$id' ");
		$row = mysqli_fetch_array($query);
		$recipient = $row['Recipient_Name'];
		$mailtype = $row['Mail_Type'];
		$total = $row['Total_Cost'];
		$destination = $row['Destination'];
		$mail_id = $_GET['id'];
		$id = $row['ID_Number'];
		$date = $_GET['date'];
		emailout($con, $recipient, $date, $mailtype, $total, $destination, $id, $mail_id);
	}
}
function emailout ($con, $recipient, $date, $mailtype, $total, $destination, $id, $mail){

$query = mysqli_query ($con, "SELECT email FROM person WHERE id_number ='$id'");
$row = mysqli_fetch_array ($query);
$email = $row['email'];

$from = "AUXILLIARY MAIL OFFICE"; // sender
$subject = "Transaction Report for your Outgoing Mail via Auxilliary Mail Office";
if (isset($_GET['scase'])){
	if ($_GET['scase']=="edit")
		$subject = "Notice: There has been changes in your mail information";
}
$message = "Good day!

	This is to inform you that you have sent a $mailtype mail via the Auxilliary Mail Office. This is the report of your transaction.

MAIL INFORMATION:

	TO: $recipient

	DATE: $date

	DESTINATION: $destination

	MAIL COST: $total php

Your Mail number is: $mail
Please take note of your Mail Number when visiting the Auxilliary Office to settle issues if any.

If this message is not intended for you, please visit the Auxilliary Office to verify.

Thank you!";
// message lines should not exceed 70 characters (PHP rule), so wrap it
//$message = wordwrap($message, 70);
// send mail

ini_set("SMTP","ssl://smtp.gmail.com");
ini_set("smtp_port","587");

	if (mail($email,$subject,$message,"From: $from\n")){ 
		echo "true";
	}
	else {
		echo "false";
	}
}

function emailin ($con, $sender, $date, $mailtype, $id, $mail){

$query = mysqli_query ($con, "SELECT email FROM person WHERE id_number ='$id'");
$row = mysqli_fetch_array ($query);
$email = $row['email'];

$from = "AUXILLIARY MAIL OFFICE"; // sender
$subject = "You have received a mail. Claim it in the Auxilliary Mail Office";
if (isset($_GET['scase'])){
	if ($_GET['scase']=="resend")
		$subject = "Notice: You have not claim your mail";
	if ($_GET['scase']=="edit")
		$subject = "Notice: There has been changes in your mail information";
}
$message = "

	<div style='text-align:center'><img src='../images/report.jpg'><div>

	Good day!

	This is to inform you that you have recieve a/an $mailtype mail. Kindly visit the Auxilliary Office to claim your mail. 

MAIL INFORMATION:
	
	FROM: $sender

	DATE: $date

Your Mail number is: $mail
Please take note of your Mail Number when claiming your mail at Auxilliary Office or to settle issues if any.

If this message is not intended for you, please visit the Auxilliary Office to verify.

Thank you!";
// message lines should not exceed 70 characters (PHP rule), so wrap it
//$message = wordwrap($message, 70);
// send mail

ini_set("SMTP","ssl://smtp.gmail.com");
ini_set("smtp_port","587");

	if (mail($email,$subject,$message, "From: $from\n")){ 
		echo "true";
	}
	else {
		echo "false";
	}

}

?>