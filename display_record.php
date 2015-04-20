<?php
include 'global_vars.php';
$name = $_POST["courseTitle"];
$number = $_POST["courseNumber"];
$institution = $_POST["formInstitution"];
$mhc_course = $_POST["formMHCEquivalent"];

$sort_one = $_POST["first_sort"];
$sort_two = $_POST["second_sort"];
$sort_three = $_POST["third_sort"];
$sort_by = "";
if($sort_one!=""){
	$sort_by = $sort_one;
	if($sort_two!=""){
		$sort_by = $sort_by . ", " . $sort_two;
		if($sort_three!=""){
			$sort_by = $sort_by . ", " . $sort_three;
		}
	}
}
else{
	$sort_by = "institution";
}
$conn = connectToDatabase();

$credit_include = $_POST["credit_include"]; 

$choose_by_credits = "";
if($credit_include=="two_credits"){
	$choose_by_credits = "and credits = '2' "; 
}
if($credit_include=="four_credits"){
	$choose_by_credits = "and credits = '4' "; 
}

$do_query= $_POST["do_query"];

if($do_query==1){
$query = sprintf("select * from mhc_equiv_courses where number='%s' ". $choose_by_credits ." 
UNION
select * from mhc_equiv_courses where name='%s' ". $choose_by_credits ." 
UNION
select * from mhc_equiv_courses where mhc_course='%s' ". $choose_by_credits ." 
UNION
select * from mhc_equiv_courses where institution='%s' ". $choose_by_credits ." Order by " . $sort_by,
    $number,
    $name,
    $mhc_course,
    $institution
    );

$records = $conn->query($query);
}
else{
$query = "SELECT id, name, department, number, credits, institution,
mhc_course, prereq101, prereq201, prereq211, prereq221, prereq_math,
prof_prereq, notes, day, month, year, professor, approved FROM mhc_equiv_courses 
Order by institution, name";
$records = $conn->query($query);
}

if(mysqli_num_rows($records)==0){
	echo "
<html>
<head>
<link rel=\"stylesheet\" type=\"text/css\" href=\"style_one.css\">
</head>
<title>Details</title>
<h1>
No Results
</h1>";
}
else{


echo "
<html>
<head>
<link rel=\"stylesheet\" type=\"text/css\" href=\"style_one.css\">
</head>
<title>Details</title>
<h1>
Search Results
</h1>
<body>
<table width = \"1000\" border = \"1\" cellpadding = \"1\" cellspacing = \"1\">
<tr>
<th>Course Name</th>
<th>Institution</th>
<th>Course Number</th>
<th>Credits</th>
<th>Equivalent MHC Course</th>
<th>Prerequisite</th>
<th>Processing Professor</th>
<th>Process Date</th>
<th>Approved</th>
<th>Link</th>
<tr>";

while ($course=$records->fetch_assoc()){
	$pre_req = "";
	echo "<tr>";

	echo "<td>".$course['name']."</td>";
	echo "<td>".$course['institution']."</td>";
	echo "<td>".$course['department']. " " .$course['number']."</td>";
	echo "<td>".$course['credits']."</td>";
	echo "<td>".$course['mhc_course']."</td>";
	if($course['prereq101']==1)
	{
		$pre_req= $pre_req."cs101, ";
	}
	if($course['prereq201']==1)
	{
		$pre_req= $pre_req."cs201, ";
	}
	if($course['prereq211']==1)
	{
		$pre_req= $pre_req."cs211, ";
	}
	if($course['prereq221']==1)
	{
		$pre_req= $pre_req."cs221, ";
	}
	if($course['prereq_math']==1)
	{
		$pre_req= $pre_req."Discrete Math, ";
	}
	if(strlen($pre_req)>0){
			$pre_req = substr($pre_req, 0, strlen($pre_req)-2);
		}
	echo "<td>".$pre_req."</td>";
	echo "<td>".$course['professor']."</td>";
	echo "<td>".$course['month'].".".$course['day'].".".$course['year']."</td>";
	if($course['approved']==1)
	{
		echo "<td>"."yes"."</td>";
	}
	else
	{
		echo "<td>"."no"."</td>";
	}
	echo '<td><a href="./show_details.php?data='.$course['id'].'">'. "Details".'</a></td>';
	
	echo "<tr>";
}



echo"</table>
</body>
<br>";
}
?>
<?php
	echo '<a href="./search_course.php"><button type="button">'."Return To Search Page".'</button></a>';
	?>
</html>