<?php
session_start();
include "includes/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Modern Interface</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0ecb63, #ffffff, #0ecb63);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 20%, rgba(14, 203, 99, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 90% 10%, rgba(14, 203, 99, 0.05) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float {
            0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
            33% { transform: translate(-48%, -52%) rotate(1deg); }
            66% { transform: translate(-52%, -48%) rotate(-1deg); }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .container {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            width: 400px;
            max-width: 90vw;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1),
                        0 0 0 1px rgba(255, 255, 255, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.4);
            animation: slideIn 0.8s ease-out;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.8s ease;
        }

        .container:hover::before {
            left: 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-subtitle {
            color: #4a5568;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            color: #2d3748;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            font-size: 1rem;
            color: #2d3748;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .form-input:focus {
            outline: none;
            border-color: #0ecb63;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 0 3px rgba(14, 203, 99, 0.1),
                        inset 0 2px 4px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .form-input:focus + .form-label {
            color: #0ecb63;
        }

        .button-group {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-top: 30px;
        }

        .btn-login {
            flex: 1;
            padding: 15px 25px;
            background: linear-gradient(135deg, #0ecb63, #0db356);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(14, 203, 99, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(14, 203, 99, 0.4);
            animation: pulse 0.6s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(14, 203, 99, 0.3);
        }

.register_link {
    color: #0ecb63;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
}

.spanw {
    font-size: 0.9rem;
    padding-top: 18px;
    display: inline-block;
}

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.5s ease-out;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: linear-gradient(135deg, #0ecb63, #0db356);
        }

        .alert-error {
            background: linear-gradient(135deg, #e53e3e, #c53030);
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .register-link {
                text-align: center;
            }
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #0ecb63;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .form-group:focus-within .input-icon {
            opacity: 1;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .shape {
            position: absolute;
            background: rgba(14, 203, 99, 0.1);
            border-radius: 50%;
            animation: floatShapes 15s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: -5s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: -10s;
        }

        @keyframes floatShapes {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <?php

    if (isset($_POST['username'])) {
        
        $username = $_POST['username'];
        $password = md5 ($_POST['password']);

        $query = mysqli_query($koneksi, "SELECT*FROM user WHERE username='$username' and password='$password'");
        if (!$query) {
            die('Query Error: ' . mysqli_error($koneksi));
        }
    
        if(mysqli_num_rows($query) > 0){
            $data = mysqli_fetch_array($query);
            $_SESSION['user'] = $data;
            echo '<script>alert("selamat datang, '.$data['nama']. '");
            location.href="admin.php"; </script>';

        }else{

            echo '<script>alert("Username atau Password salah");</script>';

        }


        }
        
    
    

    ?>

    <div class="container">
        <div class="login-header">
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Please sign in to your account</p>
        </div>

        <form method="post">
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" name="username" id="username" class="form-input" required>
                <div class="input-icon">✓</div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-input" required>
                <div class="input-icon">✓</div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-login">Sign In</button>
                
            </div>
            <div align="center">
                <span class="spanw">Don't have an account? </span>
                <a href="register.php" class="register-link">Create here!</a>
            </div>
        </form>
    </div>

    <script>
        // Auto-hide alerts after 3 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.animation = 'slideIn 0.5s ease-out reverse';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);

        // Add smooth focus animations
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>