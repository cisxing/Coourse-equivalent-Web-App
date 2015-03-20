<?php
$name = $_POST["courseTitle"];
$number = $_POST["courseNumber"];
$institution = $_POST["formInstitution"];
$mhc_course = $_POST["formMHCEquivalent"];
//make connections
mysql_connect('localhost','cis','19931029');
//select db
mysql_select_db('courseEquivalentDB');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if(!isset($_POST["courseTitle"]||$_POST["courseNumber"]||$_POST["formInstitution"]||$_POST["formMHCEquivalent"]))
{
	echo Please enter at least one query;
	//header("Location:index.php")
}

$sql= "SELECT * FROM mhc_equiv_courses";
$records = mysql_query($sql);


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
while ($course=mysql_fetch_assoc($records)){
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
	echo '<td><a href="http://'.$course['link'].'">'.link.'</a></td>';
	
	echo "<tr>";
}

?>


</table>
</body>

</html>