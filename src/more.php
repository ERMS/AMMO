<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
if (!isset($_GET['category']))
	header("location:profile.php");
?>
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
$category = $_GET['category'];
$id = $_SESSION['user'];

if (isset($_GET['filter'])&&$_GET['filter']!=''){
	$filter = $_GET['filter'];
}
?>



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
<div style='max-height:auto; position:relative; width:800px; display:block; margin: 0 auto;'>
<div class='container' style="margin-top:100px; margin-left:80px;">

				<?php
					$id = $_SESSION['user'];
					$query = mysqli_query ($con, "SELECT * FROM Person WHERE ID_Number='$id'");
					$row = mysqli_fetch_array ($query);
				?>
				<span><h1> <?php echo $row['First_Name']." ".$row['Last_Name']; ?> </h1></span>
						<!--<p>Auxiliary Mail Personel</p> -->
						<p> <?php echo $row['ID_Number']; ?></p>

				<div class='line'></div>
				<br/>

<form action='more.php' method='GET'>
	Category: 
	<input id='out' type='radio' name='category' onClick='cat()' value='Outgoing' <?php if ($category=="Outgoing") echo "checked='checked'";?>> Outgoing
	<input id='in' type='radio' name='category' onClick='cat()' value='Incoming' <?php if ($category=="Incoming") echo "checked='checked'";?>> Incoming
	<br><label for="filter">Filter by:</label> 
	<span id='select'>
	<select id='filter' onChange='change()' name='filter'>
	</select>
	 </span>
	<span id='form'> </span> 
	<input type='submit' value='go'><br>
</form>

<?php

if ($category == "Incoming"){
	$string = "SELECT * FROM Incoming LEFT JOIN person USING (ID_Number) LEFT JOIN mail USING (Mail_ID) WHERE ID_Number = '$id' ";
	if (isset($filter)){
		if ($filter == 'type'){
			$filter = 'Mail_Type';
			$query = $_GET['type'];
			$string = $string."AND $filter = '$query' ";
		}
		else if ($filter == 'location'){
			$filter = 'Department';
			$query = $_GET['location'];
			$string = $string."AND $filter = '$query' ";
		}
		else if ($filter == 'date'){
			$query = $_GET['m'];
			if ($query!=''){
				$filter = 'Month_Received';
				$string = $string."AND $filter = '$query' ";
			}
			$query = $_GET['d'];
			if ($query!=''){
				$filter = 'Day_Received';
				$string = $string."AND $filter = '$query' ";
			}
			$query = $_GET['y'];
			if ($query!=''){
				$filter = 'Year_Received';
				$string = $string."AND $filter = '$query' ";
			}
		}
		else if ($filter == 'name'){
			$filter = 'Sender_Name';
			$query = $_GET['name'];
			$string = $string."AND $filter LIKE '%$query%' ";
		}
		else if ($filter == 'status'){
			$filter = 'Mail_Status';
			$query = $_GET['status'];
			$string = $string."AND $filter = '$query' ";
		}
	}

	/*echo $string;*/

	$query = mysqli_query ($con, $string);
	if (mysqli_num_rows($query)>0){
		?>
		<div id='table-wrapper'>
			<div id='table-scroll' style='height:150px;'>
		<table  border='1' width='100%' cellpadding='3' style='text-align:center; border-collapse:collapse; border:solid rgb(189, 189, 189) 2px;'>
				<tr>
				<td> Mail_ID </td>
				<td> Mail Number </td> 
				<td> Mail Type </td> 
				<td> Sender </td>
				<td> Department/Office </td> 
				<td> Date </td>
				<td> Status </td> </tr>
		<?php
		while ($row = mysqli_fetch_array($query)){
			echo  "<tr>
			<td>".$row['Mail_ID']."</td>
			<td>".$row['Mail_Number']."</td> 
			<td>".$row['Mail_Type']."</td>
			<td>".$row['Sender_Name']."</td> 
			<td>".$row['Department']."</td> 
			<td>".$row['Month_Received']."/".$row['Day_Received']."/".$row['Year_Received']."</td><td>";
			if ($row['Mail_Status']==0) echo "UNCLAIMED"; else echo "CLAIMED";  echo"</td>
			</tr>";
		}
		?> 
		</table></div></div>
		<?php
	}
	else {
		?> 
		<br> <p> There was no data found in incoming mail </p>
		<?php
	}
}
else {
	$string = "SELECT * FROM Outgoing LEFT JOIN person USING (ID_Number) LEFT JOIN mail USING (Mail_ID) WHERE ID_Number = '$id' ";
	
	if (isset($filter)){
		if ($filter == 'type'){
			$filter = 'Mail_Type';
			$query = $_GET['type'];
			$string = $string."AND $filter = '$query' ";
		}
		else if ($filter == 'location'){
			$filter = 'Destination';
			$query = $_GET['location'];
			$string = $string."AND $filter = '$query' ";
		}
		else if ($filter == 'date'){
			$query = $_GET['m'];
			if ($query!=''){
				$filter = 'Month_Sent';
				$string = $string."AND $filter = '$query' ";
			}
			$query = $_GET['d'];
			if ($query!=''){
				$filter = 'Day_Sent';
				$string = $string."AND $filter = '$query' ";
			}
			$query = $_GET['y'];
			if ($query!=''){
				$filter = 'Year_Sent';
				$string = $string."AND $filter = '$query' ";
			}
		}
		else if ($filter == 'name'){
			$filter = 'Recipient_Name';
			$query = $_GET['name'];
			$string = $string."AND $filter LIKE '%$query%' ";
		}
	}

	/*echo $string;*/


	$query = mysqli_query ($con, $string);
	if (mysqli_num_rows($query)>0){
		?>
		<div id='table-wrapper'>
			<div id='table-scroll' style='height:150px;'>
		<table border='1' width='100%' cellpadding='3' style='text-align:center; border-collapse:collapse; border:solid rgb(189, 189, 189) 2px;'> 
			<tr> 
			<td> Mail_ID </td>
			<td> Mail Type </td> 
			<td> Recipient </td>
			<td> Destination </td> 
			<td> Date </td> </tr>
		<?php
		while ($row = mysqli_fetch_array($query)){
			$mailid=$row['Mail_ID'];
			echo  "<tr>
			<td>".$row['Mail_ID']."</td>
			<td>".$row['Mail_Type']."</td> 
			<td>".$row['Recipient_Name']."</td> 
			<td>".$row['Destination']."</td> 
			<td>".$row['Month_Sent']."/".$row['Day_Sent']."/".$row['Year_Sent']."</td> </tr>";
		}
		?>
		</table></div></div>
		<?php
	}
	else {
		?>
		<br> <p> There was no data found in outgoing mail </p>
		<?php
	}
}
?>
<br>
<a href='profile.php' class="see_more" style='float:right;'>Back to Profile</a>
</div>
</div>
</div>
</div>
<div class="footer"></div>
</body>
</html>

<script>
cat ();
function cat(){
	var form  = document.getElementById("select");
	var category;

	if (document.getElementById("in").checked==true)
		category = "Incoming";
	else
		category = "Outgoing";

	if (category=="Incoming"){
		var string = "<select id='filter' onChange='change()' name='filter'>\
		<option value=''> </option>\
		<option value='type'> Mail Type </option>\
		<option value='location'> Department/Office </option>\
		<option value='date'> Date </option>\
		<option value='name'> From </option>\
		<option value='status'> Status </option>\
	</select>";
		form.innerHTML = string;
	}
	else {
		var string = "<select id='filter' onChange='change()' name='filter'>\
		<option value=''> </option>\
		<option value='type'> Mail Type </option>\
		<option value='location'> Destination</option>\
		<option value='date'> Date </option>\
		<option value='name'> To </option>\
	</select>";
		form.innerHTML = string;
	}
	 document.getElementById("form").innerHTML ="";

}

function change(){
	var filter = document.getElementById("filter").value;
	var form  = document.getElementById("form");
	var category;

	if (document.getElementById("in").checked==true)
		category = "Incoming";
	else
		category = "Outgoing";

	if (filter == ""){
		form.innerHTML="";
	}
	else if (filter == "type"){
		var string = "<select name='type'>\
		<option value='Ordinary'> Ordinary </option>\
		<option value='Registered'> Registered </option>";
		if (category=="Incoming")
			string = string + "<option value='Package'> Package </option>";
		string = string + "</select>";
		form.innerHTML = string;
	}
	else if (filter == "location"){
		if (category=="Incoming"){
			var arr = new Array();
			<?php
				$query = mysqli_query ($con, "SELECT DISTINCT department FROM department_list");
				$i=0;
				while ($row = mysqli_fetch_array ($query)){
					$value = $row['department'];
					echo "arr.push('$value');";
				} 
			?>
			var string = "<select name='location'><option value='Not Specified'> Not Specified </option>";
			for (var i=0; i<arr.length; i++){
				string = string + "<option value='"+ arr[i] +"'>" + arr[i] + "</option>";
			}
			string = string + "</select>";
			form.innerHTML = string;
		}
		else {

			var arr = new Array();
			<?php
				$query = mysqli_query ($con, "SELECT DISTINCT region FROM rate");
				$i=0;
				while ($row = mysqli_fetch_array ($query)){
					$value = $row['region'];
					echo "arr.push('$value');";
				} 
			?>
			var string = "<select name='location'>";
			for (var i=0; i<arr.length; i++){
				string = string + "<option value='"+ arr[i] +"'>" + arr[i] + "</option>";
			}
			string = string + "</select>";
			form.innerHTML = string;
		}
	}
	else if (filter == "date"){
		var string = "<select id='month' name='m' onChange='changemonth()'>"
	string = string + "<option value=''> </option>";
	for (var i=1; i<=12; i++){
		var x = i;
		if (i<10)
			x  = "0" + i;
		string = string + "<option value='"+x+"'>"+ x + "</option>";
	}
	string = string + "</select><select id='day' name='d'>\
	</select>\
	<select id='year' name='y' onChange='changemonth()'>";
	string = string + "<option value=''> </option>";
	for (i=0; i<15; i++){
		x = (<?php echo date('Y');?> - 5) + i;
		string = string + "<option value='"+x+"'>"+ x + "</option>";
	}
	string = string + "</select>\
	<a href='#' onClick='today()'> today </a> *mm/dd/yyyy";
	form.innerHTML = string;
	changemonth();
	today();
	}
	else if (filter == "name"){
		form.innerHTML = "<input type='text' name='name'>";
	}
	else if (filter == "status"){
		form.innerHTML = "<select name='status'> <option value='0'> UNCLAIMED </option> <option value='1'> CLAIMED </option> </select>"; 
	}
}
</script>
<script>
function changemonth() {
	var size = 31;
	var m = document.getElementById("month").value;
	var d = document.getElementById("day").value;
	var y = checkyear();
	if (m=="02"){
		if (y==1)
			size = 29;
		else
			size = 28;
	}
	else if (m=="04"||m=="06"||m=="09"||m=="11")
		size = 30;

	var string = "<option value=''> </option>";
	var i, x;
	for (i=1; i<=size; i++ ) {
		if (i<10)
			x = "0" + i;
		else
			x = i;
		string = string + "<option value='" + x + "'";
		if (x==d)
			string = string + "selected";
		string = string + ">" + x + " </option>";
	}
	document.getElementById("day").innerHTML = string;
}
function checkyear() {
	var y = document.getElementById("year").value;
	if (y%400==0)
		return 1;
	else if (y%100==0) 
		return 0;
	else if (y%4==0) 
		return 1;
	else
		return 0;
}

function today() {
	var m = "<?php echo date('m'); ?>";
	var y = "<?php echo date('Y'); ?>";
	var d = "<?php echo date('d'); ?>";
	document.getElementById("day").value = d; 
	document.getElementById("month").value = m;
	document.getElementById("year").value = y;
}
</script>