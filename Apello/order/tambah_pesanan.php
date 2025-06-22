<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';

// Ambil id_user dari session (pastikan sudah di-set saat login)
$id_user = isset($_SESSION['id_user']) ? intval($_SESSION['id_user']) : 1; // fallback ke 1 jika belum login
$nama = $_POST['nama'];
$no_meja = intval($_POST['no_meja']);
$id_menu = intval($_POST['id_menu']);

// Cek apakah sudah ada pesanan aktif (status 'dipesan') di meja ini
$check = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE no_meja = $no_meja AND status = 'dipesan'");
if (mysqli_num_rows($check) > 0) {
    $pesanan = mysqli_fetch_assoc($check);
    $id_pesanan = $pesanan['id_pesanan'];
} else {
    // Buat pesanan baru, isi id_user dan status
    mysqli_query($koneksi, "INSERT INTO pesanan (id_user, no_meja, total_harga, status, nama_pemesan) VALUES ($id_user, $no_meja, 0, 'dipesan', '$nama')");
    $id_pesanan = mysqli_insert_id($koneksi);
}

// Ambil harga menu
$dataMenu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = $id_menu"));
$harga = $dataMenu['harga'];

// Tambahkan ke pesanan_detail
mysqli_query($koneksi, "INSERT INTO pesanan_detail (id_pesanan, id_menu, qty, harga, subtotal) 
VALUES ($id_pesanan, $id_menu, 1, $harga, $harga)");

// Update total_harga pesanan
mysqli_query($koneksi, "UPDATE pesanan SET total_harga = total_harga + $harga WHERE id_pesanan = $id_pesanan");

header("Location: order.php");
exit;
