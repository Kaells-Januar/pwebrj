<?php
// filepath: c:\xampp_new\htdocs\Apello\Apello\menu\kelola_menu.php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_menu = intval($_POST['id_menu']);
    $nama_makanan = mysqli_real_escape_string($koneksi, $_POST['nama_makanan']);
    $harga = intval($_POST['harga']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $status_masakan = $_POST['status_masakan'] === 'habis' ? 'habis' : 'tersedia';

    $sql = "UPDATE menu SET 
        nama_makanan = '$nama_makanan',
        harga = $harga,
        kategori = '$kategori',
        status_masakan = '$status_masakan'";

    // Jika ada gambar baru di-upload, update juga
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambarTmp = $_FILES['gambar']['tmp_name'];
        $gambarData = file_get_contents($gambarTmp);
        $gambarData = mysqli_real_escape_string($koneksi, $gambarData);
        $sql .= ", gambar = '$gambarData'";
    }

    $sql .= " WHERE id_menu = $id_menu";

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
