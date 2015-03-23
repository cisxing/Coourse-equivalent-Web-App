<!DOCTYPE HTML>

<?php

$servername = "localhost";
$username = "root";
$password = "pass123";
$dbname = "courseEquivalentDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT name, number, credits, institution,
mhc_course,
link, prereq101, prereq201, prereq211, prereq221, prereq_math,
prof_prereq, notes, day, month, year, professor, approved FROM mhc_equiv_courses";
$result = $conn->query($sql);

if($result->num_rows >0){	
	//print all rows of database
	while($row=$result->fetch_assoc()){
		echo "Course Name: " . $row["name"]. "<br>";
		echo "Course Number: " . $row["number"]."<br>";
		echo "Number of Credits: " . $row["credits"]."<br>";
		echo "MHC Equivalent Course: " . $row["mhc_course"] . "<br>";
		echo "Course Website: " . $row["link"]. "<br>";
		
		$mhc_prerequisites = "";
		if($row["prereq101"]==1){
			$mhc_prerequisites = $mhc_prerequisites + "CS 101, ";
		}
		if($row["prereq201"]==1){
			$mhc_prerequisites = $mhc_prerequisites + "CS 201, ";
		}
		if($row["prereq211"]==1){
			$mhc_prerequisites = $mhc_prerequisites + "CS 211, ";
		}
		if($row["prereq221"]==1){
			$mhc_prerequisites = $mhc_prerequisites + "CS 221, ";
		}
		if($row["prereq_math"]==1){
			$mhc_prerequisites = $mhc_prerequisites + "MATH 232, ";
		}
		if(strlen($mhc_prerequisites)>0){
			$mhc_prerequisites = substr($mhc_prerequisites, 0, strlen($mhc_prerequisites)-2);
		}
		else{
			$mhc_prerequisites = "None";
		}
		echo "MHC Prerequisites: " . $mhc_prerequisites ."<br>";
		
		echo "Professor Prerequisites: " . $row["prof_prereq"]. "<br>";
		echo "Notes: " . $row["notes"]. "<br>";
		echo "Approval Date: " . $row["month"]. "/". $row["day"]. "/". $row["year"]."<br>";
		echo "Professor who Evaluated the Class: " . $row["professor"]. "<br>";
		if($row["approved"] == 0){
			echo "Approved: No <br>";
		}
		else{
			echo "Approved: Yes <br>";
		}
		
		//@read($row["syllabus"]);
		
		echo "<br>";
	}
}
else{
	echo "The database is empty <br><br>";
}

?>

<html> 

<body>

<form action="add_equivalent_course.php" method="post">
	<input type="submit" value="Add Course">
<form/>

</body>

</html>
