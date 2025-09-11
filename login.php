<?php
session_start();
// Redirect page if user already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ' . ($_SESSION['role'] == 'supervisor' ? 'supervisor_dashboard.php' : 'intern_dashboard.php'));
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page Of Intern Tracker Website</title>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Login Page</h1>
            <p>Sign in to your account</p>
        </div>
        
        <div class="message error" id="errorMessage">
            <i class="fas fa-exclamation-circle"></i>
            Invalid login credentials, pllease try again.
        </div>
        
        <form action="authenticate.php" method="post" class="login-form">
            <div class="form-row">
                <label for="email">Email Address</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
            </div>
            
            <div class="form-row">
                <label for="password">Password</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
                
                <!-- <button type="button" class="btn btn-secondary" onclick="fillDemo('supervisor')">
                    <i class="fas fa-user-tie"></i>
                    Use Supervisor Demo
                </button>
                
                <button type="button" class="btn btn-secondary" onclick="fillDemo('intern')">
                    <i class="fas fa-user-graduate"></i>
                    Use Intern Demo
                </button> -->
            </div>
        </form>
        
        <!-- <div class="demo-hint">
            <strong>Demo Credentials</strong>
            Supervisor: name@company.com / mypassword123<br>
            Intern: name@company.com / intern123
        </div>
      -->
        <div class="footer">
            <p>© 2025 Aisha Akinsanya Intern Tracker System</p>
        </div>
    </div>

    <script>
        // Show error message if the user input wrong password
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('error')) {
                document.getElementById('errorMessage').style.display = 'block';
                
                // Hide error message.
                setTimeout(function() {
                    document.getElementById('errorMessage').style.display = 'none';
                }, 5000);
            }
        });
        
        // Function to fill demo credentials
        // function fillDemo(type) {
        //     if (type === 'supervisor') {
        //         document.getElementById('email').value = 'admin@company.com';
        //         document.getElementById('password').value = 'password123';
        //     } else if (type === 'intern') {
        //         document.getElementById('email').value = 'intern@company.com';
        //         document.getElementById('password').value = 'intern123';
        //     }
            

            // Confirmation message
        //     const message = document.getElementById('errorMessage');
        //     message.style.color = 'rgba(158, 236, 158, 1)';
        //     message.textContent = 'Demo credentails filled in';
        //     message.style.display = 'block';
        //     message.className = 'message';
        //     message.style.background = '#efe';
        //     message.style.border = '1px solid #cfc';
           
            
        //     setTimeout(() => {
        //         message.style.display = 'none';
        //     }, 3000);
        // }
    </script>
</body>
</html>