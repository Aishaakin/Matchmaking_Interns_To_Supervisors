<?php
session_start();
// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ' . ($_SESSION['role'] == 'supervisor' ? 'supervisor_dashboard.php' : 'intern_dashboard.php'));
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Intern Tracker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            max-width: 450px;
            width: 100%;
            background: white;
            padding: 40px 35px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .header p {
            color: #7f8c8d;
            font-size: 16px;
            font-weight: 500;
        }
        
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
            display: none;
            animation: slideDown 0.3s ease;
        }
        
        .message.error {
            background-color: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .form-row {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .form-row label {
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .input-group {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            padding: 0 15px;
            transition: all 0.3s ease;
        }
        
        .input-group:focus-within {
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            transform: translateY(-2px);
        }
        
        .input-group i {
            color: #7f8c8d;
            margin-right: 10px;
            font-size: 18px;
        }
        
        .form-control {
            flex: 1;
            padding: 15px 0;
            border: none;
            background: transparent;
            font-size: 16px;
            color: #2c3e50;
            outline: none;
        }
        
        .form-control::placeholder {
            color: #95a5a6;
        }
        
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 10px;
        }
        
        .btn {
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2980b9 0%, #2573a7 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }
        
        .btn-secondary {
            background: transparent;
            color: #7f8c8d;
            border: 2px solid #bdc3c7;
        }
        
        .btn-secondary:hover {
            background: #f8f9fa;
            border-color: #95a5a6;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
        }
        
        .footer p {
            color: #7f8c8d;
            font-size: 14px;
            font-weight: 500;
        }
        
        .demo-hint {
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        
        .demo-hint strong {
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 30px 25px;
            }
            
            .header h1 {
                font-size: 28px;
            }
            
            .btn {
                padding: 14px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Login Page</h1>
            <p>Sign in to your account</p>
        </div>
        
        <div class="message error" id="errorMessage">
            <i class="fas fa-exclamation-circle"></i>
            Invalid login credentials. Please try again.
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
                
                <button type="button" class="btn btn-secondary" onclick="fillDemo('supervisor')">
                    <i class="fas fa-user-tie"></i>
                    Use Supervisor Demo
                </button>
                
                <button type="button" class="btn btn-secondary" onclick="fillDemo('intern')">
                    <i class="fas fa-user-graduate"></i>
                    Use Intern Demo
                </button>
            </div>
        </form>
        
        <div class="demo-hint">
            <strong>Demo Credentials</strong>
            Supervisor: admin@company.com / mypassword123<br>
            Intern: intern@company.com / intern123
        </div>
     
        <div class="footer">
            <p>© 2025 Aisha Akinsanya Intern Tracker System</p>
        </div>
    </div>

    <script>
        // Show error message if URL has error parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('error')) {
                document.getElementById('errorMessage').style.display = 'block';
                
                // Auto-hide error message after 5 seconds
                setTimeout(function() {
                    document.getElementById('errorMessage').style.display = 'none';
                }, 5000);
            }
        });
        
        // Function to fill demo credentials
        function fillDemo(type) {
            if (type === 'supervisor') {
                document.getElementById('email').value = 'admin@company.com';
                document.getElementById('password').value = 'password123';
            } else if (type === 'intern') {
                document.getElementById('email').value = 'intern@company.com';
                document.getElementById('password').value = 'intern123';
            }
            
            // Show confirmation message
            const message = document.getElementById('errorMessage');
            message.textContent = '✓ Demo credentials filled! Click Login to continue.';
            message.className = 'message';
            message.style.display = 'block';
            message.style.background = '#efe';
            message.style.color = '#363';
            message.style.border = '1px solid #cfc';
            
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>