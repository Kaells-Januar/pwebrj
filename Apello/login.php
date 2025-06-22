<?php
session_start();

// Menyambungkan ke database
include "includes/koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Pengaturan dasar halaman -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Modern Interface</title>

    <style>
        /* Reset browser default */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Tampilan utama body */
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

        /* Efek background mengambang */
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

        /* Animasi */
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

        /* Container form */
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

        /* Header form login */
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 600;
            color: #2d3748;
        }

        .login-subtitle {
            color: #4a5568;
            font-size: 0.9rem;
        }

        /* Input dan tombol */
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
        }

        .form-input:focus {
            outline: none;
            border-color: #0ecb63;
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
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
    </style>
</head>

<body>

    <!-- buwat-bulat -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

<!-- kebabb nasgor ngeunah pisan -->


    <?php
    // Jika form dikirim (username terisi)
    if (isset($_POST['username'])) {

        // Ambil data dari form
        $username = $_POST['username'];
        $password = md5($_POST['password']); // Enkripsi password
    
        
        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' and password='$password'");

        // Jika query gagal
        if (!$query) {
            die('Query Error: ' . mysqli_error($koneksi));
        }

        // loginnn
        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_array($query);

            // Simpan data user ke session
            $_SESSION['user'] = $data;
            $_SESSION['level'] = $data['level'];
            $_SESSION['id_user'] = $data['id_user'];

            // Tampilkan alert dan redirect ke halaman admin
            echo '<script>alert("selamat datang, ' . $data['nama'] . '"); location.href="admin.php";</script>';
        } else {
            // Jika login gagal
            echo '<script>alert("Username atau Password salah");</script>';
        }
    }
    ?>


    <!-- Form Login -->
    <div class="container">
        <div class="login-header">
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Please sign in to your account</p>
        </div>

        <!-- Form login dikirim ke file ini sendiri -->
        <form method="post">
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" name="username" id="username" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-input" required>
            </div>

            <div class="button-group">
                <button type="submit" class="btn-login">Sign In</button>
            </div>


        </form>
    </div>


    <script>
        // Auto-hide alerts after 3 seconds
        setTimeout(function () {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.animation = 'slideIn 0.5s ease-out reverse';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);

        
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function () {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>

</html>