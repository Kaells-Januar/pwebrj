<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';
$id_pesanan = intval($_GET['id_pesanan']);
$q = mysqli_query($koneksi, "
    SELECT p.*, u.nama AS nama_user
    FROM pesanan p
    JOIN user u ON p.id_user = u.id_user
    WHERE p.id_pesanan = $id_pesanan
");
$pesanan = mysqli_fetch_assoc($q);

$q_detail = mysqli_query($koneksi, "
    SELECT d.*, m.nama_makanan, m.harga
    FROM pesanan_detail d
    JOIN menu m ON d.id_menu = m.id_menu
    WHERE d.id_pesanan = $id_pesanan
");
?>

<b>Nama Pemesan:</b> <?= htmlspecialchars($pesanan['nama_pemesan']) ?><br>
<b>Tanggal:</b> <?= $pesanan['tanggal'] ?><br>
<table style="width:100%;margin-top:10px;">
  <tr>
    <th>Menu</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Subtotal</th>
  </tr>
  <?php while($d = mysqli_fetch_assoc($q_detail)): ?>
    <tr>
      <td><?= htmlspecialchars($d['nama_makanan']) ?></td>
      <td><?= $d['qty'] ?></td>
      <td>Rp<?= number_format($d['harga']) ?></td>
      <td>Rp<?= number_format($d['subtotal']) ?></td>
    </tr>
  <?php endwhile; ?>
</table>