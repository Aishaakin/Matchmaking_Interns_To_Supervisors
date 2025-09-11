<?php
session_start();
// Check if user is login as supervisor
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'supervisor') {
    header('Location: login.php');
    exit();
}

include('config.php');

$title = isset($_POST['title']) ? $_POST['title'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$intern_id = isset($_POST['intern_id']) ? (int)$_POST['intern_id'] : 0; // int must be an integer
$deadline = isset($_POST['deadline']) ? $_POST['deadline'] : '';

// check if fields are empty
if (empty($title) || empty($intern_id) || empty($deadline)) {
    die("Error: Please, fill in all the required fields. <a href='supervisor_dashboard.php'>Go back</a>");
}

//Get the supervisor id from the session
$supervisor_id = $_SESSION['user_id'];

$sql = "INSERT INTO projects (title, description, assigned_by, assigned_to, deadline) VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssiis", $title, $description, $supervisor_id, $intern_id, $deadline);

    if ($stmt->execute()) {
        // direct user to supervisor dashboard, if the logged in credentials are correct
        header('Location: supervisor_dashboard.php?msg=Project Assigned Successfully!');
        exit();
    } else {
        // If the query failed, show the error
        die("Error assigning project: " . $stmt->error . " <a href='supervisor_dashboard.php'>Go back</a>");
    }
    // Close the statement
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error . " <a href='supervisor_dashboard.php'>Go back</a>");
}

// Close the connection
$conn->close();
?>