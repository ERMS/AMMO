<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect($con);
include "function/resultfunc.php";
/*if (isset($_GET['id_number']))
	$_SESSION['id']=$_GET['id_number'];*/
if (!isset($_GET['id_number'])||$_GET['id_number']=="")
	header("location:add.php");
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
    input.text { margin-bottom:12px; width:100%; padding: .4em; }
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
	id = $( "#id_number" ),
	recipient = $( "#recipient_name" ),
    destination = $( "#region" ),
	mailtype = $( "#type" ),
	day = $( "#day" ),
	month = $( "#month" ),
	year = $( "#year" ),
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
    $( "#added" ).dialog({
      resizable: false,
      draggable: false,
      autoOpen: false,
      height: 570,
      width: 300,
      modal: true,
      title: "Outgoing Form",
      buttons: {
        "Send Notification": function() {
        	  var d=$( "#date2" ), c=$( "#category2" );
        	  $.get("email.php", {category: c.val(),id: x,date: d.val()},
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
		id = $( "#id_number" ),
		recipient = $( "#recipient_name" ),
	    destination = $( "#region" ),
		mailtype = $( "#type" ),
		day = $( "#day" ),
		month = $( "#month" ),
		year = $( "#year" ),
		weight = $( "#weight" ),
		cost = $( "#cost" );

      	$.get("addresult.php", {Category: category.val(),ID_Number: id.val(),Recipient_Name: recipient.val(),Destination: destination.val(),Mail_Type: mailtype.val(),d: day.val(),m: month.val(),y: year.val(),Weight: weight.val(),Total_Cost: cost.val()},
      		function(a)
      		{
      			x=a.id;
				document.getElementById('category2').value=category.val();
		      	document.getElementById('id2').value=id.val();
		      	document.getElementById('sender2').value=a.name;
		      	if(recipient.val()=="")
		      	{
		      		recipient.val("Not specified");
		      	}
		      	document.getElementById('recipient2').value=recipient.val();
		      	document.getElementById('destination2').value=destination.val();
		      	document.getElementById('mailtype2').value=mailtype.val();
		      	var d=month.val() +"/"+ day.val() +"/"+ year.val()
		      	document.getElementById('date2').value=d;
		      	document.getElementById('weight2').value=weight.val();
		      	document.getElementById('cost2').value=cost.val();
      		}
      		);
      	$( "#added" ).dialog( "open" );
      });
});
</script>
<body>
<div id="note">
	<p id='msg'>Please Wait...</p>
</div>
<div id="added">
	Category: <input type="text" style="border:none;" name="category2" id="category2" readonly></input><br>
	ID Number: <input type="text" style="border:none;" name="id2" id="id2" readonly></input><br>
	Sender: <input type="text" style="border:none;" name="sender2" id="sender2" readonly></input><br>
	Recipient: <input type="text" style="border:none;" name="recipient2" id="recipient2" readonly></input><br>
	Destination: <input type="text" style="border:none;" name="destination2" id="destination2" readonly></input><br>
	Mail Type: <input type="text" style="border:none;" name="mailtype2" id="mailtype2" readonly></input><br>
	Date: <input type="text" style="border:none;" name="date2" id="date2" readonly></input><br>
	Weight: <input type="text" style="border:none;" name="weight2" id="weight2" readonly></input><br>
	Cost: <input type="text" style="border:none;" name="cost2" id="cost2" readonly></input><br>
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
	<form action="addresult.php" method="GET" name="out">
			<div class="form_inner">
				<label for="category">Category</label>
				<input id="category" type="text" name="Category" value="Outgoing" readonly/>
				<br/>
				<label for="id_number">ID Number</label>
				<input id="id_number" type="text" placeholder="ID Number" name="ID_Number" value="<?php echo $_GET['id_number']; ?>" readonly/>
				<br/>
				<label class='datemar' style="display:block"> Date(mm/dd/yyyy) </label>
				<select id='month' style="width:50px" name='m' onChange='changemonth()'>
				<?php
					for ($i=1; $i<=12; $i++){
						$x = date ('m', mktime(0,0,0,$i));
						echo "<option value='".$x."'> $x </option>";
					}
				?>
				</select>
				<select id='day' style="width:50px" name='d'>
				</select>
				<select id='year' style="width:75px" name='y' onChange='changemonth()'>
				<?php
					for ($i=0; $i<15; $i++){
						$x = (date('Y') - 5) + $i;
						echo "<option value='".$x."'> $x </option>";
					}
				?>
				</select>
				<a class="see_more"href="#" onClick='today()'> today </a>
				<br/>
				<label for="recipient_name">Recipient Name</label>
				<input id="recipient_name" type="text" placeholder="Recipient Name" name="Recipient_Name"/>
				
				<?php
				echo " <br/><label > Mail Type: </label>  <select id='type' name='Mail_Type' onclick='ccc()'> ";
				$query=mysqli_query($con,"SELECT DISTINCT type FROM rate");
				while ($row = mysqli_fetch_array($query)) {
				echo "<option value='".$row['type']."'>".$row['type']."</option>";
				}
				echo "</select> <label>Type Category:</label> <select id='cat' name='type_category' onclick='ccc()'>";
				$query=mysqli_query($con,"SELECT DISTINCT category FROM rate");
				while ($row = mysqli_fetch_array($query)) {
				echo "<option value='".$row['category']."'>".$row['category']."</option>";
				}
				echo "</select><label>Region:</label> <select id='region' name='Destination' onclick='ccc()'>";
				$query=mysqli_query($con,"SELECT DISTINCT region FROM rate");
				echo mysqli_num_rows($query);
				while ($row = mysqli_fetch_array($query)) {
				echo "<option value='".$row['region']."'>".$row['region']."</option>";
				}
				echo "</select> <label>Weight:</label> <select id='weight' name='Weight' onclick='ccc()'>";
				$query=mysqli_query($con,"SELECT DISTINCT weight FROM rate");
				while ($row = mysqli_fetch_array($query)) {
				echo "<option value='".$row['weight']."'>".$row['weight']."</option>";
				}
				echo "</select>";
				?>

				<label for="cost">Total Cost</label>
				<input id="cost" type="text" name="Total_Cost" readonly/>

				<br/><br/>
				<button id="submit" class="add ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="submit" form="">SUBMIT</button>
				<br/>
			</div>
		</form>
<span> <a id='submits' class='see_more' href="ratetable.php" style="float:left; margin-top:-10px "> Check Rate Table </a></span>
	</div>
	<div style="clear:both"></div>
	</div>

	<script>
	ccc();
	function ccc(){
		var cat = document.getElementById('cat').value;
		var type = document.getElementById('type').value;
		var weight = document.getElementById('weight').value;
		var region = document.getElementById('region').value;

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
today ();
function today() {
	var m = "<?php echo date('m'); ?>";
	var y = "<?php echo date('Y'); ?>";
	var d = "<?php echo date('d'); ?>";
	document.getElementById("day").value = d; 
	document.getElementById("month").value = m;
	document.getElementById("year").value = y;
}
</script>
<div class="footer"></div>
</body>
</html>