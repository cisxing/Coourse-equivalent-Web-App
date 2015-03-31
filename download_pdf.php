<?php
	$data;
    if(isset($_GET["data"]))
    {
        $data = $_GET["data"];
        
    }
 mysql_connect('localhost','root','pass123');
	//select db
	mysql_select_db('courseEquivalentDB');
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}

$gotten = mysql_query("select * from mhc_course_pdfs where class_id ='".$data."'");

while ($row=mysql_fetch_assoc($gotten))
	{
		$bytes = $row[imgdata];
		header("Content-type: application/pdf");
		header('Content-disposition: attachment; filename="'.$row['syllabus_name'].'"');
		print $bytes;
	}
?>