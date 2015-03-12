<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect($con);
if (!isset($_GET['Mail_ID']))
	header("location:search.php");

foreach ($_GET['Mail_ID'] as $value){
	$mail_id = $value;
	break;
}

$query = mysqli_query ($con, "SELECT * FROM mail WHERE Mail_ID='$mail_id'");
$row = mysqli_fetch_array($query);

if ($row['Category'] == "Incoming"){
	$query2 = mysqli_query ($con, "SELECT * FROM incoming WHERE Mail_ID='$mail_id'");
	$row2 = mysqli_fetch_array($query2);
}
else {
	$query2 = mysqli_query ($con, "SELECT * FROM outgoing WHERE Mail_ID='$mail_id'");
	$row2 = mysqli_fetch_array($query2);
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
    body { font-size: 62.5%; }
    label, input { display:block; }
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
var category = $( "#category" ),  
	mid = $( "#mid" ), 
    mailnumber = $( "#mail_number" ),
	id = $( "#id" ),
	destination = $( "#destination" ),
	destinations = $( "#region" ),
	mailtype = $( "#type2" ),
	sender = $( "#sender_name" ),
	day = $( "#day" ),
	month = $( "#month" ),
	year = $( "#year" ),
	recipient = $( "#recipient_name" ),
	weight = $( "#weight" ),
	cost = $( "#cost" );
 var x;

$(function() {
	$( "#note" ).dialog({
      resizable: false,
      draggable: false,
      autoOpen: false,
      height: 100,
      width: 100,
      modal: true,
    });
    $( "#in" ).dialog({
      resizable: false,
      draggable: false,
      autoOpen: false,
      height: 570,
      width: 300,
      modal: true,
      title: "Incoming Form",
      buttons: {
        "Send Notification": function() {
             var d=$( "#date2" ), c=$( "#category2" );
        	  $.get("email.php", {category: c.val(),id: x,date: d.val(), scase:"edit"},
        	  	function(data)
        	  	{
        	  		if(data=="true")
        	  		{
        	  			document.getElementById('msg').innerHTML="Notification was Successfully send!";
        	  			setInterval(function(){$( "#note" ).dialog( "close" );},3000);
        	  		}
        	  		else
        	  		{
        	  			document.getElementById('msg').innerHTML="Notification was Not Successfully send!";
        	  			setInterval(function(){$( "#note" ).dialog( "close" );},3000);
        	  		}
        	  	}
        	  );
              $("#note").dialog("open");
        },
        "Back to Home": function() {
        	window.location.replace("index.php");
          $( this ).dialog( "close" );
        }
      }
    });
	
	$( "#out" ).dialog({
      resizable: false,
      draggable: false,
      autoOpen: false,
      height: 570,
      width: 300,
      modal: true,
      title: "Outgoing Form",
      buttons: {
        "Send Notification": function() {
        	  var d=$( "#date3" ), c=$( "#category3" );
        	  $.get("email.php", {category: c.val(),id: x,date: d.val(), scase:"edit"},
        	  	function(data)
        	  	{
        	  		if(data=="true")
        	  		{
        	  			document.getElementById('msg').innerHTML="Notification was Successfully send!";
        	  			setInterval(function(){$( "#note" ).dialog( "close" );},3000);
        	  		}
        	  		else
        	  		{
        	  			document.getElementById('msg').innerHTML="Notification was Not Successfully send!";
        	  			setInterval(function(){$( "#note" ).dialog( "close" );},3000);
        	  		}
        	  	}
        	  );
              $("#note").dialog("open");
        },
        "Back to Home": function() {
        	window.location.replace("index.php");
          $( this ).dialog( "close" );
        }
      }
    });

    $( "#submit" )
      .button()
      .click(function() {
      	category = $( "#category" ),
      	mid = $( "#mid" ),  
	    mailnumber = $( "#mail_number" ),
		id = $( "#id" ),
		destination = $( "#destination" ),
		destinations = $( "#region" ),
		mailtype = $( "#type" ),
		sender = $( "#sender_name" ),
		day = $( "#day" ),
		month = $( "#month" ),
		year = $( "#year" ),
		recipient = $( "#recipient_name" ),
		weight = $( "#weight" ),
		cost = $( "#cost" );
		if(category.val()=="Incoming")
		{
			$.get("editresult.php", {Category: category.val(),Mail_ID: mid.val(),Mail_Number: mailnumber.val(),ID_Number: id.val(),Destination: destination.val(),Mail_Type: mailtype.val(),Sender_Name: sender.val(),d: day.val(),m: month.val(),y: year.val()},
			function(b)
			{
      			x=b.id;
				document.getElementById('category2').value=category.val();
				document.getElementById('mailnumber2').value=mailnumber.val();
		      	document.getElementById('id2').value=id.val();
		      	document.getElementById('destination2').value=destination.val();
		      	document.getElementById('mailtype2').value=mailtype.val();
		      	if(sender.val()=="")
		      	{
		      		sender.val("Not specified");
		      	}
		      	document.getElementById('sender2').value=sender.val();
		      	document.getElementById('recipient2').value=b.name;
		      	var d=month.val() +"/"+ day.val() +"/"+ year.val()
		      	document.getElementById('date2').value=d;
      		}
      		);
    	    $( "#in" ).dialog( "open" );
		}
		else
		{
			$.get("editresult.php", {Category: category.val(),Mail_ID: mid.val(),ID_Number: id.val(),Recipient_Name: recipient.val(),Destination: destinations.val(),Mail_Type: mailtype.val(),d: day.val(),m: month.val(),y: year.val(),Weight: weight.val(),Total_Cost: cost.val()},
      		function(a)
      		{
      			x=a.id;
				document.getElementById('category3').value=category.val();
		      	document.getElementById('id3').value=id.val();
		      	document.getElementById('sender3').value=a.name;
		      	if(recipient.val()=="")
		      	{
		      		recipient.val("Not specified");
		      	}
		      	document.getElementById('recipient3').value=recipient.val();
		      	document.getElementById('destination3').value=destinations.val();
		      	document.getElementById('mailtype3').value=mailtype.val();
		      	var d=month.val() +"/"+ day.val() +"/"+ year.val()
		      	document.getElementById('date3').value=d;
		      	document.getElementById('weight3').value=weight.val();
		      	document.getElementById('cost3').value=cost.val();
      		}
      		);
        $( "#out" ).dialog( "open" );
		}
      });
});
</script>
<body style="font-size:62.5%">
<div id="note">
	<p id='msg'>Please Wait...</p>
</div>
<div id="in">
	Category: <input type="text" style="border:none;" name="category2" id="category2" readonly></input><br>
	ID Number: <input type="text" style="border:none;" name="id2" id="id2" readonly></input><br>
	Recipient: <input type="text" style="border:none;" name="recipient2" id="recipient2" readonly></input><br>
	Sender: <input type="text" style="border:none;" name="sender2" id="sender2" readonly></input><br>
	Destination: <input type="text" style="border:none;" name="destination2" id="destination2" readonly></input><br>
	Mail Number: <input type="text" style="border:none;" name="mailnumber2" id="mailnumber2" readonly></input><br>
	Mail Type: <input type="text" style="border:none;" name="mailtype2" id="mailtype2" readonly></input><br>
	Date: <input type="text" style="border:none;" name="date2" id="date2" readonly></input><br>
</div>
<div id="out">
	Category: <input type="text" style="border:none;" name="category3" id="category3" readonly></input><br>
	ID Number: <input type="text" style="border:none;" name="id3" id="id3" readonly></input><br>
	Sender: <input type="text" style="border:none;" name="sender3" id="sender3" readonly></input><br>
	Recipient: <input type="text" style="border:none;" name="recipient3" id="recipient3" readonly></input><br>
	Destination: <input type="text" style="border:none;" name="destination3" id="destination3" readonly></input><br>
	Mail Type: <input type="text" style="border:none;" name="mailtype3" id="mailtype3" readonly></input><br>
	Date: <input type="text" style="border:none;" name="date3" id="date3" readonly></input><br>
	Weight: <input type="text" style="border:none;" name="weight3" id="weight3" readonly></input><br>
	Cost: <input type="text" style="border:none;" name="cost3" id="cost3" readonly></input><br>
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
<div style=" position:relative; width:500px; display:block; margin: 0 auto;">
		<div class="container" style="margin-top:85px;">
		<div class="form_inner">
			<form action="editresult.php" method="GET" name="ed">
			<label for="category">Category</label>
			<input id="category" class="sizeBox add shad" type="text" name="Category" value="<?php echo $row['Category']?>" readonly>
			<br/><br/><br/>
			<label for="mid">Mail ID</label>
			<input id="mid"  class="sizeBox add shad"  type="text" name="Mail_ID" value="<?php echo $mail_id ?>" readonly>
			<br/><br/><br/>
			<label for="id">ID Number</label>
			<input id="id"  class="sizeBox add shad" type="text" name="ID_Number" value="<?php echo $row2['ID_Number']?>" readonly>
			<br/><br/><br/>
	<?php 
	if ($row['Category']=="Incoming"){
		?>
		<label for='mailnum'>Mail Number</label>
			<input id='mail_number' class='sizeBox add shad' type='text' name='Mail_Number' value='<?php echo $row2['Mail_Number']?>'>
			<br/><label style='display:block' class='datemar'> Date: </label>
			<select style='width:50px' id='month' name='m' onChange='changemonth()'>";
		<?php
		for ($i=1; $i<=12; $i++){
			$x = date ('m', mktime(0,0,0,$i));
			echo "<option value='".$x."'> $x </option>";
		}
		?>
		</select>
		<select id='day' style='width:50px' name='d'>
		</select>
		<select id='year'  style='width:75px' name='y' onChange='changemonth()'>";
		<?php
		for ($i=0; $i<15; $i++){
			$x = (date('Y') - 5) + $i;
			echo "<option value='".$x."'> $x </option>";
		}
		?>
		</select>
		<a class='see_more' href='#'onClick='today()'> today </a> <a class='see_more' href='#'onClick='reset()'> reset </a>
			<br/>
			<label>Sender Name:</label> <input type='text' id="sender_name" class='shad sizeBox add' name='Sender_Name' value='<?php echo $row2['Sender_Name'] ?>'> <br>
			<br/><br/> 
		<label> Mail Type: </label> <select name='Mail_Type' class='shad' id='type' onChange='checktype()'>
		<?php
		echo "<option value ='Ordinary'"; 
		if ($row['Mail_Type']=="Ordinary") echo "selected='selected'"; 
		echo "> Ordinary </option>
		<option value ='Registered'";
		if ($row['Mail_Type']=="Registered") echo "selected='selected'";
		echo "> Registered </option>
		<option value ='Package'";
		if ($row['Mail_Type']=="Package") echo "selected='selected'";
		echo "> Package </option>";
		?>
		</select>
			<label> Department/Office: </label>
			<select id='destination' name='Destination' >
					<?php
					echo "<option value='Not Specified'"; if ($row2['Department']=="Not Specified") echo"selected"; echo">Not Specified</option>";
					$query3 = mysqli_query($con, "SELECT department FROM department_list ORDER BY department");
					while ($row3 = mysqli_fetch_array($query3)){
						echo "<option value='".$row3['department']."'"; if ($row2['Department']==$row3['department']) echo "selected"; echo ">".$row3['department']."</option>";
					}
					?> 
			</select>
			<br>
			<?php
	}
	else {
		?>
		<label style='display:block' class='datemar'> Date: </label> 
		<select id='month' style='width:50px' name='m' onChange='changemonth()'>";
		<?php
		for ($i=1; $i<=12; $i++){
			$x = date ('m', mktime(0,0,0,$i));
			echo "<option value='".$x."'> $x </option>";
		}
		?>
		</select>
		<select id='day' style='width:50px' name='d'>
		</select>
		<select id='year' style='width:75px' name='y' onChange='changemonth()'>";
		<?php
		for ($i=0; $i<15; $i++){
			$x = (date('Y') - 5) + $i;
			echo "<option value='".$x."'> $x </option>";
		}
		?>
		</select>
		<a class="see_more" href='#'onClick='today()'> today </a> <a class="see_more" href='#'onClick='reset()'> reset </a>
		<br/> 
		<label> Recipient Name: </label> <input type='text' class='sizeBox add shad' id="recipient_name" name='Recipient_Name' value='<?php echo $row2['Recipient_Name']?>'>
		<br/> <br/> <br/> <label> 
		Mail Type: </label> <select name='Mail_Type' class='shad' id='type' onChange='checktype()' 'onclick='ccc()''>";
		<?php
		$query3=mysqli_query($con,"SELECT DISTINCT type FROM rate");
		while ($row3 = mysqli_fetch_array($query3)) {
		echo "<option value='".$row3['type']."'";
		if ($row3['type']==$row['Mail_Type']) echo "selected='selected'";
		echo">".$row3['type']."</option>";
		}
		?>
		</select> <label>Type Category:</label> <select id='cat' name='type_category' onclick='ccc()'>";
		<?php
		$query3=mysqli_query($con,"SELECT DISTINCT category FROM rate");
		while ($row3 = mysqli_fetch_array($query3)) {
		echo "<option value='".$row3['category']."'";
		$a = $row['Mail_Type']; $b = $row2['Destination']; $c = $row2['Weight'];
		$query4 = mysqli_query($con, "SELECT category FROM rate WHERE type='$a' AND region='$b' AND weight='$c'");
		$row4 = mysqli_fetch_array($query4);
		if ($row3['category']==$row4['category']) echo "selected='selected'";
		echo ">".$row3['category']."</option>";
		}
		?>
		</select><br/>
		<label> Destination: </label> <select id='region' name='Destination' class='sizeBox shad' onclick='ccc()'>";
		<?php
		$query3=mysqli_query($con,"SELECT DISTINCT region FROM rate");
		while ($row3 = mysqli_fetch_array($query3)) {
		echo "<option value='".$row3['region']."' ";
		if ($row3['region']==$row2['Destination']) echo "selected='selected'";	
		echo">".$row3['region']."</option>";
		}
		?>
    	</select> 
    	<label>Weight: </label> <select name='Weight' id='weight' class='light shad' onclick='ccc()'>";
		<?php
		$query3=mysqli_query($con,"SELECT DISTINCT weight FROM rate");
		while ($row3 = mysqli_fetch_array($query3)) {
		echo "<option value='".$row3['weight']."' ";
		if ($row3['weight']==$row2['Weight']) echo "selected='selected'";
		echo ">".$row3['weight']."</option>";
		}
		?>
		</select>
		<label> Total Cost: </label> <input type='text' id='cost' name='Total_Cost' class='sizeBox3 shad' readonly>
	<?php
	}
	?>
<span> <button id="submit" class="add ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="submit" form="">SUBMIT</button></span>
<br/>
<span> <a href="index.php" style="float:left; margin-top:-10px "> Back to Home </a></span>
</form>
</div>
</div>

<script>
	var ftype = document.getElementById("type").value;
	var fnum = document.getElementById("mail_number").value;
	checktype();
	function checktype(){
		var type = document.getElementById("type");
		var num = document.getElementById("mail_number");

		if (type.value == "Ordinary"){
			num.removeAttribute("required");
			if (ftype == type.value)
				num.value = fnum;
			else {
				num.placeholder = "*ordinary mail need no input";
				num.value = "";
			}
			num.setAttribute("readonly", "readonly");
		}
		else {
			num.setAttribute("required", "required");
			if (type.value == ftype)
				num.value = fnum;
			else {
				num.placeholder = "Mail Number";
				num.value = "";
			}
			num.removeAttribute("readonly");
		}
	}
</script>
<script>
	ccc();
	function ccc()
	{
		var cat = document.getElementById('cat').value;
		var type = document.getElementById('type').value;
		var weight = document.getElementById('weight').value;
		var region = document.getElementById('region').value;
		$.post("ccc.php", {cat: cat,type: type,weight: weight,region: region},function(data){document.forms["ed"]["Total_Cost"].value=data;});

		$.post("aaa.php", {type: type, change:"category", select:cat},function(data){document.getElementById('cat').innerHTML=data;});
		$.post("aaa.php", {cat: cat, change:"region", select:cat},function(data){document.getElementById('region').innerHTML=data;});
		$.post("aaa.php", {cat: cat, change:"weight", select:weight},function(data){document.getElementById('weight').innerHTML=data;});
		
		document.getElementById('cost').value = "calculating...";
		
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
			
			a = document.getElementById('weight').value;
			document.getElementById('weight').value = weight;
			if (document.getElementById('weight').value==""){
				document.getElementById('weight').value = a;
				weight = a;
			}

			a = document.getElementById('region').value;
			document.getElementById('region').value = region;
			if (document.getElementById('region').value==""){
				document.getElementById('region').value = a;
				region = a;
			}
			
			$.post("ccc.php", {cat: cat,type: type,weight: weight,region: region},function(data){ document.forms["out"]["Total_Cost"].value=data;});

		}, 1000);
	}
	</script>
<script src="js/date.js"> </script>
<script>
changemonth ();
reset ();
function today() {
	var m = "<?php echo date('m'); ?>";
	var y = "<?php echo date('Y'); ?>";
	var d = "<?php echo date('d'); ?>";
	document.getElementById("day").value = d; 
	document.getElementById("month").value = m;
	document.getElementById("year").value = y;
}
function reset(){
	var cat = "<?php echo $row['Category']; ?>";
	if (cat=="Incoming"){
		var m = "<?php if (isset($row2['Month_Received'])) echo $row2['Month_Received']; ?>";
		var d = "<?php if (isset($row2['Day_Received'])) echo  $row2['Day_Received']; ?>";
		var y = "<?php if (isset($row2['Year_Received'])) echo $row2['Year_Received']; ?>";
	}
	else {
		var m = "<?php if (isset($row2['Month_Sent'])) echo $row2['Month_Sent']; ?>";
		var d = "<?php if (isset($row2['Day_Sent'])) echo $row2['Day_Sent']; ?>";
		var y = "<?php if (isset($row2['Year_Sent'])) echo $row2['Year_Sent']; ?>";
	} 
	document.getElementById("day").value = d; 
	document.getElementById("month").value = m;
	document.getElementById("year").value = y;
}
</script>
	</div>
	<div class="footer"></div>
</body>
</html>