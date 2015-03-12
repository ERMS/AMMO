<?php

function connectdb ($parameter){
	$host=$parameter[0];
	$user=$parameter[1];
	$pass=$parameter[2];
	$db=$parameter[3];

	$con=mysqli_connect($host, $user, $pass, $db);
	
	if (mysqli_connect_errno($con)){
		//$err=mysqli_connect_error();
		//echo "ERROR:".$err."<br>"; 
		exit ("Failed to connect <br>");
	}
	else {
		return $con;
	}
}

?>