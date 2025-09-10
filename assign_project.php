<?php
session_start();
// Check if user is logged in and is a supervisor
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'supervisor') {
    header('Location: login.php');
    exit();
}

include('config.php');

// 1. GET THE FORM DATA SAFELY
// Use isset() to check if the form field exists before trying to use it.
$title = isset($_POST['title']) ? $_POST['title'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$intern_id = isset($_POST['intern_id']) ? (int)$_POST['intern_id'] : 0; // (int) ensures it's a number
$deadline = isset($_POST['deadline']) ? $_POST['deadline'] : '';

// 2. BASIC VALIDATION (Check if required fields are not empty)
if (empty($title) || empty($intern_id) || empty($deadline)) {
    die("Error: Please fill in all required fields (Title, Intern, and Deadline). <a href='supervisor_dashboard.php'>Go back</a>");
}

// 3. Get the supervisor's ID from the session
$supervisor_id = $_SESSION['user_id'];

// 4. PREPARE THE SQL QUERY (This is safer and prevents SQL injection attacks!)
$sql = "INSERT INTO projects (title, description, assigned_by, assigned_to, deadline) VALUES (?, ?, ?, ?, ?)";

// Prepare the statement
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind parameters: 's' for string, 'i' for integer, 's' for string
    $stmt->bind_param("ssiis", $title, $description, $supervisor_id, $intern_id, $deadline);

    // Execute the query
    if ($stmt->execute()) {
        // Success! Redirect back to the dashboard.
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