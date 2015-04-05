<?php
	include 'global_vars.php';
	$conn = connectToDatabase();
	$data;
    if(isset($_GET["data"]))
    {
        $data = $_GET["data"];
    }
	$sql = "SELECT name FROM mhc_equiv_courses Where id=" . $data;
	$result = $conn->query($sql);
	
	if($result->num_rows >0){	
		//print all rows of database
		while($row=$result->fetch_assoc()){
			$name = $row["name"];
		}
	}
	$sql = "delete from mhc_equiv_courses Where id=". $data;
	makeSqlQuery($conn, $sql, "");
?>

<html> 

<head>
<link rel="stylesheet" type="text/css" href="style_one.css">
</head>

<body>

<h1>
<font size="6">"<?php echo $name;?>" Was Deleted</font>
</h1>

<?php
echo '<a href="./search_course.php"><button type="button">'."Return to Search Page".'</button></a>';
?>