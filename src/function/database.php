<?php
include "connect.php";

function amodb (){
	$parameter = array ();
	$parameter[0] = "localhost";
	$parameter[1] = "root";
	$parameter[2] = "";
	$parameter[3] = "amodb";

	$con=connectdb($parameter);

	return $con;
}

function adzudb (){
	$parameter = array ();
	$parameter[0] = "localhost";
	$parameter[1] = "root";
	$parameter[2] = "";
	$parameter[3] = "psuedoadzudb";

	$con=connectdb($parameter);

	return $con;
}

?>