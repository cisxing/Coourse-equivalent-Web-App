<?php
include 'global_vars.php';
$name = $_POST["courseTitle"];
$number = $_POST["courseNumber"];
$institution = $_POST["formInstitution"];
$mhc_course = $_POST["formMHCEquivalent"];

$conn = connectToDatabase();


$query = sprintf("select * from mhc_equiv_courses where number='%s'
UNION
select * from mhc_equiv_courses where name='%s'
UNION
select * from mhc_equiv_courses where mhc_course='%s'
UNION
select * from mhc_equiv_courses where institution='%s'",
    $number,
    $name,
    $mhc_course,
    $institution
    );

$records = $conn->query($query);


?>


<html>
<title>Details</title>
<body>
<table width = "1000" border = "1" cellpadding = "1" cellspacing = "1">
<tr>
<th>course name</th>
<th>institution</th>
<th>credits</th>
<th>equivalent mhc course</th>
<th>pre req</th>
<th>processing professor</th>
<th>process date</th>
<th>approved</th>
<th>link</th>
<tr>
<?php
while ($course=$records->fetch_assoc()){
$pre_req = "";
	echo "<tr>";

	echo "<td>".$course['name']."</td>";
	echo "<td>".$course['institution']."</td>";
	echo "<td>".$course['credits']."</td>";
	echo "<td>".$course['mhc_course']."</td>";
	if($course['prereq101']==1)
	{
		$pre_req= $pre_req."cs101";
	}
	if($course['prereq201']==1)
	{
		$pre_req= $pre_req.",cs201";
	}
	if($course['prereq211']==1)
	{
		$pre_req= $pre_req.",cs211";
	}
	if($course['prereq221']==1)
	{
		$pre_req= $pre_req.",cs221";
	}
	if($course['prereq_math']==1)
	{
		$pre_req= $pre_req.",Discrete Math";
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

?>


</table>
</body>

</html>