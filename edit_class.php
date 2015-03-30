<!DOCTYPE HTML>
<html> 

<head>
<link rel="stylesheet" type="text/css" href="style_one.css">
</head>

<body>

<h1>
<font size="6">Edit Course Information</font>
</h1>

<?php
include 'global_vars.php';

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
$id;
    if(isset($_GET["data"]))
    {
        $id = $_GET["data"];
        
    }

$sql = "SELECT name, number, credits, institution,
mhc_course, prereq101, prereq201, prereq211, prereq221, prereq_math,
prof_prereq, notes, day, month, year, professor, approved FROM mhc_equiv_courses
Where id=" . $id;
$result = $conn->query($sql);

if($result->num_rows >0){	
	//print all rows of database
	while($row=$result->fetch_assoc()){
		$name = $row["name"];
		$number = $row["number"];
		$credits = $row["credits"];
		$institution = $row["institution"];
		$mhc_course = $row["mhc_course"];
		$pre101 = $row["prereq101"];
		$pre201 = $row["prereq201"];
		$pre211 = $row["prereq211"];
		$pre221 = $row["prereq221"];
		$preMath =$row["prereq_math"];
		$profPre = $row["prof_prereq"];
		$notes = $row["notes"];
		$month = $row["month"];
		$day = $row["day"];
		$year = $row["year"];
		$prof = $row["professor"];
		$approved = $row["approved"];
	}
}	

//get links
$sql = "Select link from mhc_course_links where class_id=" . $id;
$result = $conn->query($sql);
$all_links = "";
if($result->num_rows >0){
	while($row=$result->fetch_assoc()){
		
		$all_links = $all_links . $row["link"].", ";
	
	}
}
if(strlen($all_links)>0){
	$all_links = substr($all_links, 0, strlen($all_links)-2);
}

//get pdfs
$sql = "Select syllabus_name from mhc_course_pdfs where class_id=" . $id;
$result = $conn->query($sql);

$pdf_arr = array();

if($result->num_rows >0){
	while($row=$result->fetch_assoc()){
		array_push($pdf_arr, $row["syllabus_name"]);
	}
}

?>

<form name = "editCourse" action="confirmation_course_edited.php" onsubmit = "return checkform()" method="post" enctype="multipart/form-data">
	
	<input type="hidden" name="class_id" value="<?php echo $id; ?>">
	<input type="hidden" name="num_pdfs" value="<?php echo count($pdf_arr); ?>">
	
	<p>
	Course Title: <strong><font color="red">*</font></strong>
		<input type="text" name="courseTitle" value="<?php echo $name; ?>" required>
	<br><br>
		
	Course Number: <strong><font color="red">*</font></strong>
		<input type="text" name="courseNumber" value="<?php echo $number; ?>" required >
	<br><br>
	
	Number of Credits: <strong><font color="red">*</font></strong>
		<input type="radio" name = "credit" <?php if ($credits==2) echo "checked";?> value= "2" required>2 Credits
		<input type="radio" name = "credit" <?php if ($credits==4) echo "checked";?> value= "4" required>4 Credits
		<?php 
		if(isset($_POST["credit"])){
			echo $_POST["credit"]; 
		}
		?>
	<br><br>
		
	Institution: <strong><font color="red">*</font></strong>
		<select name="formInstitution" required>
		<option value = "">Select...</option>
		<option value = "Amherst" <?php if ($institution == "Amherst"){ selectDropdownOption(); } ?>>Amherst</option>
		<option value = "Hampshire" <?php if ($institution == "Hampshire"){selectDropdownOption(); } ?>>Hampshire</option>
		<option value = "Smith" <?php if ($institution == "Smith"){ selectDropdownOption(); } ?>>Smith</option>
		<option value = "UMass Amherst" <?php if ($institution == "UMass Amherst"){ selectDropdownOption(); } ?>>UMass Amherst</option>
		</select>
	<br><br>
		
	MHC Equivalent Course: <strong><font color="red">*</font></strong>
		<select name="formMHCEquivalent" required>
		<option value = "">Select...</option>
		<option value = "cs101" <?php if ($mhc_course == "cs101"){ selectDropdownOption(); } ?>>CS 101</option>
		<option value = "cs201" <?php if ($mhc_course == "cs201"){ selectDropdownOption(); } ?>>CS 201</option>
		<option value = "cs211" <?php if ($mhc_course == "cs211"){ selectDropdownOption(); } ?>>CS 211</option>
		<option value = "cs221" <?php if ($mhc_course == "cs221"){ selectDropdownOption();} ?>>CS 221</option>
		<option value = "math232" <?php if ($mhc_course == "math232"){ selectDropdownOption();} ?>>MATH 232</option>
		<option value = "elect200" <?php if ($mhc_course == "elect200"){ selectDropdownOption(); } ?>>CS 200 Elective</option>
		<option value = "cs312" <?php if ($mhc_course == "cs312"){ selectDropdownOption();} ?>>CS 312</option>
		<option value = "cs322" <?php if ($mhc_course == "cs322"){ selectDropdownOption(); } ?>>CS 322</option>
		<option value = "elect300" <?php if ($mhc_course == "elect300"){ selectDropdownOption(); } ?>>CS 300 Elective</option>
		</select>
	<br><br>
	
	Uncheck to Delete a Syllabus: <br>
		<?php 
			for($i=0; $i<count($pdf_arr); $i++){
				echo "<input type=\"checkbox\" name=\"pdf" . $i . "\" value=\"true\" checked>". $pdf_arr[$i]. "<br>";
			}
		?>
	<br>
	Upload New Syllabus:
		<input type="hidden" name="MAX_FILE_SIZE" value="5000000">
		<input name="userfile[]" type="file" id="userfile" multiple="multiple">
	<br><br>
	
	Link to Course Website: <strong><font color="red">*</font></strong>
		<input type = "text" name = "website" value="<?php echo $all_links; ?>" required>
		<br>To upload multiple links use CSV.
	<br><br>
	
	MHC Prerequisites: 
		<input type="checkbox" name="prereq101" value="true" <?php if($pre101==1){checkCheckbox();}?>> CS 101
		<input type="checkbox" name="prereq201" value="true"<?php if($pre201==1){checkCheckbox();}?>> CS 201
		<input type="checkbox" name="prereq211" value="true"<?php if($pre211==1){checkCheckbox();}?>> CS 211
		<input type="checkbox" name="prereq221" value="true"<?php if($pre221==1){checkCheckbox();}?>> CS 221
		<input type="checkbox" name="prereqDescrete" value="true"<?php if($preMath==1){checkCheckbox();}?>> MATH 232
	<br><br>
	
	Professor Specified Prerequisites:
		<input type="text" name="profPrereqs" value="<?php echo $profPre; ?>">
	<br><br>
	
	Notes: <br>
		<textarea type = "text" name = "notes" cols = "40" rows = "5" ><?php echo $notes ?></textarea>
	<br><br>
	
	Approval Month: <strong><font color="red">*</font></strong>
		<input type="text" name="month" maxlength="2" size = "2" value="<?php echo $month; ?>" required>
		Day: <strong><font color="red">*</font></strong>
		<input type="text" name="day" maxlength="2" size = "2" value="<?php echo $day; ?>" required>
		Year:<strong><font color="red">*</font></strong>
		<input type="text" name="year" maxlength="4" size = "4" value="<?php echo $year; ?>" required>
	<br><br>
	
	Professor Approving: <strong><font color="red">*</font></strong>
		<input type="text" name="professorApproving" value="<?php echo $prof; ?>" required>
	<br><br>
	
	Course Approved?
		<input type="checkbox" name="approved" value="true" <?php if($approved==1){checkCheckbox();}?>>
	<br><br>
	
	<input type="submit" name = "form_submit" value="Save">
	</p>
</form>

<script>
	function checkform()
	{
		if(isNaN(editCourse.elements["month"].value)){
			window.alert("Month must be an integer value.");
			return false;
		}
		
		var monthInt = parseInt(editCourse.elements["month"].value);
		if(monthInt<1 || monthInt>12){
			window.alert("Month must be between 1 and 12.");
			return false;
		}

		if(isNaN(editCourse.elements["day"].value)){
			window.alert("Day must be an integer value.");
			return false;
		}
		
		var dayInt = parseInt(editCourse.elements["day"].value);
		if(dayInt<1 || dayInt>31){
			window.alert("Day must be between 1 and 31.");
			return false;
		}
		
		if(isNaN(editCourse.elements["year"].value)){
			window.alert("Year must be an integer value.");
			return false;
		}
		
		var curDate = new Date();
		var curYear = curDate.getFullYear();
		var yearInt = parseInt(editCourse.elements["year"].value);
		if(yearInt<curYear-2 || yearInt>curYear){
			window.alert("Year must be within the past two years.");
			return false;
		}
		
		var containsPDF=false;
		for(i=0; i<editCourse.elements["num_pdfs"].value; i++){
			if(editCourse.elements["pdf"+i].checked == true){
				return true;
			}
		}
		if(!containsPDF){
			var uploaded = document.getElementById("userfile");
			if('files' in uploaded){
				if(uploaded.files.length==0){
					window.alert(
					"You must have at least 1 file associated with this course.");
					return false;
				}
			}
		}
		else{
			return true;
		}
	}
</script>


<form action="main_page.php" method="post">
	<input type="submit" value="Cancel">
<form/>

</body>

</html>
