
<?php
$host = "db";
$username = "root";
$password = "root123";
$database = "student_db";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
