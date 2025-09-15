<?php
$servername = "localhost";
$username = "root"; // Default password of username
$password = "";     // The default xampp password is blank
$dbname = "intern_tracker_db"; // The database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>