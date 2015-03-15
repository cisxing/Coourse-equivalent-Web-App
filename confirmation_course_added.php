<!--This page is shown when a user adds a new course to the database to confirm 
the data was successfully added-->

<!--Show current state of this database entry-->

<!-- Check that entries are valid
	1. no other courses by that name at the same school
	2. date is in the correct format
	
	If this fails send back to previous page and ask them to re-fill out form?
	Is there a way to check before data is sent?-->
<!DOCTYPE HTML>

<?php
$servername = "localhost";
$username = "cis";
$password = "19931029";
$dbname = "courseEquivalentDB";

$name = $_POST["courseTitle"];
$number = $_POST["courseNumber"];
$credits = $_POST["credit"];
$institution = $_POST["formInstitution"];
$mhc_course = $_POST["formMHCEquivalent"];

//get pdf
$tmpName  = $_FILES['userfile']['tmp_name'];
$fp = fopen($tmpName, 'r');
$syllabus = fread($fp, filesize($tmpName));
$syllabus = addslashes($syllabus);
fclose($fp);
$syllabus_type = $_FILES['userfile']['type'];
$syllabus_size = $_FILES['userfile']['size'];
$syllabus_name = $_FILES['userfile']['name'];

$link = $_POST["website"];
$prereq101 = false;
if(isset($_POST["prereq101"]) && $_POST["prereq101"]=="true"){
	$prereq101 = true;
}
$prereq201 = false;
if(isset($_POST["prereq201"]) && $_POST["prereq201"]=="true"){
	$prereq201 = true;
}
$prereq211 = false;
if(isset($_POST["prereq211"]) && $_POST["prereq211"]=="true"){
	$prereq211 = true;
}
$prereq221 = false;
if(isset($_POST["prereq221"]) && $_POST["prereq221"]=="true"){
	$prereq221 = true;
}
$prereq_math = false;
if(isset($_POST["prereqDescrete"]) && $_POST["prereqDescrete"]=="true"){
	$prereq_math = true;
}
$prof_prereq = $_POST["profPrereqs"];
$notes = $_POST["notes"];
$day = $_POST["day"];
$month = $_POST["month"];
$year = $_POST["year"];
$professor = $_POST["professorApproving"];
$approved = false;
if(isset($_POST["approved"]) && $_POST["approved"]=="true"){
	$approved = true;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//enter the data into the database
$sql = "INSERT INTO mhc_equiv_courses (name, number, credits, institution,
mhc_course, syllabus, syllabus_type, syllabus_size, syllabus_name,
link, prereq101, prereq201, prereq211, prereq221, prereq_math,
prof_prereq, notes, day, month, year, professor, approved)
Values ('" . $name . "', '" . $number . "', '" . $credits . "', '" .
$institution . "', '" . $mhc_course . "', '" . $syllabus . "', '" .
$syllabus_type . "', '" . $syllabus_size . "', '" . $syllabus_name
. "', '" . $link . "', '" . $prereq101 . "', '" . $prereq201 . "', '" .
$prereq211 . "', '" . $prereq221 . "', '" . $prereq_math . "', '" .
$prof_prereq . "', '" . $notes . "', '" . $day . "', '" . $month . "', '" .
$year . "', '" . $professor . "', '" . $approved . "')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<br><br>
The following class has been added to the database: 
<br><br>
Course Title: <?php echo $_POST["courseTitle"]; ?>
<br><br>
Course Number: <?php echo $_POST["courseNumber"]; ?>
<br><br>
Number of Credits: <?php echo $_POST["credit"] . " Credits"; ?>
<br><br>
Institution: <?php echo $_POST["formInstitution"]; ?>
<br><br>
MHC Equivalent Course: 
<?php 
	if(isset($_POST["formMHCEquivalent"])){
		$mhcEquivSelect = $_POST["formMHCEquivalent"];
		if($mhcEquivSelect == "cs101"){
			echo "CS 101";
		}
		else if($mhcEquivSelect == "cs201"){
			echo "CS 201";
		}
		else if($mhcEquivSelect == "cs211"){
			echo "CS 211";
		}
		else if($mhcEquivSelect == "cs221"){
			echo "CS 221";
		}
		else if($mhcEquivSelect == "math232"){
			echo "MATH 232";
		}
		else if($mhcEquivSelect == "elect200"){
			echo "CS 200 Elective";
		}
		else if($mhcEquivSelect == "cs312"){
			echo "CS 312";
		}
		else if($mhcEquivSelect == "cs322"){
			echo "CS 322";
		}
		else if($mhcEquivSelect == "elect300"){
			echo "CS 300 Elective";
		}
	}

?>
<br><br>
Syllabus: 
<br><br>
Link to Course Website: <?php echo $_POST["website"]?>
<br><br>
MHC Prerequisites: 
<?php 
	$mhcPrereqs = "";
	if($prereq101){
		$mhcPrereqs = "CS 101, ";
	}
	if($prereq201){
		$mhcPrereqs = $mhcPrereqs . "CS 201, ";
	}
	if($prereq211){
		$mhcPrereqs = $mhcPrereqs . "CS 211, ";
	}
	if($prereq221){
		$mhcPrereqs = $mhcPrereqs . "CS 221, ";
	}
	if($prereq_math){
		$mhcPrereqs = $mhcPrereqs . "MATH 232, ";
	}
	if(strlen($mhcPrereqs)>0){
		$mhcPrereqs = substr($mhcPrereqs, 0, strlen($mhcPrereqs)-2);
	}
	else{
		$mhcPrereqs = "None";
	}
	echo $mhcPrereqs;
?>
<br><br>
Professor Specified Prerequisites: <?php echo $_POST["profPrereqs"]?>
<br><br>
Notes: <?php echo $_POST["notes"]?>
<br><br>
Date Approved: 
<?php 
	echo $_POST["month"] . "/" . $_POST["day"] . "/" . $_POST["year"];
?>
<br><br>
Professor Evaluating the Course: <?php echo $_POST["professorApproving"]; ?>
<br><br>

<?php 
if(isset($_POST["approved"]) && $_POST["approved"]=="true"){
	echo "The Course Was Approved!";
}
else{
	echo "The Course Was Not Approved";
}
?>

<br><br>

<html> 

<body>
<!-- Buttons to link to main page or to the details of this page -->


</body>

</html>