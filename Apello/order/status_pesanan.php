<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';

$id_pesanan = intval($_POST['id_pesanan']);

// Update status ke "menunggu pembayaran"
mysqli_query($koneksi, "UPDATE pesanan SET status = 'menunggu' WHERE id_pesanan = $id_pesanan");

// Redirect ke halaman pembayaran
header("Location: order.php?id=$id_pesanan");
exit;
