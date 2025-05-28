
<?php

session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Halaman administrator</h1>
    <a href="home.php">Home</a>
    <a href="logout.php">Log out</a>
</body>
</html>