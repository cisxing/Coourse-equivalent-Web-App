<?php
//code from http://www.w3schools.com/php/php_mysql_connect.asp
//This opens the connection to the server
$servername = "localhost";
$username = "cis";
$password = "19931029";
$database = "courseEquivalentDB";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE courseEquivalentDB";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();

$conn = new mysqli($servername, $username, $password, $database);

//sql to delete table
//$sql = "DROP TABLE mhc_equiv_courses";

// sql to create table


$sql = "CREATE TABLE mhc_equiv_courses (
id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(30) NOT NULL,
number VARCHAR(10) NOT NULL,
credits INT NOT NULL,
institution VARCHAR(30) NOT NULL,
mhc_course VARCHAR(20) NOT NULL,
syllabus MEDIUMBLOB NOT NULL,
syllabus_type VARCHAR(30) NOT NULL,
syllabus_size INT NOT NULL,
syllabus_name VARCHAR(30) NOT NULL,
link TEXT NOT NULL,
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

if ($conn->query($sql) === TRUE) {
    echo "Table mhc_equiv_courses created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

?>