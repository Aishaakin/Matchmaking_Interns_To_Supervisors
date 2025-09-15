<?php
session_start();
if($_SESSION['role'] != 'supervisor') { header('Location: login.php'); exit(); }
include('config.php');

// Fetch list of interns from that supervisor with the ID
$interns = $conn->query("SELECT * FROM interns WHERE supervisor_id=" . $_SESSION['user_id']);

// Fetch projects made by that supervisor
$projects = $conn->query("SELECT * FROM projects WHERE assigned_by=" . $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Supervisor Dashboard</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/supervisor_dashboard.css">
</head>
<body>
    <h1>Welcome,<?php echo $_SESSION['name']; ?></h1>

 <div class="nav-container">
    <a href="add_intern.php" class="nav-link add-intern">Add New Intern</a>
    <a href="supervisor_dashboard.php" class="nav-link dashboard">Dashboard</a>
    <a href="logout.php" class="nav-link logout">Logout</a>
</div>

    <h2>Assign a New Project To An Intern</h2>
    <form action="assign_project.php" method="post">
        <select name="intern_id" required>
            <option value="">Select an Intern</option>
            <?php
            // drowndrops of interns names
            if ($interns->num_rows > 0) {
                while($intern = $interns->fetch_assoc()) {
                    echo '<option value="' . $intern['id'] . '">' . $intern['name'] . '</option>';
                }
            } else {
                echo '<option value="">No interns assigned to you yet </option>';
            }
            ?>
        </select><br>
        
        <input type="text" name="title" placeholder="Project Title" required><br><br>
        <textarea name="description" placeholder="Project Description" required></textarea><br><br>
        <input type="date" name="deadline" required><br><br>
        <input type="submit" value="Assign Project">
    </form>

    <h2>Current Projects</h2>
    <?php if ($projects->num_rows > 0): ?>
        <table border="3" cellpadding="15">
            <tr>
                <th>Project Title</th>
                <th>Assigned To</th>
                <th>Deadline</th>
                <th>Status</th>
            </tr>
            <?php while($project = $projects->fetch_assoc()): 
                // get intern name for this project
                $intern_result = $conn->query("SELECT name FROM interns WHERE id=" . $project['assigned_to']);
                $intern_name = $intern_result->fetch_assoc()['name'];
            ?>
            <tr>
                <td><?php echo $project['title']; ?></td>
                <td><?php echo $intern_name; ?></td>
                <td><?php echo $project['deadline']; ?></td>
                <td><?php echo $project['status']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No projects assigned yet.</p>
    <?php endif; ?>
</body>
</html>