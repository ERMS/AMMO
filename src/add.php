<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect($con);

function getid($search){
	$count=0;
	$person = explode(';', $search);
	$person = array_map( 'trim', $person);
	foreach ($person as $value) {
		if ($count==1)
			$id = $value;
		$count++;
	}
	return $id;
}

if (isset($_GET['search'])){
	$id=getid($_GET['search']);
	if ($_GET['category']=="incoming")
		header("location:incoming.php?id_number=".$id);
	else
		header("location:outgoing.php?id_number=".$id);
}
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/mystyle.css">
	<link rel="stylesheet" type="text/css" href="styles/style-slide.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
</head>
<script>
<?php
$con=adzudb();
$suggest="";
$hint=array();$i=0;
$query=mysqli_query($con,"SELECT ID_Number, First_Name, Last_Name, Department_Name FROM amodb.Person UNION SELECT ID_Number, First_Name, Last_Name, Department_Name FROM psuedoadzudb.person");
while($row=mysqli_fetch_array($query))
{
	$hint[$i]=$row['Last_Name'].", ".$row['First_Name']." (".$row['Department_Name'].") ; ".$row['ID_Number'];
	$i++;
}
$s=count($hint);
?>
$(function() {
    var availableTags = [
    <?php 
    for($x=0;$x<$s;$x++)
    {
    	echo "'".$hint[$x]."',";
    }
    ?>
    ];
    $( "#sizeVer" ).autocomplete({
      source: availableTags
    });
});

function checkinput()
{
	<?php 
    for($x=0;$x<$s;$x++)
    {
    	echo 
    	"if (document.forms['validate']['search'].value == '".$hint[$x]."' ) {
    		return true;
    	}";
    }
    ?>
    alert(document.forms["validate"]["search"].value + " is not found in the database. Pls select from the suggestions");
    return false;
}

$('#btn').click(function() {
    var pos = $('.shad').offset();
    pos.top += $('.shad').width();
    $('#drop').fadeIn(100);
    return false;
});

$('#drop').click(function() {
    $('.shad').val($(this).text());
    $(this).parent().fadeOut(100);
});
</script>
<body>
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
		<div style="; margin-top:150px; margin-left:150px; width:800px;"  class="container">
			<div style=" text-align:center;">
				<form  action="add.php" method="GET" onsubmit="return checkinput()" name="validate">
				<div class="form_inner">
				<br/>
				<input required  class="shad f" name="search" id="sizeVer" type="text"  placeholder="Enter Name" >
				<br><br>
				<div style="margin-left:140px; width:500px;" >
					<input  type="submit" value="incoming" name="category" style="height:30px" id="submit"/>
				<input  type="submit" value="outgoing" name="category"  style="height:30px" id="submit"/></div>
				</form>
					
				</div>
			</div>
		</div>
</div>

<div class="footer">
</div>
</body>
</html>