<!DOCTYPE HTML>
<?php

$servername = "localhost";
$username = "cis";
$password = "19931029";
$dbname = "courseEquivalentDB";

?>
<html> 
<head>
<link rel="stylesheet" type="text/css" href="style_one.css">
</head>

  
<form name ="search_form" action="display_record.php" method="post" enctype="multipart/form-data">
    <h1>Search For a Course</h1>
	<p>
	<font size = "2"; color = "red"><i>Please at least input one of the below to enable searching.</i></font>
	<br><br>
	Course Title: 
		<input type="text" name="courseTitle">
	<br><br>
		
	Course Number: 
		<input type="text" name="courseNumber">
	<br><br>
	
	
	Institution: 
		<select name="formInstitution">
		<option value = "">Select...</option>
		<option value = "Amherst">Amherst</option>
		<option value = "Hampshire">Hampshire</option>
		<option value = "Smith">Smith</option>
		<option value = "UMass Amherst">UMass Amherst</option>
		</select>
	<br><br>
		
	MHC Equivalent Course: <strong><font color="red">*</font></strong>
		<select name="formMHCEquivalent">
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
	<input type="hidden" name="do_query" value="1">
	</p>
	<div style="width:500px;">
	<div style="float: left; width: 130px">
		<input type="submit" name = "search" value="Search" onclick="search_form.do_query.value='1'; return checkform();">
	</div>
	<div style="float: right; width: 225px">
	<?php
		echo '<a href="./add_equivalent_course.php"><button type="button">'."Add New Course".'</button></a>';
	?>
	</div>
	<div style="width: 250px">
		<input type="submit" name = "all" value="View All" onclick="search_form.do_query.value='0'; return checkform();">
	</div>
	
	</div>

</form>

</body>

</html>

<script>
	function checkform()
	{
		if(search_form.elements["do_query"].value=='1'){
			if(search_form.elements["courseTitle"].value==''&&
				search_form.elements["courseNumber"].value=='' &&
				search_form.elements["formMHCEquivalent"].value=='' &&
				search_form.elements["formInstitution"].value==''){
				window.alert("You must fill out at least 1 field.");
				return false;
			}
		}
		return true;
			
	}
</script>

