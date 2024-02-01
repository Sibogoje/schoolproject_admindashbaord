<?php
// Database configuration
$host = "195.35.53.20"; // Database host
$dbname = "u747325399_project"; // Database name
$username = "u747325399_project"; // Database username
$password = "project!1STPY"; // Database password

// Create a new database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Uncomment the below line for MySQLi to report every error (for development purposes)
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Set the correct charset to ensure proper encoding of data
$conn->set_charset("utf8mb4");

// Use this to close the database connection in your scripts when done
// $conn->close();
?>
