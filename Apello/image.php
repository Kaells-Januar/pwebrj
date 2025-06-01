<?php
include 'includes/koneksi.php';
$id = intval($_GET['id_menu']);
$q = mysqli_query($koneksi, "SELECT gambar FROM menu WHERE id_menu='$id'");
$data = mysqli_fetch_assoc($q);
if ($data && $data['gambar']) {
    header("Content-Type: image/png"); 
    echo $data['gambar'];
} else {
    readfile('no-image.png');
}
exit;