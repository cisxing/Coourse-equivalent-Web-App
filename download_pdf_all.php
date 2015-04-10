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
	$gotten = mysql_query("select * from mhc_equiv_courses where id ='".$data."'");
$name;
while ($row=mysql_fetch_assoc($gotten))	
	{
		$name = $row['name'];
		
	}

	$zipname = ''.$name.'.zip';
	//$zipname = "file.zip";
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);

    
    $pdfs = mysql_query("select * from mhc_course_pdfs where class_id ='".$data."'");
   

    while ($pdf=mysql_fetch_assoc($pdfs))
    {
    	$path = $pdf['syllabus'];
     if(file_exists($path)){
 		 $zip->addFromString(basename($path),  file_get_contents($path)); 

  		}
  	else{
   		echo"file does not exist";
  	}

	}
    $zip->close();


    header('Content-Type: application/zip');
    header("Content-Disposition: attachment; filename=".$zipname."");
    header('Content-Length: ' . filesize($zipname));
    header("Location: ".$zipname."");

	
mysql_close($link);
   ?>