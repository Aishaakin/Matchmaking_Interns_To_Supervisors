<?php
session_start();
include('config.php');

// 1. Get data from the login form
$email = $_POST['email'];
$password = $_POST['password'];

// 2. Check in the supervisors table first
$sql = "SELECT * FROM supervisors WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // A supervisor with that email exists
    $supervisor = $result->fetch_assoc(); // Get their data

    // 3. Verify the submitted password against the stored HASHED password
    if (password_verify($password, $supervisor['password'])) {
        // Password is correct! Log the supervisor in.
        $_SESSION['user_id'] = $supervisor['id'];
        $_SESSION['role'] = 'supervisor';
        $_SESSION['name'] = $supervisor['name'];
        header('Location: supervisor_dashboard.php');
        exit(); // STOP script after a redirect
    } else {
        // Password was incorrect - REDIRECT WITH ERROR
        header('Location: login.php?error=1');
        exit();
    }
} 

// 4. If not found in supervisors, check in the interns table
else {
    $sql = "SELECT * FROM interns WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $intern = $result->fetch_assoc();
        if (password_verify($password, $intern['password'])) {
            // Password is correct! Log the intern in.
            $_SESSION['user_id'] = $intern['id'];
            $_SESSION['role'] = 'intern';
            $_SESSION['name'] = $intern['name'];
            header('Location: intern_dashboard.php');
            exit();
        } else {
            // Password was incorrect - REDIRECT WITH ERROR
            header('Location: login.php?error=1');
            exit();
        }
    } 

    // 5. If email is not found in ANY table - REDIRECT WITH ERROR
    else {
        header('Location: login.php?error=1');
        exit();
    }
}

$conn->close();
?>