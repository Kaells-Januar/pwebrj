<?php
// filepath: c:\xampp_new\htdocs\Apello\Apello\menu\get_menu.php
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu=$id");
    $data = mysqli_fetch_assoc($q);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>