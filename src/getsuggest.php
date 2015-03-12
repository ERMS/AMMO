<?php
include "function/database.php";
$con=adzudb();
$val=$_REQUEST['val'];
$suggest="";
$hint=array();$i=0;
$query=mysqli_query($con,"SELECT * FROM person");
while($row=mysqli_fetch_array($query))
{
	$hint[$i]=$row['Last_Name']." ".$row['First_Name'];
	$i++;
}

if ($val !== "")
{
	$val=strtolower($val); 
	$len=strlen($val);
    foreach($hint as $name)
    { 
    	if (stristr($val, substr($name,0,$len)))
      	{ 
      		if ($suggest==="")
        	{ 
        		$suggest=$name; 
        	}
        	else
        	{ 
        		$suggest .= ", $name"; 
        	}
      	}
    }
}
echo $suggest==="" ? "No Suggestions!" : $suggest;
?>