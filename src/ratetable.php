<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect ($con);
?>
<?php
if(isset($_GET['add'])){
	$type = $_GET['t'];
	$cat = $_GET['c'];
	$region = $_GET['r'];
	$min = $_GET['min'];
	$max = $_GET['max'];
	$rate = $_GET['rate'];

	if ($cat=="new")
		$cat = $_GET['newcat'];

	if ($region=="new")
		$region = $_GET['newregion'];

	$weight = $min." to ".$max." grams";

	if ($min=='n/a'||$min=='')
		$weight = 'n/a';

	mysqli_query($con,"INSERT INTO rate (type, category, region, weight, rate ) VALUES ('$type', '$cat', '$region', '$weight', '$rate')");

	echo "Added New data <br>";
}
if(isset($_GET['delete'])){
	$id = $_GET['delete'];
	mysqli_query($con, "DELETE FROM rate WHERE rid='$id'");
	echo "Deleted Data";
}
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/mystyle.css">
	<link rel="stylesheet" type="text/css" href="styles/style-slide.css">
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui.js"></script>
	<style>
		input[type="text"]
		{
			width: 50px;
		}
	</style>
</head>
<body>

	<div class="header-cont-small header-small"> 
<img style="float:left; margin-left:80px;" class="center-logo" src="images/logo150.png">

</div>

<div style=" position:relative; width:700px; display:block; margin: 0 auto;">
	<div class="container" style="margin-top:125px;">
<form method='GET' action='ratetable.php'>
	<div class="form_inner">
<label > Mail Type: </label>  
<select id='type' name='Mail_Type' onclick='ccc()'>
<?php
$query=mysqli_query($con,"SELECT DISTINCT type FROM rate");
while ($row = mysqli_fetch_array($query)) {
	echo "<option value='".$row['type']."'>".$row['type']."</option>";
}
?>
</select>
<label>Category:</label> <select id='cat' name='type_category' onclick='ccc()'>
<?php				
$query=mysqli_query($con,"SELECT DISTINCT category FROM rate");
while ($row = mysqli_fetch_array($query)) {
	echo "<option value='".$row['category']."'>".$row['category']."</option>";
}
?>
</select>
<label>Region:</label> <select id='region' name='Destination' onclick='ccc()'>
<?php
$query=mysqli_query($con,"SELECT DISTINCT region FROM rate");
while ($row = mysqli_fetch_array($query)) {
	echo "<option value='".$row['region']."'>".$row['region']."</option>";
}
?>
</select>
<br><br>
<input type='submit' name='submit' value='go' id='submit' class='see_more' style='float:right;'> 
</div>
</form>


<?php
if(isset($_GET['submit'])){
	$type = $_GET['Mail_Type'];
	$cat = $_GET['type_category'];
	$region = $_GET['Destination'];

	echo "<br>Categories: ".$type." ".$cat." ".$region."<br>";

	$query = mysqli_query($con, "SELECT * FROM rate WHERE type='$type' AND category='$cat' AND region='$region'");
	?>

	<table cellpadding="5" border="1" width="100%" style="text-align:center">
			<tr>
				<td>Mail Type</td>
				<td>Category</td>
				<td>Region</td>
				<td>Weight</td>
				<td>Rate</td>
				<td>DELETE</td>
			</tr>
			<?php
			while ($row=mysqli_fetch_array($query)){
				echo "<tr>";
				echo "<td>".$row['type']."</td>";
				echo "<td>".$row['category']."</td>";
				echo "<td>".$row['region']."</td>";
				echo "<td>".$row['weight']."</td>";
				echo "<td>".$row['rate']."</td>";
				echo "<td><form method='GET' action='ratetable.php'><button value='".$row['rid']."' name='delete'> delete </button></form></td>";
				echo "</tr>";
			}
			?>
			<tr>
			<form action='ratetable.php' method='GET'>
				<td><select id='type2' name='t'>
		<?php
		$query=mysqli_query($con,"SELECT DISTINCT type FROM rate");
		while ($row = mysqli_fetch_array($query)) {
			echo "<option value='".$row['type']."'>".$row['type']."</option>";
		}
		?>
		</select>
		 </td>
				<td><select id='cat2' name='c' onclick='cat()'>
				<option value=''> </option>
				<option value='new'> NEW </option>
		<?php				
		$query=mysqli_query($con,"SELECT DISTINCT category FROM rate");
		while ($row = mysqli_fetch_array($query)) {
			if ($row['category']!='')
			echo "<option value='".$row['category']."'>".$row['category']."</option>";
		}
		?>
		</select> <span id='newcat' style="visibility:hidden; "></span> </td>
				<td><select id='region2' name='r' style="margin-left:3p0x;" onclick='region()'>
				<option value=''> </option>
				<option value='new'> NEW </option>
		<?php
		$query=mysqli_query($con,"SELECT DISTINCT region FROM rate");
		while ($row = mysqli_fetch_array($query)) {
			echo "<option value='".$row['region']."'>".$row['region']."</option>";
		}
		?>
		</select> <span id='newregion' style="visibility:hidden"><input type='text' name='newregion' required></span></td>
				<td>
					<input type='text' name='min'> to <input type='text' name='max'> g
				</td>
				<td>
					<input type='text' name='rate' required> php
				</td>
				<td>
					<input type='submit' name='add' value='add'>
				</td>
			</form>
			</tr>
</table>
</div></div>
	<?php
}
?>

<script>
function cat(){
	if (document.getElementById('cat2').value=="new"){
		document.getElementById('newcat').style.visibility="visible";
	}
	else
		document.getElementById('newcat').style.visibility="hidden";
}
function region(){
	if (document.getElementById('region2').value=="new"){
		document.getElementById('newregion').style.visibility="visible";
	}
	else
		document.getElementById('newregion').style.visibility="hidden";
}
</script>

<script>
ccc();
function ccc(){
		var cat = document.getElementById('cat').value;
		var type = document.getElementById('type').value;
		var region = document.getElementById('region').value;

		$.post("aaa.php", {type: type, change:"category", select:cat},function(data){document.getElementById('cat').innerHTML=data;});
		$.post("aaa.php", {cat: cat, change:"region", select:cat},function(data){document.getElementById('region').innerHTML=data;});

		setTimeout(function(){
			var a = document.getElementById('cat').value;
			document.getElementById('cat').value = cat;
			if (document.getElementById('cat').value==""){
				document.getElementById('cat').value = a;
				cat = a;
			}
			
			a = document.getElementById('type').value;
			document.getElementById('type').value = type;
			if (document.getElementById('type').value==""){
				document.getElementById('type').value = a;
				type = a;
			}

			a = document.getElementById('region').value;
			document.getElementById('region').value = region;
			if (document.getElementById('region').value==""){
				document.getElementById('region').value = a;
				region = a;
			}
		}, 1000);

}
</script>
</body>
</html>