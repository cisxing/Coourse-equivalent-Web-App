<?php
	include 'global_vars.php';
	$data;
    if(isset($_GET["data"]))
    {
        $data = $_GET["data"];
        
    }
 
 //$link = mysql_connect('localhost','root','pass123');
 $link = connectToDatabase();
	//select db
	//mysql_select_db('courseEquivalentDB');
	//if ($conn->connect_error) {
    	//die("Connection failed: " . $conn->connect_error);
	//}

//$gotten = mysql_query("select * from mhc_course_pdfs where class_id ='".$data."'");
	
	$sql = "select * from mhc_course_pdfs where id ='".$data."'";
$result = $link->query($sql);
	//$gotten = mysql_query("select * from mhc_course_pdfs where id ='".$data."'");


while($row=$result->fetch_assoc())
	{
		//$bytes = $row[imgdata];
		
		//header("Content-type: application/pdf");
		//header('Content-disposition: inline; filename="'.$row['syllabus_name'].'"');
		//readfile($row['syllabus'];
		
		//print $bytes;


  $file = $row['syllabus'];
  $filename = $row['syllabus_name'];
  echo $filename;
  header('Content-type: application/pdf');

  header("Content-Disposition: attachment; filename=" . $filename . "");
  //header('Content-Length: ' . $row['syllabus_size']);
  header('Content-Transfer-Encoding: binary');
  header('Accept-Ranges: bytes');

  //header("Location: ".$filename."");
  @readfile($file); 
	}


//close the database safely
mysql_close($link);
?>