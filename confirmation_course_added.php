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
include 'global_vars.php';

$servername = "localhost";
$username = "root";
$password = "pass123";
$dbname = "courseEquivalentDB";

$insert_into_table = 1;

$name = fix_input($_POST["courseTitle"]);
$number =fix_input($_POST["courseNumber"]);
$credits = $_POST["credit"];
if($credits!= 2 && $credits!=4){
	$insert_into_table=0;
}

$institution = $_POST["formInstitution"];
$valid_institution = false;
for($i=0; $i<count($institutions); $i++){
	if($institution==$institutions[$i]){
		$valid_institution= true;
	}
}
if($valid_institution != true){
	$insert_into_table=0;
}

$mhc_course = $_POST["formMHCEquivalent"];
$valid_mhc_course = false;
for($i=0; $i<count($mhc_equiv_courses); $i++){
	if($mhc_course == $mhc_equiv_courses[$i]){
		$valid_mhc_course=true;
	}
}
if($valid_mhc_course != true){
	$insert_into_table = 0;
}

//get pdf
$tmpName  = $_FILES['userfile']['tmp_name'];
$fp = fopen($tmpName, 'r');
$syllabus = fread($fp, filesize($tmpName));
$syllabus = addslashes($syllabus);
fclose($fp);
$syllabus_type = $_FILES['userfile']['type'];
$syllabus_size = $_FILES['userfile']['size'];
$syllabus_name = fix_input($_FILES['userfile']['name']);
if($syllabus_type != "application/pdf"){
	$insert_into_table = 0;
}

$link = fix_input($_POST["website"]);
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
$prof_prereq = fix_input($_POST["profPrereqs"]);
$notes = fix_input($_POST["notes"]);
$day = $_POST["day"];
$day_int = intval($day);
if($day_int<1 || $day_int>31){
	$insert_into_table = 0;
}
$month = $_POST["month"];
$month_int = intval($month);
if($month_int<1 || $month_int>12){
	$insert_into_table = 0;
}
$year = $_POST["year"];
$year_int = intval($year);
$cur_year = date("Y");
if($year_int < $cur_year - 2 || $year_int>$cur_year){
	$insert_into_table=0;
}
$professor = fix_input($_POST["professorApproving"]);
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
if($insert_into_table===1){
	/**$sql = "INSERT INTO mhc_equiv_courses (name, number, credits, institution,
	mhc_course, syllabus, syllabus_type, syllabus_size, syllabus_name,
	link, prereq101, prereq201, prereq211, prereq221, prereq_math,
	prof_prereq, notes, day, month, year, professor, approved)
	Values ('" . $name . "', '" . $number . "', '" . $credits . "', '" .
	$institution . "', '" . $mhc_course . "', '" . $syllabus . "', '" .
	$syllabus_type . "', '" . $syllabus_size . "', '" . $syllabus_name
	. "', '" . $link . "', '" . $prereq101 . "', '" . $prereq201 . "', '" .
	$prereq211 . "', '" . $prereq221 . "', '" . $prereq_math . "', '" .
	$prof_prereq . "', '" . $notes . "', '" . $day . "', '" . $month . "', '" .
	$year . "', '" . $professor . "', '" . $approved . "')";*/
	$sql = mysqli_prepare($conn, "INSERT INTO mhc_equiv_courses (name, number, credits, institution,
	mhc_course, syllabus, syllabus_type, syllabus_size, syllabus_name,
	link, prereq101, prereq201, prereq211, prereq221, prereq_math,
	prof_prereq, notes, day, month, year, professor, approved)
	Values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	
	mysqli_stmt_bind_param($sql, 'ssissbsissiiiiissiiisi', $name, $number, $credits, $institution,
		$mhc_course, $syllabus, $syllabus_type, $syllabus_size, $syllabus_name,
		$link, $prereq101, $prereq201, $prereq211, $prereq221, $prereq_math,
		$prof_prereq, $notes, $day, $month, $year, $professor, $approved);
	
	mysqli_stmt_execute($sql);
	
	mysqli_stmt_close($sql);
	
}
else{
	echo "wrong type";
}	

$conn->close();

function fix_input($user_data){
	$user_data = trim($user_data);
	$user_data = stripslashes($user_data);
	$user_data = htmlspecialchars($user_data);
	return $user_data;
}
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
<form action="main_page.php" method="post">
	<input type="submit" value="Return to Search Page">
<form/>

</body>

</html>