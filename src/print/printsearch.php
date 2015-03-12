<?php
include "../function/database.php";
$con = amodb();
include "../function/logged.php";
redirect ($con);

	if (isset($_GET['filter'])&&$_GET['filter']!=''){
		$filter = $_GET['filter'];
	}
?>
<html>
<head>
	<style>
	@media screen {
	html, body { margin:0; font-family: Arial, Helvetica, sans-serif; font-size:14px; background-color:#DCDCDC;}
	#top {width: 100%; background-color: #87CEEB; text-align: center;}
	.printable {width: 8.5in; background-color:#FFF; margin: 0 auto; padding: 0.5in; text-align: center;}
	}
	@media print {
		#top {display: none}
		.printable {text-align: center;}
	}
	</style>
	<title> Print </title>
</head>

<body>
		<div id="top">
			<input type='submit' value='print' onclick="window.print()">
		</div>
		<div class="printable">
			<img src='../images/report.jpg'>
			<?php
			$searchquery = $_GET['search'];
			$keyword = explode(' ',$searchquery);
			$keyword = array_filter($keyword);
			if ($_GET['category']=="Incoming"){
				?>
				<br> Incoming Mail </br>
				<?php
		$string = "SELECT * FROM incoming LEFT JOIN person USING (ID_Number) LEFT JOIN mail USING (Mail_ID) ";
		$i=0;
		foreach ($keyword as $value){
			if ($i==0)
				$string = $string."WHERE ID_Number LIKE '%$value%' ";
			else 
				$string = $string."OR ID_Number LIKE '%$value%' ";
			$string = $string."OR First_Name LIKE '%$value%' OR Last_Name LIKE '%$value%' OR Department LIKE '%$value%' OR Mail_ID LIKE '%$value%' ";
			$i++;
		}
		$string = "SELECT * FROM ($string) AS new ";
	if (isset($filter)){
		if ($filter == 'type'){
			$filter = 'Mail_Type';
			$query = $_GET['type'];
			$string = $string."WHERE $filter = '$query' ";
		}
		else if ($filter == 'location'){
			$filter = 'Department';
			$query = $_GET['location'];
			$string = $string."WHERE $filter = '$query' ";
		}
		else if ($filter == 'date'){
			$query = $_GET['m'];
			if ($query!=''){
				$filter = 'Month_Received';
				$string = $string."WHERE $filter = '$query' ";
			}
			$query = $_GET['d'];
			if ($query!=''){
				$filter = 'Day_Received';
				if ($_GET['m']=='')
					$string = $string."WHERE $filter = '$query' ";
				else
					$string = $string."AND $filter = '$query' ";
			}
			$query = $_GET['y'];
			if ($query!=''){
				$filter = 'Year_Received';
				if ($_GET['m']==''&&$_GET['d']=='')
					$string = $string."WHERE $filter = '$query' ";
				else
					$string = $string."AND $filter = '$query' ";
			}
		}
		else if ($filter == 'name'){
			$filter = 'Sender_Name';
			$query = $_GET['name'];
			$string = $string."WHERE $filter LIKE '%$query%' ";
		}
		else if ($filter == 'status'){
			$filter = 'Mail_Status';
			$query = $_GET['status'];
			$string = $string."WHERE $filter = '$query' ";
		}
	}
		$string = $string."ORDER BY Mail_ID DESC LIMIT 50";
		$query = mysqli_query ($con, $string);
		if (mysqli_num_rows($query)>0){
			?><br>

			<table  border='1' width='100%' cellpadding='3' style='text-align:center; display:block; border-collapse:collapse; border:solid rgb(189, 189, 189) 2px;'>
					 <thead >
					  <tr>  
							<th> Mail_ID </th> 
							<th> ID Number </th> 
							<th> Recipient </th> 
							<th> Mail Number </th>  
							<th> Mail Type </th> 
							<th> Sender </th> 
							<th> Department/Office </th> 
							<th> Date </th> 
							<th> Status </th> 
						</tr> 
					</thead>
			<?php
			while ($row = mysqli_fetch_array($query)){
						echo  "
						<tbody>
						<tr>
						<td>".$row['Mail_ID']."</td>
						<td>".$row['ID_Number']."</td> 
						<td>".$row['First_Name']." ".$row['Last_Name']."</td>
						<td>".$row['Mail_Number']."</td> 
						<td>".$row['Mail_Type']."</td>
						<td>".$row['Sender_Name']."</td> 
						<td>".$row['Department']."</td> 
						<td>".$row['Month_Received']."/".$row['Day_Received']."/".$row['Year_Received']."</td> 
						<td>"; if ($row['Mail_Status']==0) echo "UNCLAIMED"; else echo "CLAIMED";  
						echo "
						</tr></tbody>"; 
			}
			?>
			</table>
			<?php
		}
			}
			else {
				?>
				<br> Outgoing Mail <br>
				<?php
		$string = "SELECT * FROM outgoing LEFT JOIN person USING (ID_Number) LEFT JOIN mail USING (Mail_ID) ";
		$i=0;
		foreach ($keyword as $value){
			if ($i==0)
				$string = $string."WHERE ID_Number LIKE '%$value%' ";
			else 
				$string = $string."OR ID_Number LIKE '%$value%' ";
			$string = $string."OR First_Name LIKE '%$value%' OR Last_Name LIKE '%$value%' OR Destination LIKE '%$value%' OR Mail_ID LIKE '%$value%' ";
			$i++;
		}
		$string = "SELECT * FROM ($string) AS new ";
		if (isset($filter)){
		if ($filter == 'type'){
			$filter = 'Mail_Type';
			$query = $_GET['type'];
			$string = $string."WHERE $filter = '$query' ";
		}
		else if ($filter == 'location'){
			$filter = 'Destination';
			$query = $_GET['location'];
			$string = $string."WHERE $filter = '$query' ";
		}
		else if ($filter == 'date'){
			$query = $_GET['m'];
			if ($query!=''){
				$filter = 'Month_Sent';
				$string = $string."WHERE $filter = '$query' ";
			}
			$query = $_GET['d'];
			if ($query!=''){
				$filter = 'Day_Sent';
				if ($_GET['m']=='')
					$string = $string."WHERE $filter = '$query' ";
				else
					$string = $string."AND $filter = '$query' ";
			}
			$query = $_GET['y'];
			if ($query!=''){
				$filter = 'Year_Sent';
				if ($_GET['m']==''&&$_GET['d']=='')
					$string = $string."WHERE $filter = '$query' ";
				else
					$string = $string."AND $filter = '$query' ";
			}
		}
		else if ($filter == 'name'){
			$filter = 'Recipient_Name';
			$query = $_GET['name'];
			$string = $string."WHERE $filter LIKE '%$query%' ";
		}
	}
		$string = $string."ORDER BY Mail_ID DESC LIMIT 50";
		$query = mysqli_query ($con, $string);
		if (mysqli_num_rows($query)>0){
			?>	<br><table border='1' width='100%' cellpadding='3' style='text-align:center; border-collapse:collapse; border:solid rgb(189, 189, 189) 2px;'> 
				<tr style='border-top: solid green 2px;'> 
				<td> Mail_ID </td>
				<td> ID Number </td> 
				<td> Sender </td>
				<td> Mail Type </td> 
				<td> Recipient </td>
				<td> Destination </td> 
				<td> Date </td> 
				<td> Cost </td>
				</tr>
			<?php
			$total = 0;
			while ($row = mysqli_fetch_array($query)){
				$mailid=$row['Mail_ID'];
				echo  "<tr>
				<td>".$row['Mail_ID']."</td>
				<td>".$row['ID_Number']."</td> 
				<td>".$row['First_Name']." ".$row['Last_Name']."</td>
				<td>".$row['Mail_Type']."</td> 
				<td>".$row['Recipient_Name']."</td> 
				<td>".$row['Destination']."</td> 
				<td>".$row['Month_Sent']."/".$row['Day_Sent']."/".$row['Year_Sent']."</td>
				<td>".$row['Total_Cost']."</td>
				</tr>";
				$total = $total + $row['Total_Cost'];
			}
			?>
				<tr>
					<td colspan='6'></td>
					<td> TOTAL: </td>
					<td> <?php echo $total; ?> </td>
				</tr>
			</table>
			<?php
		}
			}
			?>
		</div>
</body>