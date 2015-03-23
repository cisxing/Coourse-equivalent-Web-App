<?php
	$institutions = array("Amherst", "Hampshire", "Smith", "UMass Amherst");
	$mhc_equiv_courses = array("cs101", "cs201", "cs211", "cs221", "math232", "elect200", "cs312", "cs322", "elect300");

	function makeSqlQuery($conn, $sql, $message){
		if ($conn->query($sql) === TRUE) {
			echo $message . "\n";
		} else {
			echo "Error: " . $conn->error;
		}
	}
?>