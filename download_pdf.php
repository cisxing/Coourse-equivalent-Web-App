<?php
	$data;
    if(isset($_GET["data"]))
    {
        $data = $_GET["data"];
        
    }
 
 $link = mysql_connect('localhost','root','pass123');
	//select db
	mysql_select_db('courseEquivalentDB');
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}

//$gotten = mysql_query("select * from mhc_course_pdfs where class_id ='".$data."'");
	$gotten = mysql_query("select * from mhc_course_pdfs where id ='".$data."'");


while ($row=mysql_fetch_assoc($gotten))
	{
		//$bytes = $row[imgdata];
		
		//header("Content-type: application/pdf");
		//header('Content-disposition: inline; filename="'.$row['syllabus_name'].'"');
		//readfile($row['syllabus'];
		
		//print $bytes;


  $file = $row['syllabus'];
  $filename = $row['syllabus_name'];
  header('Content-type: application/pdf');
  //header('Content-Disposition: inline; filename="' . $filename . '"');
  header('Content-Disposition: attachment; filename="' . $filename . '"');
  header('Content-Transfer-Encoding: binary');
  header('Accept-Ranges: bytes');
  @readfile($file); 
	}


//close the database safely
mysql_close($link);
?>