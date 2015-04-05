<!DOCTYPE HTML>

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
?>

<html> 

<head>
<link rel="stylesheet" type="text/css" href="style_one.css">
</head>

<body>

<h1>
<font size="6">Are You Sure You Want To Delete "<?php echo $name;?>"</font>
</h1>

<br>

<?php
echo '<a href="./show_details.php?data='.$data.'"><button type="button">'."No".'</button></a>';
echo '<a href="./delete_confirmation_page.php?data='.$data.'"><button type="button">'."Yes".'</button></a>';
?>




