<?php
session_start();
include "includes/koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Modern Interface</title>
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
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            33% {
                transform: translate(-48%, -52%) rotate(1deg);
            }

            66% {
                transform: translate(-52%, -48%) rotate(-1deg);
            }
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

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .container {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 40px;
            width: 450px;
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

        .register-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .register-title {
            font-size: 2rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .register-subtitle {
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

        .form-input:focus+.form-label {
            color: #0ecb63;
        }

        .password-strength {
            margin-top: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            font-size: 0.8rem;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .password-strength.show {
            opacity: 1;
            transform: translateY(0);
        }

        .strength-weak {
            color: #e53e3e;
        }

        .strength-medium {
            color: #dd6b20;
        }

        .strength-strong {
            color: #0ecb63;
        }

        .button-group {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-top: 30px;
        }

        .btn-register {
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

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(14, 203, 99, 0.4);
            animation: pulse 0.6s ease;
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(14, 203, 99, 0.3);
        }

        .btn-register:disabled {
            background: linear-gradient(135deg, #a0aec0, #718096);
            cursor: not-allowed;
            transform: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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

        .login-link:hover {
            background: rgba(14, 203, 99, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(14, 203, 99, 0.2);
        }

        .alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px 30px;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.5s ease-out;
            z-index: 1000;
            backdrop-filter: blur(10px);
            text-align: center;
            min-width: 250px;
        }

        .alert-success {
            background: linear-gradient(135deg, #0ecb63, #0db356);
        }

        .alert-error {
            background: linear-gradient(135deg, #e53e3e, #c53030);
        }

        .hidden {
            display: none !important;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            animation: fadeIn 0.3s ease;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(14, 203, 99, 0.3);
            border-top: 4px solid #0ecb63;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }

            .button-group {
                flex-direction: column;
            }

            .login-link {
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

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-20px) rotate(120deg);
            }

            66% {
                transform: translateY(10px) rotate(240deg);
            }
        }

        .form-validation {
            margin-top: 5px;
            font-size: 0.8rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .form-validation.show {
            opacity: 1;
        }

        .validation-error {
            color: #e53e3e;
        }

        .validation-success {
            color: #0ecb63;
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
        $nama = $_POST['nama'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // Ngecek kesamaan
        $check_query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");

        if (mysqli_num_rows($check_query) > 0) {
            echo '<div class="alert alert-error">Username sudah digunakan! Pilih username lain.</div>';
        } else {
            $query = mysqli_query($koneksi, "INSERT INTO user(nama,username,password) values('$nama','$username','$password')");

            if ($query) {
                echo '<script>
        alert("Pendaftaran berhasil! Silakan login.");
        window.location = "login.php";
    </script>';
                exit;
            } else {
                echo '<div class="alert alert-error">Gagal mendaftar! Silakan coba lagi.</div>';
            }
        }
    }
    ?>

    <div class="container">
        <div class="register-header">
            <h1 class="register-title">Create Account</h1>
            <p class="register-subtitle">Join us today and get started</p>
        </div>

        <form method="post" id="registerForm">
            <div class="form-group">
                <label class="form-label" for="nama">Full Name</label>
                <input type="text" name="nama" id="nama" class="form-input" required>
                <div class="input-icon">✓</div>
                <div class="form-validation" id="namaValidation"></div>
            </div>

            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" name="username" id="username" class="form-input" required>
                <div class="input-icon">✓</div>
                <div class="form-validation" id="usernameValidation"></div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-input" required>
                <div class="input-icon">✓</div>
                <div class="password-strength" id="passwordStrength"></div>
                <div class="form-validation" id="passwordValidation"></div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-register" id="submitBtn">Create Account</button>
            </div>
            <div align="center">
                <span class="spanw">Already have an account? </span>
                <a href="login.php" class="register-link">Sign in</a>
            </div>
        </form>
    </div>

    <script>
        // Auto-hide error alerts after 3 seconds
        setTimeout(function () {
            const errorAlerts = document.querySelectorAll('.alert-error');
            errorAlerts.forEach(alert => {
                alert.style.animation = 'slideIn 0.5s ease-out reverse';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);

        // Form validation
        const namaInput = document.getElementById('nama');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const submitBtn = document.getElementById('submitBtn');

        // Name validation
        namaInput.addEventListener('input', function () {
            const validation = document.getElementById('namaValidation');
            if (this.value.length < 2) {
                validation.textContent = 'Name must be at least 2 characters';
                validation.className = 'form-validation validation-error show';
            } else if (this.value.length > 50) {
                validation.textContent = 'Name is too long';
                validation.className = 'form-validation validation-error show';
            } else {
                validation.textContent = 'Looks good!';
                validation.className = 'form-validation validation-success show';
            }
            checkFormValid();
        });

        // Username validation
        usernameInput.addEventListener('input', function () {
            const validation = document.getElementById('usernameValidation');
            const value = this.value;

            if (value.length < 3) {
                validation.textContent = 'Username must be at least 3 characters';
                validation.className = 'form-validation validation-error show';
            } else if (value.length > 20) {
                validation.textContent = 'Username is too long';
                validation.className = 'form-validation validation-error show';
            } else if (!/^[a-zA-Z0-9_]+$/.test(value)) {
                validation.textContent = 'Only letters, numbers and underscore allowed';
                validation.className = 'form-validation validation-error show';
            } else {
                validation.textContent = 'Username available!';
                validation.className = 'form-validation validation-success show';
            }
            checkFormValid();
        });

        // Password strength checker
        passwordInput.addEventListener('input', function () {
            const strengthDiv = document.getElementById('passwordStrength');
            const validation = document.getElementById('passwordValidation');
            const password = this.value;

            if (password.length === 0) {
                strengthDiv.classList.remove('show');
                validation.classList.remove('show');
                return;
            }

            let strength = 0;
            let feedback = [];

            // Length check
            if (password.length >= 8) strength++;
            else feedback.push('at least 8 characters');

            // Uppercase check
            if (/[A-Z]/.test(password)) strength++;
            else feedback.push('uppercase letter');

            // Lowercase check
            if (/[a-z]/.test(password)) strength++;
            else feedback.push('lowercase letter');

            // Number check
            if (/\d/.test(password)) strength++;
            else feedback.push('number');

            // Special character check
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
            else feedback.push('special character');

            strengthDiv.classList.add('show');

            if (strength < 2) {
                strengthDiv.textContent = 'Weak password';
                strengthDiv.className = 'password-strength strength-weak show';
                validation.textContent = 'Add: ' + feedback.slice(0, 2).join(', ');
                validation.className = 'form-validation validation-error show';
            } else if (strength < 4) {
                strengthDiv.textContent = 'Medium password';
                strengthDiv.className = 'password-strength strength-medium show';
                validation.textContent = 'Add: ' + feedback.slice(0, 1).join(', ');
                validation.className = 'form-validation validation-error show';
            } else {
                strengthDiv.textContent = 'Strong password';
                strengthDiv.className = 'password-strength strength-strong show';
                validation.textContent = 'Password is secure!';
                validation.className = 'form-validation validation-success show';
            }

            checkFormValid();
        });

        // Check if form is valid
        function checkFormValid() {
            const nameValid = namaInput.value.length >= 2 && namaInput.value.length <= 50;
            const usernameValid = usernameInput.value.length >= 3 &&
                usernameInput.value.length <= 20 &&
                /^[a-zA-Z0-9_]+$/.test(usernameInput.value);
            const passwordValid = passwordInput.value.length >= 8;

            submitBtn.disabled = !(nameValid && usernameValid && passwordValid);
        }

        // Add smooth focus animations
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function () {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Add form submission loading state
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            const button = this.querySelector('.btn-register');
            button.innerHTML = '<div style="display: inline-block; width: 20px; height: 20px; border: 2px solid rgba(255,255,255,0.3); border-top: 2px solid white; border-radius: 50%; animation: spin 1s linear infinite;"></div>';
            button.disabled = true;
        });
    </script>
</body>

</html>