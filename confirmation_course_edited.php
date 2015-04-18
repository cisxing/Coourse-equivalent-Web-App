<!DOCTYPE HTML>

<html> 

<head>
<link rel="stylesheet" type="text/css" href="style_one.css">
</head>

<?php
include 'global_vars.php';

$conn = connectToDatabase();

$name = $_POST["courseTitle"];
?>

<body>
<h1>
Changes Made to "<?php echo $name;?>"
</h1>

<p>
<?php

$id = $_POST["class_id"];

$department = $_POST["department"];
$number =$_POST["courseNumber"];
$credits = $_POST["credit"];

$institution = $_POST["formInstitution"];
$description = $_POST["description"];

$mhc_course = $_POST["formMHCEquivalent"];

//get pdf

$number_pdfs = count($_FILES['userfile']['name']);
if($_FILES['userfile']['name'][0] == ''){
	$number_pdfs=0;
}
$syllabus = [];
$syllabus_size = [];
$syllabus_type = [];
$syllabus_name = [];
for($i=0; $i<$number_pdfs; $i++){
	$tmpName  = $_FILES['userfile']['tmp_name'][$i];
	$fp = fopen($tmpName, 'r');
	$syllabus_cur = fread($fp, filesize($tmpName));
	fclose($fp);
	$syllabus[] = $syllabus_cur;
	$syllabus_type[] = $_FILES['userfile']['type'][$i];
	$syllabus_size[] = $_FILES['userfile']['size'][$i];
	$syllabus_name[] = $_FILES['userfile']['name'][$i];
}

$link = $_POST["website"];
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
$prof_prereq = $_POST["profPrereqs"];
$notes = $_POST["notes"];

$day = $_POST["day"];
$month = $_POST["month"];
$year = $_POST["year"];

$professor = $_POST["professorApproving"];
$approved = false;
if(isset($_POST["approved"]) && $_POST["approved"]=="true"){
	$approved = true;
}

/**** Add and Delete FILES****/
//get the pdfs to delete
$num_cur_pdfs = $_POST["num_pdfs"];
$pdfs_delete = array();
for($j=0; $j<$num_cur_pdfs; $j++){
	$current_cur_pdf = "pdf" . $j;
	if(isset($_POST[$current_cur_pdf]) && $_POST[$current_cur_pdf]=="true"){
		
	}
	else{
		array_push($pdfs_delete, $j);
	}
}

//get pdfs
$sql = "Select syllabus_name, syllabus from mhc_course_pdfs where class_id=" . $id;
$result = $conn->query($sql);

$pdf_arr_db = array();
$pdf_arr_server = array();
$highest_num=0;
$id_mod = $id % 10;
if($result->num_rows >0){
	while($row=$result->fetch_assoc()){
		array_push($pdf_arr_server, $row["syllabus"]);
		array_push($pdf_arr_db, $row["syllabus_name"]);
		$pdf_num_with_type = substr($row["syllabus"], $id_mod-1+strlen($folder_path));
		$period_index = strpos($pdf_num_with_type,".");
		$pdf_num = substr($pdf_num_with_type,0, $period_index);
		if($pdf_num>$highest_num){
			$highest_num=$pdf_num;
		}
	}
}

$start_num = $highest_num+1;

//add new pdfs
//id+num
for($j = 0; $j<$number_pdfs; $j++){
		$file_type = strrchr($syllabus_name[$j], '.');
		$num_of_pdf = $start_num + $j;
		$pdf_server_name = $folder_path. $id . $num_of_pdf . $file_type;
		
		$myfile = fopen($pdf_server_name, "w");
		fwrite($myfile, $syllabus[$j]);
		fclose($myfile);
		
		//move_uploaded_file ( string $filename , string $folder_path );
		//save to database
		$sql = "INSERT INTO mhc_course_pdfs (
			class_id,
			syllabus,
			syllabus_type,
			syllabus_size,
			syllabus_name) Values (" . $id . ", '". $pdf_server_name . "', '" .
			$syllabus_type[$j] . "', " . $syllabus_size[$j] . ", '" . 
			$syllabus_name[$j] . "')";
		
		makeSqlQuery($conn, $sql, "");
	}

//delete old pdfs
for($z=0; $z<count($pdfs_delete); $z++){
	$delete_index = $pdfs_delete[$z];
	$sql = "delete from mhc_course_pdfs 
		where (class_id=" . $id . " and syllabus_name ='" . $pdf_arr_db[$z]. "')";
	makeSqlQuery($conn, $sql, "");
	unlink($pdf_arr_server[$z]);
}


/***** Add and Delete Links******/

//get previous links
$sql = "Select link from mhc_course_links where class_id=" . $id;
$result = $conn->query($sql);

$links_arr = array();
if($result->num_rows >0){
	while($row=$result->fetch_assoc()){
		array_push($links_arr, $row["link"]);
	}
}

$new_links_csv = str_getcsv($link);
$new_links= array();
for($i=0; $i<count($new_links_csv); $i++){
	array_push($new_links, str_replace(' ', '', $new_links_csv[$i]));
}

//find links to delete
$deleted_links = array();
for($k=0; $k<count($links_arr); $k++){
	if(!in_array($links_arr[$k],$new_links)){
		array_push($deleted_links, $links_arr[$k]);
		$sql = "delete from mhc_course_links 
			where (class_id=" . $id. " and link ='" . $links_arr[$k]. "')";
		makeSqlQuery($conn, $sql, "");
	}
}

//find links to add
$added_links = array();
for($j=0; $j<count($new_links); $j++){
	if(!in_array($new_links[$j], $links_arr)){
		array_push($added_links, $new_links[$j]);
		$sql = "INSERT INTO mhc_course_links (
			class_id,
			link) Values (" . $id . ", '". $new_links[$j] . "')";
		
		makeSqlQuery($conn, $sql, "");
	}
}

/****** Update other information******/
$sql = "SELECT name, department, number, credits, institution, description,
mhc_course, prereq101, prereq201, prereq211, prereq221, prereq_math,
prof_prereq, notes, day, month, year, professor, approved FROM mhc_equiv_courses
Where id=" . $id;
$result = $conn->query($sql);
$row=$result->fetch_assoc();	
		
//update course title
if($row["name"]!=$name){
	$sql = "UPDATE mhc_equiv_courses SET name = '" . $name . "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	echo "Course name was changed to: " . $name. "<br><br>";
}
//update department
if($row["department"]!=$department){
	$sql = "UPDATE mhc_equiv_courses SET department = '" . $department . "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	echo "Department was changed to: " . $department. "<br><br>";
}
//update course number
if($number != $row["number"]){
	$sql = "UPDATE mhc_equiv_courses SET number = " . $number . " where id =". $id;
	makeSqlQuery($conn, $sql, "");
	echo "Course number has been changed to: " . $number. "<br><br>";
}
//update number of credits
if($credits != $row["credits"]){
	$sql = "UPDATE mhc_equiv_courses SET credits = " . $credits . " where id =". $id;
	makeSqlQuery($conn, $sql, "");
	echo "Number of credits has been changed to: " . $credits. " credits". "<br><br>";
}
//update institution
if($institution != $row["institution"]){
	$sql = "UPDATE mhc_equiv_courses SET institution = '" . $institution. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	echo "Institution has been changed to: " . $institution. "<br><br>";
}
//update description
if($description != $row["description"]){
	$sql = "UPDATE mhc_equiv_courses SET description = '" . $description. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	echo "Description has been changed to: " . $description. "<br><br>";
}
//update mhc equivalent course
if($mhc_course != $row["mhc_course"]){
	$sql = "UPDATE mhc_equiv_courses SET mhc_course = '" . $mhc_course. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	echo "This course is equivalent to the following MHC Course: " . $mhc_course. "<br><br>";
}

if(count($pdfs_delete)>0){
	echo "The following files were deleted:<br>";
	for($p=0; $p<count($pdfs_delete); $p++){
		echo $pdf_arr_db[$p] . "<br>";
	}
	echo "<br>";
}

if($number_pdfs>0){
	echo "The following files were added:<br>";
	for($j = 0; $j<$number_pdfs; $j++){
		echo $syllabus_name[$j]. "<br>";
	}
	echo "<br>";
}

if(count($deleted_links)>0){
	echo "The following links were deleted:<br>";
	for($j=0; $j<count($deleted_links); $j++){
		echo $deleted_links[$j]."<br>";
	}
	echo "<br>";
}

if(count($added_links)>0){
	echo "The following links were added:<br>";
	for($j=0; $j<count($added_links); $j++){
		echo $added_links[$j]."<br>";
	}
	echo "<br>";
	
}

//update mhc prereqs
if($prereq101 != $row["prereq101"]){
	$sql = "UPDATE mhc_equiv_courses SET prereq101 = '" . $prereq101. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	if($prereq101==0){
		echo "This course no longer has CS 101 as a prerequisite.<br><br>";
	}
	else{
		echo "This course now has CS 101 as a prerequisite.<br><br>";
	}
}
if($prereq201 != $row["prereq201"]){
	$sql = "UPDATE mhc_equiv_courses SET prereq201 = '" . $prereq201. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	if($prereq201==0){
		echo "This course no longer has CS 201 as a prerequisite.<br><br>";
	}
	else{
		echo "This course now has CS 201 as a prerequisite.<br><br>";
	}
}
if($prereq211 != $row["prereq211"]){
	$sql = "UPDATE mhc_equiv_courses SET prereq211 = '" . $prereq211. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	if($prereq211==0){
		echo "This course no longer has CS 211 as a prerequisite.<br><br>";
	}
	else{
		echo "This course now has CS 211 as a prerequisite.<br><br>";
	}
}
if($prereq221 != $row["prereq221"]){
	$sql = "UPDATE mhc_equiv_courses SET prereq221 = '" . $prereq221. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	if($prereq221==0){
		echo "This course no longer has CS 221 as a prerequisite.<br><br>";
	}
	else{
		echo "This course now has CS 221 as a prerequisite.<br><br>";
	}
}
if($prereq_math !=$row["prereq_math"]){
	$sql = "UPDATE mhc_equiv_courses SET prereq_math = '" . $prereq_math. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	if($prereq_math==0){
		echo "This course no longer has Math 232 as a prerequisite.<br><br>";
	}
	else{
		echo "This course now has Math 232 as a prerequisite.<br><br>";
	}
}
//update prof prereqs
if($prof_prereq != $row["prof_prereq"]){
	$sql = "UPDATE mhc_equiv_courses SET prof_prereq = '" . $prof_prereq. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	echo "The professor specified prerequisites have been changed to: ". $prof_prereq. "<br><br>";
}
//update notes
if($notes != $row["notes"]){
	$sql = "UPDATE mhc_equiv_courses SET notes = '" . $notes. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	echo "The notes have been changed to: ". $notes. "<br><br>";
}
$date_changed = false;
//update date
if($month != $row["month"]){
	$sql = "UPDATE mhc_equiv_courses SET month = '" . $month. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	$date_changed=true;
}
if($day != $row["day"]){
	$sql = "UPDATE mhc_equiv_courses SET day = '" . $day. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	$date_changed=true;
}
if($year != $row["year"]){
	$sql = "UPDATE mhc_equiv_courses SET year = '" . $year. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	$date_changed=true;
}

if($date_changed==true){
	echo "The approval date is now: " . $month . "/" . $day . "/". $year . "<br><br>";
}
//update professor
if($professor != $row["professor"]){
	$sql = "UPDATE mhc_equiv_courses SET professor = '" . $professor. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	echo "The professor who evaluated this course is: " . $professor. "<br><br>";
}
//update course approved
if($approved != $row["approved"]){
	$sql = "UPDATE mhc_equiv_courses SET approved = '" . $approved. "' where id =". $id;
	makeSqlQuery($conn, $sql, "");
	if($approved==0){
		echo "This course is no longer approved to count towards the major. <br><br>";
	}
	else{
		echo "This course is now approved to count towards the major.<br><br>";
	}
}

?>

</p>

<form name= "navigation" action="show_details.php" method="get">
	<input type="hidden" name="data" value="<?php echo $id; ?>">
	<input type="submit" value="Return to Course Details">
	<input type="submit" value="Search for a New Class" onclick="navigation.action='search_course.php';return true;">
<form/>

</body>

</html>