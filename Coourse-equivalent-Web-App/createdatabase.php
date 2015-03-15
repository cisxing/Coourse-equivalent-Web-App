<html>
<head>
</head>
<body>
<?php
//will need to use this over and over agin, so we will set it as a variable
$con = mysql_connect("localhost", "cis", "19931029");
if(!$con){
	//print out the error we have
	die("can not connect: ". mysql_error());
}

if (mysql_query("CREATE DATABASE testout", $con))
{
	echo "Your database was created successfully";
}else echo "Error: " . mysql_error();




mysql_close($con);


?>
</body>
<html>