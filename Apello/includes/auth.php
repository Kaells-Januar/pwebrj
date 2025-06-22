<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_user']) || !isset($_SESSION['level'])) {
    header("Location: /Apello/Apello/login.php");
    exit("Akses ditolak! Silakan login.");
}

$level = $_SESSION['level'];
?>
