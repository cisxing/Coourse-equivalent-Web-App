<!DOCTYPE HTML>
<html> 

<body>

<form action="confirmation_course_added.php" method="post" enctype="multipart/form-data">
	<font size="6">Add a New Course Evaluation</font>
	<br><br>
	
	Course Title: <strong><font color="red">*</font></strong>
		<input type="text" name="courseTitle" required>
	<br><br>
		
	Course Number: <strong><font color="red">*</font></strong>
		<input type="text" name="courseNumber" required >
	<br><br>
	
	Number of Credits: 
		<input type="radio" name = "credit" value= "2" required>2 Credits
		<input type="radio" name = "credit" value= "4" required>4 Credits
		<?php 
		if(isset($_POST["credit"])){
			echo $_POST["credit"]; 
		}
		?>
	<br><br>
		
	Institution: <strong><font color="red">*</font></strong>
		<select name="formInstitution" required>
		<option value = "">Select...</option>
		<option value = "Amherst">Amherst</option>
		<option value = "Hampshire">Hampshire</option>
		<option value = "Smith">Smith</option>
		<option value = "UMass Amherst">UMass Amherst</option>
		</select>
	<br><br>
		
	MHC Equivalent Course: <strong><font color="red">*</font></strong>
		<select name="formMHCEquivalent" required>
		<option value = "">Select...</option>
		<option value = "cs101">CS 101</option>
		<option value = "cs201">CS 201</option>
		<option value = "cs211">CS 211</option>
		<option value = "cs221">CS 221</option>
		<option value = "math232">MATH 232</option>
		<option value = "elect200">CS 200 Elective</option>
		<option value = "cs312">CS 312</option>
		<option value = "cs322">CS 322</option>
		<option value = "elect300">CS 300 Elective</option>
		</select>
	<br><br>
	
	Upload Syllabus: <strong><font color="red">*</font></strong> 
		<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
		<input name="userfile" type="file" id="userfile" required> 
	<br><br>
	
	Link to Course Website: <strong><font color="red">*</font></strong> 
		<input type = "text" name = "website" required>
	<br><br>
	
	MHC Prerequisites: 
		<input type="checkbox" name="prereq101" value="true"> CS 101
		<input type="checkbox" name="prereq201" value="true"> CS 201
		<input type="checkbox" name="prereq211" value="true"> CS 211
		<input type="checkbox" name="prereq221" value="true"> CS 221
		<input type="checkbox" name="prereqDescrete" value="true"> MATH 232
	<br><br>
	
	Professor Specified Prerequisites:
		<input type="text" name="profPrereqs">
	<br><br>
	
	Notes: <br>
		<textarea type = "text" name = "notes" cols = "40" rows = "5"></textarea>
	<br><br>
	
	Approval Month: <strong><font color="red">*</font></strong>
		<input type="text" name="month" maxlength="2" size = "2" required>
		Day: <strong><font color="red">*</font></strong>
		<input type="text" name="day" maxlength="2" size = "2" required>
		Year:<strong><font color="red">*</font></strong>
		<input type="text" name="year" maxlength="4" size = "4" required>
	<br><br>
	
	Professor Approving:<strong><font color="red">*</font></strong>
		<input type="text" name="professorApproving" required>
	<br><br>
	
	Course Approved?
		<input type="checkbox" name="approved" value="true">
	<br><br>
	
	<input type="submit" name = "form_submit" value="Save">
	
</form>

<br>

<form action="main_page.php" method="post">
	<input type="submit" value="Cancel">
<form/>

</body>

</html>
