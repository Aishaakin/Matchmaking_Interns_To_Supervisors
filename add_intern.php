<?php
session_start();
if ($_SESSION['role'] != 'supervisor') {
    header('Location: login.php');
    exit();
}
include('config.php');

// Process the form when it is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $plain_password = $_POST['password'];
    $supervisor_id = $_SESSION['user_id']; // Automatically assign to logged-in supervisor

    // Hash the password
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

    // Insert into database
    $sql = "INSERT INTO interns (name, email, password, supervisor_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $hashed_password, $supervisor_id);

    if ($stmt->execute()) {
        $message = "Intern added successfully!";
    } else {
        $error = "Error adding intern: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Intern</title>
</head>
<body>
    <h2>Add a New Intern</h2>
    <a href="supervisor_dashboard.php">Back to Dashboard</a><br><br>

    <?php if (isset($message)) echo "<p style='color: green;'>$message</p>"; ?>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form method="POST" action="">
        <input type="text" name="name" placeholder="Intern Name" required><br><br>
        <input type="email" name="email" placeholder="Intern Email" required><br><br>
        <input type="password" name="password" placeholder="Temporary Password" required><br><br>
        <input type="submit" value="Add Intern">
    </form>
</body>
</html>