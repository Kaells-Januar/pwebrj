<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_menu'])) {
    $id_menu = intval($_POST['id_menu']);
    $sql = "DELETE FROM menu WHERE id_menu = $id_menu";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: kelola_menu.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    header("Location: kelola_menu.php");
    exit;
}
