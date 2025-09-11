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
    $supervisor_id = $_SESSION['user_id'];

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
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="add_intern.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>➕ Add New Intern</h2>
        </div>
        
        <div class="nav-links">
            <a href="supervisor_dashboard.php" class="nav-link dashboard">📊 Back to Dashboard</a>
        </div>

        <?php if (isset($message)): ?>
            <div class="message success">✅ <?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="message error">❌ <?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Intern Full Name" required>
            </div>
            
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Temporary Password" required>
            </div>
            
            <button type="submit" class="btn">Add Intern</button>
        </form>
        
        <div class="password-note">
        <strong>Note:</strong> This is the intern initial password. They can change it later.
        </div>
    </div>
</body>
</html>