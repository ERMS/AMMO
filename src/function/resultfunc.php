<?php
function generate_mailid ($con, $year){
	$query = mysqli_query ($con, "SELECT Mail_ID FROM mail WHERE Mail_ID LIKE '%$year%'");
	
	if (mysqli_num_rows($query)>0) {
		$greater_row = mysqli_fetch_array($query);
		while ($row = mysqli_fetch_array($query)) {
			if ($greater_row['Mail_ID']<$row['Mail_ID']){
				$greater_row = $row;
			}
		}
		return $greater_row['Mail_ID'] + 1;
	}
	else {
		return $year."0000" + 1;
	}
}

function generate_ornum ($con, $year){
	$initial= "OR".$year;
	$query = mysqli_query ($con, "SELECT Mail_Number FROM incoming WHERE Mail_Number LIKE '%$initial%'");
	
	if (mysqli_num_rows($query)>0) {
		$greater_row = mysqli_fetch_array($query);
		while ($row = mysqli_fetch_array($query)) {
			if ($greater_row['Mail_Number']<$row['Mail_Number']){
				$greater_row = $row;
			}
		}
		$initial=$greater_row['Mail_Number'];
		$num=$year.$initial[6].$initial[7].$initial[8].$initial[9] + 1;
		$initial=$initial[0].$initial[1];
		$num=$initial.$num;
		return $num;
	}
	else {
		$initial = $year."0000" + 1;
		return "OR".$initial;
	}
}
?>