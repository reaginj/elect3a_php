<?php
// connection settings for database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "user_authsystem";

// connect to mysql database
$conn = new mysqli($host, $user, $pass, $dbname);

// checks connection if failed
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// sets character set to utf8mb4 for proper encoding
$conn->set_charset("utf8mb4");
?>