<?php
session_start();
include('config.php');

//Get  the data of user from the login form
$email = $_POST['email'];
$password = $_POST['password'];

// Check supervisors table first
$sql = "SELECT * FROM supervisors WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
// check supervisor with that email exits
    $supervisor = $result->fetch_assoc(); 

// Verify the submitted password match the hashed password
    if (password_verify($password, $supervisor['password'])) {
        // login supervisor if the password match
        $_SESSION['user_id'] = $supervisor['id'];
        $_SESSION['role'] = 'supervisor';
        $_SESSION['name'] = $supervisor['name'];
        header('Location: supervisor_dashboard.php');
        exit(); 
    } else {
        // if the password doesn't not exit, show an error and redirect user to login page
        header('Location: login.php?error=1');
        exit();
    }
} 

// If supervisor is not found,check the interns table
else {
    $sql = "SELECT * FROM interns WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $intern = $result->fetch_assoc();
        if (password_verify($password, $intern['password'])) {
            // if the intern password is correct direct to intern_dashboard
            $_SESSION['user_id'] = $intern['id'];
            $_SESSION['role'] = 'intern';
            $_SESSION['name'] = $intern['name'];
            header('Location: intern_dashboard.php');
            exit();
        } else {
            // if password incorrect redirect user to login page
            header('Location: login.php?error=1');
            exit();
        }
    } 
// if email is not correct show an error
    else {
        header('Location: login.php?error=1');
        exit();
    }
}

$conn->close();
?>