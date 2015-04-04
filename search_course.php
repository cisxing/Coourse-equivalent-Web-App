<!DOCTYPE HTML>
<?php

$servername = "localhost";
$username = "cis";
$password = "19931029";
$dbname = "courseEquivalentDB";

?>
<html> 
 <body style="width: 100%; height: 100%;">

  
<form action="display_record.php" method="post" enctype="multipart/form-data">
	  <div style="left: 35%; position: absolute;">
        <div><font size="6"; color = "blue", family-font = "ariel">Search For a Course</font>
	<br>
	<font size = "2"; color = "red"><i>Please at least input one of the below to enable searching.</i></font>
	<br><br>
	Course Title: 
		<input type="text" name="courseTitle" required>
	<br><br>
		
	Course Number: 
		<input type="text" name="courseNumber" required >
	<br><br>
	
	
	Institution: 
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
	


<div style="width:400px;">
<div style="float: left; width: 130px"> 
<form action="course_result.php" method="post">
    <input type="submit" name = "search" value="Search" >
</form>
</div>
<div style="float: right; width: 225px"> 
    <form action="search_course.php" method="post">
     <input type="submit" name = "" value="Cancel" >
    </form>
</div>
</div>



</body>

</html>
