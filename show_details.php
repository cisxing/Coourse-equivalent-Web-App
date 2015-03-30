<!DOCTYPE HTML>
<?php

	$data;
    if(isset($_GET["data"]))
    {
        $data = $_GET["data"];
        
    }
    $url = 'edit_class.php?data='.$data;
    mysql_connect('localhost','root','pass123');
	//select db
	mysql_select_db('courseEquivalentDB');
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}

	//can not just use the mysql_real_escape_string function because id is required to be a number instead of a string
	$query = sprintf("select * from mhc_equiv_courses where id='".$data."'");
	$record = mysql_query($query);
	while ($course=mysql_fetch_assoc($record)){
		//echo "id is: " . $course["id"]."<br>";
		echo "Course Name: " . $course["name"]. "<br>";
		echo "Course Number: " . $course["number"]."<br>";
		echo "Number of Credits: " . $course["credits"]."<br>";
		echo "MHC Equivalent Course: " . $course["mhc_course"] . "<br>";
		$mhc_prerequisites = "";
		if($course["prereq101"]==1){
			$mhc_prerequisites = $mhc_prerequisites + "CS 101, ";
		}
		if($course["prereq201"]==1){
			$mhc_prerequisites = $mhc_prerequisites + "CS 201, ";
		}
		if($course["prereq211"]==1){
			$mhc_prerequisites = $mhc_prerequisites + "CS 211, ";
		}
		if($course["prereq221"]==1){
			$mhc_prerequisites = $mhc_prerequisites + "CS 221, ";
		}
		if($course["prereq_math"]==1){
			$mhc_prerequisites = $mhc_prerequisites + "MATH 232, ";
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
	
?>


<html> 

<body>

<form action="<?php echo $url ?>" method="post">
	<input type="submit" value="Edit this class">
<form/>

</body>

</html>
	