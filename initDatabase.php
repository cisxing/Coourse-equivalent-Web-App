<?php
include 'global_vars.php';

//code from http://www.w3schools.com/php/php_mysql_connect.asp
//This opens the connection to the server
$servername = "localhost";
$username = "root";
$password = "pass123";
$database = "courseEquivalentDB";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//Drop database
//$sql = "DROP database courseEquivalentDB";
//makeSqlQuery($conn, $sql, "Database deleted successfully");

// Create database
$sql = "CREATE DATABASE courseEquivalentDB";

makeSqlQuery($conn, $sql, "Database created successfully");

$conn->close();

$conn = new mysqli($servername, $username, $password, $database);

// sql to create table
$sql = "CREATE TABLE mhc_equiv_courses (
id INT(8) UNSIGNED PRIMARY KEY, 
name VARCHAR(30) NOT NULL,
number VARCHAR(10) NOT NULL,
credits INT NOT NULL,
institution VARCHAR(30) NOT NULL,
mhc_course VARCHAR(20) NOT NULL,
prereq101 BOOLEAN DEFAULT 0,
prereq201 BOOLEAN DEFAULT 0,
prereq211 BOOLEAN DEFAULT 0,
prereq221 BOOLEAN DEFAULT 0,
prereq_math BOOLEAN DEFAULT 0,
prof_prereq TEXT NOT NULL,
notes TEXT NOT NULL,
day SMALLINT NOT NULL,
month SMALLINT NOT NULL,
year SMALLINT NOT NULL,
professor VARCHAR(20) NOT NULL,
approved BOOLEAN DEFAULT 0,
reg_date TIMESTAMP
)";

makeSqlQuery($conn, $sql, "mhc_equiv_courses created successfully");

$sql = "CREATE TABLE mhc_course_pdfs(
id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
class_id INT(8) UNSIGNED,
syllabus TEXT NOT NULL,
syllabus_type VARCHAR(30) NOT NULL,
syllabus_size INT NOT NULL,
syllabus_name VARCHAR(60) NOT NULL,
reg_date TIMESTAMP
)";

makeSqlQuery($conn, $sql, "mhc_course_pdfs created successfully");

$sql = "CREATE TABLE counters(
id INT(8) UNSIGNED PRIMARY KEY,
cur_val INT(8) UNSIGNED)";

makeSqlQuery($conn, $sql, "counters created successfully");

$sql = "INSERT INTO counters values (1,1)";

makeSqlQuery($conn, $sql, "insert complete");

$sql = "CREATE TABLE mhc_course_links(
id INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
class_id INT(8) UNSIGNED,
link TEXT)";

makeSqlQuery($conn, $sql, "Created links database");

?>