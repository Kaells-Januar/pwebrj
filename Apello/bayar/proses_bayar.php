<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';

$id_pesanan = intval($_POST['id_pesanan']);
$bayar = intval($_POST['bayar']);

// Ambil total harga
$q = mysqli_query($koneksi, "SELECT total_harga FROM pesanan WHERE id_pesanan = $id_pesanan");
$data = mysqli_fetch_assoc($q);
$total = $data['total_harga'];
$kembalian = $bayar - $total;

// Save table pembayaran ah
mysqli_query($koneksi, "INSERT INTO pembayaran (id_pesanan, bayar, kembalian) VALUES ($id_pesanan, $bayar, $kembalian)");

// Update status pesanan jadi lunas
mysqli_query($koneksi, "UPDATE pesanan SET status = 'lunas' WHERE id_pesanan = $id_pesanan");

header("Location: bayar.php?success=1");
exit;