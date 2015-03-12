<?php
include "function/database.php";
$con = amodb();
include "function/logged.php";
redirect($con);
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
    mailnumber = $( "#mail_number" ),
	id = $( "#id_number" ),
	destination = $( "#destination" ),
	mailtype = $( "#type" ),
	sender = $( "#sender_name" ),
	day = $( "#day" ),
	month = $( "#month" ),
	year = $( "#year" );
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
      title: "Incoming Form",
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
      	mailnumber = $( "#mail_number" ),
		id = $( "#id_number" ),
	    destination = $( "#destination" ),
		mailtype = $( "#type" ),
		sender = $( "#sender_name" ),
		day = $( "#day" ),
		month = $( "#month" ),
		year = $( "#year" );

		$.get("addresult.php", {Category: category.val(),Mail_Number: mailnumber.val(),ID_Number: id.val(),Destination: destination.val(),Mail_Type: mailtype.val(),Sender_Name: sender.val(),d: day.val(),m: month.val(),y: year.val()},
			function(b)
			{
      			x=b.id;
				document.getElementById('category2').value=category.val();
				document.getElementById('mailnumber2').value=b.num;
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
	Recipient: <input type="text" style="border:none;" name="recipient2" id="recipient2" readonly></input><br>
	Sender: <input type="text" style="border:none;" name="sender2" id="sender2" readonly></input><br>
	Destination: <input type="text" style="border:none;" name="destination2" id="destination2" readonly></input><br>
	Mail Number: <input type="text" style="border:none;" name="mailnumber2" id="mailnumber2" readonly></input><br>
	Mail Type: <input type="text" style="border:none;" name="mailtype2" id="mailtype2" readonly></input><br>
	Date: <input type="text" style="border:none;" name="date2" id="date2" readonly></input><br>
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

<div style=" position:relative; width:400px; display:block; margin: 0 auto;">

	<div class="container" style="margin-top:125px;">

		<form method="GET">
			<div class="form_inner">
				<label for="category">Category</label>
				<input id="category" type="text" name="Category" value="Incoming" readonly  />
				<br/>
				<label for="id_number">ID Number</label>
				<input id="id_number" type="text" placeholder="ID Number" name="ID_Number" value="<?php echo $_GET['id_number']; ?>" readonly/>
				<br/>
				<label for="mail_number">Mail Number</label>
				<input id="mail_number" type="text" placeholder="Mail Number" name="Mail_Number">
				<label for="date" style="display:block">Date(mm/dd/yyyy)</label>
				<select style="width:50px" id='month' name='m' onChange='changemonth()'>
				<?php
					for ($i=1; $i<=12; $i++){
						$x = date ('m', mktime(0,0,0,$i));
						echo "<option value='".$x."'> $x </option>";
					}
				?>
				</select>
				<select style="width:50px" id='day' name='d'>
				</select>
				<select style="width:75px" id='year' name='y' onChange='changemonth()'>
				<?php
					for ($i=0; $i<15; $i++){
						$x = (date('Y') - 5) + $i;
						echo "<option value='".$x."'> $x </option>";
					}
				?>
				</select>
				<a href="#" onClick='today()'> today </a>
				<br/>
				<label for="sender_name">Sender Name</label>
				<input id="sender_name" type="text" placeholder="Sender Name" name="Sender_Name">
				<br/>
				<label for="type">Mail Type</label>
				<select id="type" name="Mail_Type" onChange = 'checktype()'>
					<option value="Ordinary">Ordinary</option>
					<option value="Registered">Registered</option>
					<option value="Package">Package</option>
				</select>
				<br/>
				<label for="destination">Department/Office</label>
				<select id="destination" name="Destination" >
					<option value="Not Specified">Not Specified</option>
					<?php
					$query = mysqli_query($con, "SELECT department FROM department_list ORDER BY department");
					while ($row = mysqli_fetch_array($query)){
						echo "<option value='".$row['department']."'>".$row['department']."</option>";
					} 
					?>
				</select>
				<br/>	
				<br/>				
				<span><button id="submit" class="add ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="submit" form="">SUBMIT</button></span>
				<br/>
				
			</div>
		</form>
</div>
</div>

<script>
checktype();
function checktype(){
	var type = document.getElementById("type");
	var num = document.getElementById("mail_number");

	if (type.value == "Ordinary"){
		num.removeAttribute("required");
		num.placeholder = "*ordinary mail need no input";
		num.value="";
		num.setAttribute("readonly", "readonly");
	}
	else {
		num.setAttribute("required", "required");
		num.placeholder = "Mail Number";
		num.removeAttribute("readonly");
	}
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
<div class="footer">
	

</div>
</body>
</html>