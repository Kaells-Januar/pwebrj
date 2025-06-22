<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($koneksi, "DELETE FROM user WHERE id_user=$id");
    if ($query) {
        header("Location: kelola_user.php");
        exit;
    } else {
        echo "Gagal menghapus user!";
    }
} else {
    header("Location: kelola_user.php");
    exit;
}
?>