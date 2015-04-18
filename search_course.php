<!DOCTYPE HTML>
<?php

$servername = "localhost";
$username = "cis";
$password = "19931029";
$dbname = "courseEquivalentDB";

$sort_by_array_display = array("Select...","Institution","Course Title","Course Number");
$sort_by_array_val = array("", "institution", "name","number");

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
	<input type="hidden" name="do_query" value="1">
	<br><br>
	Sort Results By    
	<select name= "first_sort" id="form_first" onChange = "onChangeDropdown(1)">
		<?php 
			for($i=0; $i<count($sort_by_array_display); $i++){
				echo "<option value='".$sort_by_array_val[$i]."'>". $sort_by_array_display[$i]."</option>" ."<br>";
			}
		?>
	</select>
	Then By 
	<select name= "second_sort" id="form_second" onChange = "onChangeDropdown(2)" disabled = "true">
		<?php 
			for($i=0; $i<count($sort_by_array_display); $i++){
				echo "<option value='".$sort_by_array_val[$i]."'>". $sort_by_array_display[$i]."</option>" ."<br>";
			}
		?>
	</select>
	Then By
	<select name= "third_sort" id="form_third" onChange = "onChangeDropdown(3)" disabled = "true">
		<?php 
			for($i=0; $i<count($sort_by_array_display); $i++){
				echo "<option value='".$sort_by_array_val[$i]."'>". $sort_by_array_display[$i]."</option>" ."<br>";
			}
		?>
	</select>
	<input type="button" id = "reset_sort" value= "Reset Sort Values" onclick="onChangeDropdown(0)">

<br><br>
	
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
		document.getElementById("form_second").disabled=false;
		document.getElementById("form_first").disabled=false;
		document.getElementById("form_third").disabled=false;
		return true;
			
	}
	
	function onChangeDropdown(dropdown_num)
	{
		if(dropdown_num==0){
			var sort_list = <?php echo json_encode($sort_by_array_display)?>;
			var sort_val_list = <?php echo json_encode($sort_by_array_val)?>;
			document.getElementById("form_second").disabled=true;
			document.getElementById("form_third").disabled=true;
			document.getElementById("form_second").value="";
			document.getElementById("form_third").value="";
			drop_size=document.getElementById("form_second").length;
			for(i=drop_size-1; i>=0; i--){
				document.getElementById("form_second").remove(i);
			}
			drop_size=document.getElementById("form_third").length;
			for(i=drop_size-1; i>=0; i--){
				document.getElementById("form_third").remove(i);
			}
			for(i=0; i<sort_list.length; i++){
				var option = document.createElement("option");
				option.text = sort_list[i];
				option.value = sort_val_list[i];
				document.getElementById("form_second").add(option);
				var option = document.createElement("option");
				option.text = sort_list[i];
				option.value = sort_val_list[i];
				document.getElementById("form_third").add(option);
			}
			
			document.getElementById("form_first").disabled=false;
			document.getElementById("form_first").value="";
		}
		if(dropdown_num==1){
			document.getElementById("form_second").disabled=false;
			document.getElementById("form_first").disabled=true;
			document.getElementById("form_second").remove(document.getElementById("form_first").selectedIndex);
			document.getElementById("form_third").remove(document.getElementById("form_first").selectedIndex);
		}
		if(dropdown_num==2){
			document.getElementById("form_second").disabled=true;
			document.getElementById("form_third").disabled=false;
			document.getElementById("form_third").remove(document.getElementById("form_second").selectedIndex);
		}
		if(dropdown_num==3){
			
		}
	}
</script>

