<?php
include "function/database.php";
$con = amodb();
$cat=$_POST['cat'];
$type=$_POST['type'];
$weight=$_POST['weight'];
$region=$_POST['region'];
$query=mysqli_query($con,"SELECT rate FROM rate WHERE category='$cat' AND type='$type' AND weight='$weight' AND region='$region'");
$row=mysqli_fetch_array($query);
echo $row['rate'];
?>