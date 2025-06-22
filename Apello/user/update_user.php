<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';



// mengambil data user berdasarkan urut ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = $id");

    if ($data = mysqli_fetch_assoc($query)) {
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'User tidak ditemukan']);
    }
    exit;
}

// Handle POST untuk update data user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id_user']);
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $level = $_POST['level'];

    $query = mysqli_query($koneksi, "UPDATE user SET username='$username', nama='$nama', level='$level' WHERE id_user=$id");

    // if ($query) {
    //     echo "User berhasil diupdate.";
    // } else {
    //     echo "Gagal mengupdate user.";
    // }
}
