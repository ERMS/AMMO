<?php
include "function/database.php";
$con = amodb();
$string = "";
	if ($_POST['change']=="category") {
	$a = $_POST['type'];
	$query=mysqli_query($con,"SELECT DISTINCT category FROM rate WHERE type='$a'");
		while ($row = mysqli_fetch_array($query)) {
			 $string = $string."<option value='".$row['category']."'";
			 if ($_POST['select']==$row['category'])
			 	$string = $string."selected";
			 $string = $string.">".$row['category']."</option>";
		}
	}
	if ($_POST['change']=="weight") {
	$a = $_POST['cat'];
	$query=mysqli_query($con,"SELECT DISTINCT weight FROM rate WHERE category='$a'");
		while ($row = mysqli_fetch_array($query)) {
			 $string = $string."<option value='".$row['weight']."'";
			 if ($_POST['select']==$row['weight'])
			 	$string = $string."selected";
			 $string = $string.">".$row['weight']."</option>";
		}
	}	
	if ($_POST['change']=="region") {
	$a = $_POST['cat'];
	$query=mysqli_query($con,"SELECT DISTINCT region FROM rate WHERE category='$a'");
		while ($row = mysqli_fetch_array($query)) {
			 $string = $string."<option value='".$row['region']."'";
			 if ($_POST['select']==$row['region'])
			 	$string = $string."selected";
			 $string = $string.">".$row['region']."</option>";
		}
	}	
echo $string; 
?>