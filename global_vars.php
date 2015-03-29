<?php
	$institutions = array("Amherst", "Hampshire", "Smith", "UMass Amherst");
	$mhc_equiv_courses = array("cs101", "cs201", "cs211", "cs221", "math232", "elect200", "cs312", "cs322", "elect300");
	$folder_path = "PATH TO DIRECTORY HERE";
	
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