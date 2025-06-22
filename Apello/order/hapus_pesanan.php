<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';

$id_detail = intval($_POST['id_detail']);

// Kurangi subtotal dari total harga
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_pesanan, subtotal FROM pesanan_detail WHERE id_detail = $id_detail"));
mysqli_query($koneksi, "UPDATE pesanan SET total_harga = total_harga - {$data['subtotal']} WHERE id_pesanan = {$data['id_pesanan']}");

// Hapus detail
mysqli_query($koneksi, "DELETE FROM pesanan_detail WHERE id_detail = $id_detail");

header("Location: order.php");
exit;
