<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_makanan = mysqli_real_escape_string($koneksi, $_POST['nama_makanan']);
    $harga = intval($_POST['harga']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $status_masakan = $_POST['status_masakan'] === 'habis' ? 'habis' : 'tersedia';

    // Handle gambar
    $gambarData = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambarTmp = $_FILES['gambar']['tmp_name'];
        $gambarData = file_get_contents($gambarTmp);
        $gambarData = mysqli_real_escape_string($koneksi, $gambarData);
    }

    $sql = "INSERT INTO menu (nama_makanan, harga, kategori, gambar, status_masakan)
            VALUES ('$nama_makanan', $harga, '$kategori', " . ($gambarData ? "'$gambarData'" : "NULL") . ", '$status_masakan')";

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
