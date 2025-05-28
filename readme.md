<?php 
session_start(); 
include "koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Modern Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0ecb63 0%, #4ade80 25%, #22d3ee 50%, #3b82f6 75%, #8b5cf6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.05"/><circle cx="10" cy="50" r="1" fill="white" opacity="0.05"/><circle cx="90" cy="30" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: -2s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            left: 80%;
            animation-delay: -4s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 30%;
            left: 70%;
            animation-delay: -1s;
        }

        .shape:nth-child(4) {
            width: 40px;
            height: 40px;
            top: 70%;
            left: 20%;
            animation-delay: -3s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 
                0 8px 32px rgba(14, 203, 99, 0.2),
                0 20px 60px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.8s ease-out;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
        }

        .form-control {
            width: 100%;
            padding: 15px 15px 15px 45px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus {
            border-color: #0ecb63;
            box-shadow: 0 0 0 3px rgba(14, 203, 99, 0.2);
            background: rgba(255, 255, 255, 0.15);
        }

        .form-control:focus + .input-wrapper i,
        .form-control:not(:placeholder-shown) + .input-wrapper i {
            color: #0ecb63;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #0ecb63, #22d3ee);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 203, 99, 0.4);
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        .divider span {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 0 15px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            position: relative;
        }

        .register-link {
            text-align: center;
        }

        .register-link a {
            color: #0ecb63;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .register-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #0ecb63;
            transition: width 0.3s ease;
        }

        .register-link a:hover::after {
            width: 100%;
        }

        .register-link a:hover {
            color: #22d3ee;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 20px;
                padding: 30px 25px;
            }
            
            .login-header h1 {
                font-size: 24px;
            }
        }

        .success-animation {
            animation: successPulse 0.6s ease-out;
        }

        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <?php
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' and password='$password'");
        
        if(mysqli_num_rows($query) > 0){
            $data = mysqli_fetch_array($query);
            $_SESSION['user'] = $data;
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const container = document.querySelector(".login-container");
                        container.classList.add("success-animation");
                        setTimeout(() => {
                            alert("Selamat datang, '.$data['nama'].'!");
                            location.href="index.php";
                        }, 300);
                    });
                  </script>';
        } else {
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        alert("Username atau Password salah");
                        const inputs = document.querySelectorAll(".form-control");
                        inputs.forEach(input => {
                            input.style.borderColor = "#ef4444";
                            input.style.animation = "shake 0.5s ease-in-out";
                        });
                    });
                  </script>';
        }
    }
    ?>

    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-lock" style="margin-right: 10px; color: #0ecb63;"></i>Login</h1>
            <p>Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <form method="post" id="loginForm">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username Anda" required>
                    <i class="fas fa-user"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password Anda" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                Masuk
            </button>

            <div class="divider">
                <span>atau</span>
            </div>

            <div class="register-link">
                <a href="daftar.php">
                    <i class="fas fa-user-plus" style="margin-right: 5px;"></i>
                    Belum punya akun? Daftar sekarang
                </a>
            </div>
        </form>
    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    </style>

    <script>
        // Add loading state to button
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.querySelector('.btn-login');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>Memproses...';
            btn.disabled = true;
        });

        // Add input animation effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>