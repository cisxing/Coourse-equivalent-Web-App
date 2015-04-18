<!DOCTYPE HTML>
<head>
<link rel="stylesheet" type="text/css" href="style_one.css">
</head>

<h1>
Course Details
</h1>

<p>
<?php
	include 'global_vars.php';
	$data;
	//$pdfData;
    if(isset($_GET["data"]))
    {
        $data = $_GET["data"];
        
    }
    //to go to the edit page
    $url = 'edit_class.php?data='.$data;
    //to go to the download page
    $download = 'download_pdf.php?data='.$data;
	
    $conn = connectToDatabase();

	//can not just use the mysql_real_escape_string function because id is required to be a number instead of a string
	$query = sprintf("select * from mhc_equiv_courses where id='".$data."'");
	$record = $conn->query($query);
	while ($course=$record->fetch_assoc()){
		//echo "id is: " . $course["id"]."<br>";
		echo "Course Name: " . $course["name"]. "<br>";
		echo "Department: " . $course["department"]. "<br>";
		echo "Course Number: " . $course["number"]."<br>";
		echo "Number of Credits: " . $course["credits"]."<br>";
		echo "MHC Equivalent Course: " . $course["mhc_course"] . "<br>";
		$mhc_prerequisites = "";
		if($course["prereq101"]==1){
			$mhc_prerequisites = $mhc_prerequisites . "CS 101, ";
		}
		if($course["prereq201"]==1){
			$mhc_prerequisites = $mhc_prerequisites . "CS 201, ";
		}
		if($course["prereq211"]==1){
			$mhc_prerequisites = $mhc_prerequisites . "CS 211, ";
		}
		if($course["prereq221"]==1){
			$mhc_prerequisites = $mhc_prerequisites . "CS 221, ";
		}
		if($course["prereq_math"]==1){
			$mhc_prerequisites = $mhc_prerequisites . "MATH 232, ";
		}
		if(strlen($mhc_prerequisites)>0){
			$mhc_prerequisites = substr($mhc_prerequisites, 0, strlen($mhc_prerequisites)-2);
		}
		else{
			$mhc_prerequisites = "None";
		}
		echo "MHC Prerequisites: " . $mhc_prerequisites ."<br>";
		echo "Professor Prerequisites: " . $course["prof_prereq"]. "<br>";
		echo "Notes: " . $course["notes"]. "<br>";
		echo "Approval Date: " . $course["month"]. "/". $course["day"]. "/". $course["year"]."<br>";
		echo "Professor who Evaluated the Class: " . $course["professor"]. "<br>";
		if($course["approved"] == 0){
			echo "Approved: No <br>";
		}
		else{
			echo "Approved: Yes <br>";
		}
	}
	$query1 = sprintf("select * from mhc_course_links where class_id='".$data."'");
	$record1 = $conn->query($query1);
	echo "Link: <br>";
	while ($course1=$record1->fetch_assoc())
	{
		//this !== false is deliberate because of the property of strops
		if (strpos($course1['link'],'https') !== false) {
  		  echo '<a href="'.$course1['link'].'"> '.$course1['link'].'</a>';
		}
		else
		{
			echo '<a href="https://'.$course1['link'].'"> '.$course1['link'].'</a>';
	}
	echo "<br>";
	}

	echo "Syllabus attachment: <br>";
	//echo '<a href="./download_pdf.php?data='.$data.'&type=0">'Download All'</a>';
	$query2 = sprintf("select * from mhc_course_pdfs where class_id ='".$data."'");
	$gotten = $conn->query($query2);
	while ($row=$gotten->fetch_assoc())
	{
		echo '<a href="./download_pdf.php?data='.$row['id'].'">'.$row['syllabus_name'].'</a>';
		echo '<br>';
	}	
	echo '<a href="./download_pdf_all.php?data='.$data.'">Download All</a>';

echo "<br><br>";
?>


<html> 
</p>
<body>

<form action="<?php echo $url ?>" method="post">
	<input type="submit" name = "download" value="Edit This Class">
<form/>

<?php
	echo '<a href="./delete_course.php?data='.$data.'"><button type="button">'."Delete This Class".'</button></a>';
	echo '<a href="./search_course.php"><button type="button">'."Return to Search Page".'</button></a>';
?>


</html>
	
