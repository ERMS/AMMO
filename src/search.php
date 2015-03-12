<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect ($con);

if (isset($_GET['Mail_ID'])){
	if ($_GET['action']=="delete")
		header("location:delete.php?".$_SERVER['QUERY_STRING']);
	else
		header("location:edit.php?".$_SERVER['QUERY_STRING']);
}
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/mystyle.css">
	<link rel="stylesheet" type="text/css" href="styles/style-slide.css">
	<link rel="stylesheet" href="styles/jquery-ui.css">
	<meta charset="utf-8">
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
</head>
<style>
    body {  }
    input.text { margin-bottom:12px; width:100%;}
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
    .ui-dialog-titlebar-close {
  visibility: hidden;
}
</style>
<script>
function sss()
{
	return false;
}
$(function() {
	var x=$( "#id1" );
	var d=$( "#date1" );
	var c=$( "#cat1" );
	$( "#note" ).dialog({
      resizable: false,
      draggable: false,
      autoOpen: false,
      height: 100,
      width: 100,
      modal: true,
    });

	$( ".resend" )
      .button()
      .click(function() {
      	$("#note").dialog("open");
      	c.value=$("input[name=cat1]", this.form).val();
      	d.value=$("input[name=date1]", this.form).val();
      	x.value=$("input[name=id1]", this.form).val();
      	c.val(c.value);x.val(x.value);d.val(d.value);
        	  $.get("email.php", {category: c.val(),id: x.val(),date: d.val(), scase:"resend" },
        	  	function(data)
        	  	{
        	  		if(data=="true")
        	  		{
        	  			document.getElementById('msg2').innerHTML="<p style='font-size:62.5%; margin-top:-19px; overflow:hidden;'>Notification was Successfully send!</p>";
        	  		}
        	  		else
        	  		{
        	  			document.getElementById('msg2').innerHTML="<p style='font-size:62.5%; margin-top:-19px; overflow:hidden;'>Notification was Not Successfully send! :(( </p>";
        	  		}

        	  		setInterval(function(){$("#note").dialog("close");},3000);
        	  		setInterval(function(){document.getElementById('msg2').innerHTML="Please Wait...";},3000);
        	  	}
        	  );
      	});
      
  });
</script>
<script>
$(document).ready(function(){
  $("#selectall").click(function(){
    $("input:checkbox").prop("checked",this.checked);
  });
});

function fff()
{
	var x=document.getElementById("selectall").checked;
	var y=document.getElementById("ed").checked;
	var cbox = document.forms["form1"];
	var z = 0;
	for (var j = 0; j < cbox.elements.length; j++)
	{
	    if (cbox.elements[j].type == "checkbox")
	    {
	        if (cbox.elements[j].checked)
	        {
	            z++;
	        }
	    }       
	}
	if(y==true)
	{	
		if(x==true)
		{
			alert("Select only one from the list.");
			return false;
		}
		
		if(z>1)
		{
			alert("Select only from the list.");
			return false;
		}
		if(z<1)
		{
			alert("Select one from the list.");
			return false;
		}
		if(z==1)
		{
			return true;
		}
	}
	else
	{
		if(z>0)
		{
			var f=confirm("Are you sure you want to delete this items?");
			return f;
		}
		else
		{
			alert("No items Checked.");
		}

	}	
}
</script>
<?php
	if (isset($_GET['search']))
		$_SESSION['searchquery'] = $_GET['search'];
	if (isset($_GET['category']))
		$_SESSION['category'] = $_GET['category'];
	if (isset($_GET['claim'])){
		$id = $_GET['claim'];
		$query = mysqli_query ($con, "SELECT Mail_Status FROM incoming WHERE Mail_ID='$id'");
		$row = mysqli_fetch_array($query);
		if ($row['Mail_Status']==0)
			mysqli_query ($con, "UPDATE incoming SET Mail_Status = 1 WHERE Mail_ID='$id'");
		else
			mysqli_query ($con, "UPDATE incoming SET Mail_Status = 0 WHERE Mail_ID='$id'");
		header("location:search.php");
	}
	if (isset($_GET['filter'])&&$_GET['filter']!=''){
		$filter = $_GET['filter'];
	}
?>
<body>
<div id="note">
	<p id='msg2'>Please Wait...</p>
</div>
<div class="header-cont-small header-small"> 
<img style="float:left; margin-left:80px;" class="center-logo" src="images/logo150.png">

</div>
<div id="nav-right">
	<ul id="right-nav">
	<img class="img-nav" src="images/home.png" width="45px">
	<li><a style="margin-left:40px; " href="index.php">HOME</a></li>
	<img class="img-nav" style="top:55px;" src="images/add.png" width="45px">
	<li ><a  style="margin-left:30px;"href="add.php">ADD</a></li>
	<img class="img-nav" style="top:110px;" src="images/search.png" width="45px">
	<li><a style="margin-left:40px" href="search.php">SEARCH</a></li>
	<img class="img-nav" style="top:165px;" src="images/profile.png" width="45px">
	<li><a style="margin-left:40px" href="profile.php">PROFILE</a></li>
	<img class="img-nav" style="top:220px;" src="images/logout.png" width="45px">
	<li><a style="margin-left:40px" href="profile.php?log=out">LOGOUT</a></li>
	</ul>
</div>
<div style=" position:relative; width:900px; display:block; margin: 0 auto;">

	<div class="container" style="margin-top:80px;  margin-left:80px;">
			
				<form action="search.php" method="GET">
				<input id="textbox" class="shad f" type="text" name="search" placeholder="Search" value = "<?php if (isset($_SESSION['searchquery'])) echo $_SESSION['searchquery']; ?>" /> 
				<input id="button" class="f" style="" type="submit" name="submit" value="search"/>
				<br/>
				
				<input id='in' onclick='cat()' type="radio" name="category" value="Incoming" <?php if (isset($_SESSION['category'])&&$_SESSION['category']!='Incoming'); else echo "checked='checked'" ?>/> Incoming mail
				<input id='out' onclick='cat()' type="radio" name="category" value="Outgoing" <?php if (isset($_SESSION['category'])&&$_SESSION['category']=='Outgoing') echo "checked='checked'" ?>/> Outgoing mail
				
				<br><label for="filter">Filter by:</label> 
				<span id='select'>
				<select id='filter' onChange='change()' name='filter'>
				</select>
				</span>
				<span id='form'> </span> 
				<input type='submit' value='go'><br>

				</form>

			
<?php
$con=amodb();
if (isset($_SESSION['searchquery'])){
	$replace = array (".", ",","/","@","!","%","*","#","+","-","\"","'","}","]","{","[","=","&","?",">","<","~","`","^","$","|");
	$searchquery = str_replace($replace, " ", $_SESSION['searchquery']);
	$keyword = explode(' ',$searchquery);
	$keyword = array_filter($keyword);
	if ($_SESSION['category']=="Incoming"){
		?>
		<form action='search.php' method='GET' name='form1'>
		<input type='radio' id='del' name='action' value='delete' style='float:left'> 
			<span style='float:left'> Delete </span>			
			<input style='float:left' type='radio' id='ed' name='action' value='edit' checked='checked'>
			<span style='float:left'> Edit </span>
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
		//echo "<br>".$string;
		?>
		<span style='float:right; margin-right:20px;' ><a class='see_more' href="Print/printsearch.php?<?php echo $_SERVER['QUERY_STRING']?>"> PRINT</a> </span>
		<?php
		$query = mysqli_query ($con, $string);
		if (mysqli_num_rows($query)>0){
			
			echo "<br>

			<div id='table-wrapper'>
				<div id='table-scroll'>
			
			<table  border='1' width='100%' cellpadding='3' style='text-align:center; font-size:11; display:block; border-collapse:collapse; border:solid rgb(189, 189, 189) 2px;'>
					 <thead >
					  <tr> 
							<td> <input type='checkbox' id='selectall'> </td> 
							<td> Mail_ID </td> 
							<td> ID Number </td> 
							<td> Recipient </td> 
							<td> Mail Number </td>  
							<td> Mail Type </td> 
							<td> Sender </td> 
							<td> Department/Office </td> 
							<td> Date </td> 
							<td> Status </td> 
							<td> Notify </td>
						</tr> 
					</thead>";
			
			while ($row = mysqli_fetch_array($query)){

						echo  "
						<tbody>
						<tr> <td> <input type='checkbox' name='Mail_ID[]' value='".$row['Mail_ID']."'> </td> 
						<td>".$row['Mail_ID']."</td>
						<td>".$row['ID_Number']."</td> 
						<td>".$row['First_Name']." ".$row['Last_Name']."</td>
						<td>".$row['Mail_Number']."</td> 
						<td>".$row['Mail_Type']."</td>
						<td>".$row['Sender_Name']."</td> 
						<td>".$row['Department']."</td> 
						<td>".$row['Month_Received']."/".$row['Day_Received']."/".$row['Year_Received']."</td> 
						<td>"; if ($row['Mail_Status']==0) echo "<a href='search.php?claim=".$row['Mail_ID']."'><button form=''> Claim </button> </a>"; else echo "<a href='search.php?claim=".$row['Mail_ID']."'><button form=''> Unclaim </button></a>";  
						echo "
						<td>
						<form>
						<input type='hidden' id='cat1' name='cat1' value='Incoming' readonly>
						<input type='hidden' id='id1' name='id1' value='".$row['Mail_ID']."' readonly>
						<input type='hidden' id='date1' name='date1' value='".$row['Month_Received']."/".$row['Day_Received']."/".$row['Year_Received']."' readonly>
						<button class='resend' onclick='return sss()'>Resend</button>
						</form>
						</td>
						</tr></tbody>"; 
			}
			
			echo "</table></div></div> 
			<br>
			<input type='submit' onclick='return fff()'> </form>";
			
		}
		else {
			
			echo "<br> <p> There was no data found in incoming mail </p>";
			
		}
	}
	else {
		echo"
			<form action='search.php' method='GET' name='form1' onsubmit='return fff()'> 
			<input type='radio' id='del' name='action' value='delete' style='float:left'> 
			<span style='float:left'> Delete </span>			
			<input style='float:left' type='radio' id='ed' name='action' value='edit' checked='checked'>
			<span style='float:left'> Edit </span>
		";
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
		//echo $string;
		?>
		<span style='float:right; margin-right:20px;'><a class='see_more' href="print/printsearch.php?<?php echo $_SERVER['QUERY_STRING']; ?>"> PRINT </a> </span>
		<?php
		$query = mysqli_query ($con, $string);
		if (mysqli_num_rows($query)>0){
			?>  
			<br>
			<div id='table-wrapper'>
				<div id='table-scroll'>
			<table border='1' width='100%' cellpadding='3' style='text-align:center; border:solid rgb(189, 189, 189) 2px;'> 
				<tr> 
				<td> <input type='checkbox' id='selectall'> </td>
				<td> Mail_ID </td>
				<td> ID Number </td> 
				<td> Sender </td>
				<td> Mail Type </td> 
				<td> Recipient </td>
				<td> Destination </td> 
				<td> Date </td> </tr>
			<?php
			while ($row = mysqli_fetch_array($query)){
				$mailid=$row['Mail_ID'];
				echo  "<tr> <td> <input type='checkbox' id='select' name='Mail_ID[]' value='".$row['Mail_ID']."'> </td> 
				<td>".$row['Mail_ID']."</td>
				<td>".$row['ID_Number']."</td> 
				<td>".$row['First_Name']." ".$row['Last_Name']."</td>
				<td>".$row['Mail_Type']."</td> 
				<td>".$row['Recipient_Name']."</td> 
				<td>".$row['Destination']."</td> 
				<td>".$row['Month_Sent']."/".$row['Day_Sent']."/".$row['Year_Sent']."</td> </tr>";
			}
			?>
			</table></div></div>
			<br>
			<input type='submit'> </form>
			<?php
		}
		else {
			?>
			<br> <p> There was no data found in outgoing mail </p>
			<?php
		}
	}
}
?>
	</div>

</div>
<div class="footer"></div>

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
	for (i=0; i<15; i++){
		x = (<?php echo date('Y');?> - 14) + i;
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
</body>
</html>

