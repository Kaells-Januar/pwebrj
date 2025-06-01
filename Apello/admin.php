<?php
include 'includes/header.php';?>
<?php 
include 'includes/sidebar.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<<div class="main-content">
    <h1>Halaman administrator</h1>
    <a href="home.php">Home</a>
    <a href="logout.php">Log out</a>
    </div>
</div>

</body>
</html>

<style>

.main-content {
    margin-left: 220px;
    padding: 32px 24px 24px 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
        padding: 16px;
    }
}

</style>