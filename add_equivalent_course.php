<!DOCTYPE HTML>
<html> 

<head>
<link rel="stylesheet" type="text/css" href="style_one.css">
</head>

<body>

<h1>
<font size="6">Add a New Course Evaluation</font>
</h1>
<form name = "newCourse" action="confirmation_course_added.php" onsubmit = "return checkform()" method="post" enctype="multipart/form-data">
	
	<p>
	Course Title: <strong><font color="red">*</font></strong>
		<input type="text" name="courseTitle" required>
	<br><br>
		
	Course Number: <strong><font color="red">*</font></strong>
		<input type="text" name="courseNumber" required >
	<br><br>
	
	Number of Credits: <strong><font color="red">*</font></strong>
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
	
	Description: <input type="text" name="description" size = "60">
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
	
	Upload Syllabus:
		<input type="hidden" name="MAX_FILE_SIZE" value="5000000">
		<input name="userfile[]" type="file" id="userfile" multiple="multiple">
	<br><br>
	
	Link to Course Website:
		<input type = "text" name = "website">
		<br>To upload multiple links use CSV.
	<br><br>
	
	MHC Prerequisites: 
		<input type="checkbox" name="prereq101" value="true"> CS 101
		<input type="checkbox" name="prereq201" value="true"> CS 201
		<input type="checkbox" name="prereq211" value="true"> CS 211
		<input type="checkbox" name="prereq221" value="true"> CS 221
		<input type="checkbox" name="prereqDescrete" value="true"> MATH 232
	<br><br>
	
	Other Prerequisites:
		<input type="text" name="profPrereqs">
	<br><br>
	
	Notes: <br>
		<textarea type = "text" name = "notes" cols = "40" rows = "5"></textarea>
	<br><br>
	
	<?php 
	date_default_timezone_set('America/New_York');?>
	
	Approval Month: <strong><font color="red">*</font></strong>
		<input type="text" name="month" maxlength="2" size = "2" required value="<?php echo date('m'); ?>">
		Day: <strong><font color="red">*</font></strong>
		<input type="text" name="day" maxlength="2" size = "2" required value="<?php echo date('d'); ?>">
		Year:<strong><font color="red">*</font></strong>
		<input type="text" name="year" maxlength="4" size = "4" required value="<?php echo date('Y'); ?>">
	<br><br>
	
	Professor Approving:<strong><font color="red">*</font></strong>
		<input type="text" name="professorApproving" required>
	<br><br>
	
	Course Approved?
		<input type="checkbox" name="approved" value="true">
	<br><br>
	
	<input type="submit" name = "form_submit" value="Save">
	</p>
</form>

<script>
	function checkform()
	{
		if(isNaN(newCourse.elements["month"].value)){
			window.alert("Month must be an integer value.");
			return false;
		}
		
		var monthInt = parseInt(newCourse.elements["month"].value);
		if(monthInt<1 || monthInt>12){
			window.alert("Month must be between 1 and 12.");
			return false;
		}

		if(isNaN(newCourse.elements["day"].value)){
			window.alert("Day must be an integer value.");
			return false;
		}
		
		var dayInt = parseInt(newCourse.elements["day"].value);
		if(dayInt<1 || dayInt>31){
			window.alert("Day must be between 1 and 31.");
			return false;
		}
		
		if(isNaN(newCourse.elements["year"].value)){
			window.alert("Year must be an integer value.");
			return false;
		}
		
		var curDate = new Date();
		var curYear = curDate.getFullYear();
		var yearInt = parseInt(newCourse.elements["year"].value);
		if(yearInt<curYear-2 || yearInt>curYear){
			window.alert("Year must be within the past two years.");
			return false;
		}
		/**fileName = newCourse.elements["userfile"].value;
		fileType = fileName.substring(fileName.lastIndexOf(".")+1, fileName.length);
		if(fileType != "pdf"){
			window.alert("The file must be a pdf.");
			return false;
		}
		var request;*/
		/**if(window.XMLHttpRequest){
			request = new XMLHttpRequest();
		}
		else{
			request = new ActiveXObject("Microsoft.XMLHTTP");
		}
		request.open('GET', newCourse.elements["website"].value, false);
		request.send();
		if (request.status === 404) {
			window.alert("Please enter a valid url");
			return false
		}
		request.abort();
		window.alert("everything is fine!");
		return true;*/
	}
</script>


<form action="main_page.php" method="post">
	<input type="submit" value="Cancel">
<form/>

</body>

</html>
