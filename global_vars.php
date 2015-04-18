<?php
	
	$institutions = array("Amherst", "Hampshire", "Smith", "UMass Amherst");
	$mhc_equiv_courses = array("cs101", "cs201", "cs211", "cs221", "math232", "elect200", "cs312", "cs322", "elect300");
	$folder_path = "C:/Users/Sarah Read/Desktop/Independent Study/pdf_files/";
	//$folder_path = "pdf_files/";
	$link_db = "mhc_course_links";
	$counter_db = "counters";
	$files_db = "mhc_course_pdfs";
	$course_db = "mhc_equiv_courses";
	
	
	function connectToDatabase(){
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
		return $conn;
	}
	
	function makeSqlQuery($conn, $sql, $message){
		if ($conn->query($sql) === TRUE) {
			echo $message . "\n";
		} else {
			echo "Error: " . $conn->error;
		}
	}
	
	function selectDropdownOption(){
		echo ' selected="selected"';
	}
	
	function checkCheckbox(){
		echo 'checked';
	}
?>