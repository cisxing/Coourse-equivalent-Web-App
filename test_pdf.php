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

$sql = "SELECT syllabus, syllabus_type FROM mhc_course_pdfs";
$result = $conn->query($sql);

if($result->num_rows >0){
	while($row=$result->fetch_assoc()){
		header("Content-type: " . $row["syllabus_type"]);
		print $row["syllabus"];
	}
}
?>