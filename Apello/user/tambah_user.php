<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $level = mysqli_real_escape_string($koneksi, $_POST['level']);

    // Cek username sudah ada atau belum
    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "Username sudah terdaftar!";
        exit;
    }

    // Simpan user baru
    $password_hash = md5($password); // Ganti dengan password_hash jika ingin lebih aman
    $query = mysqli_query($koneksi, "INSERT INTO user (username, nama, password, level) VALUES ('$username', '$nama', '$password_hash', '$level')");

    // if ($query) {
    //     echo "User berhasil ditambahkan!";
    // } else {
    //     echo "Gagal menambah user!";
    // }
    // exit;
}
?>