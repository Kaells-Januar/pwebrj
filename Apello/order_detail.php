<?php
include 'includes/koneksi.php';
include 'includes/header.php';
include 'includes/sidebar.php';

if (!isset($_GET['id'])) {
    echo "ID pesanan tidak ditemukan.";
    exit;
}
$id_pesanan = intval($_GET['id']);

// Proses update status
if (isset($_POST['ubah_status'])) {
    $status_baru = $_POST['status'];
    mysqli_query($koneksi, "UPDATE pesanan SET status='$status_baru' WHERE id_pesanan='$id_pesanan'");

    // Jika status selesai, masukkan ke laporan_penjualan
    if ($status_baru == 'selesai') {
        $cek = mysqli_query($koneksi, "SELECT * FROM laporan_penjualan WHERE id_pesanan='$id_pesanan'");
        if (mysqli_num_rows($cek) == 0) {
            $pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan'"));
            mysqli_query($koneksi, "INSERT INTO laporan_penjualan (id_pesanan, tanggal, total_harga, no_meja) VALUES ('$id_pesanan', '{$pesanan['tanggal']}', '{$pesanan['total_harga']}', '{$pesanan['no_meja']}')");
        }
    }
    echo "<script>alert('Status pesanan diubah!');window.location='order_detail.php?id=$id_pesanan';</script>";
    exit;
}

// Ambil data pesanan
$pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan'"));
$q_detail = mysqli_query($koneksi, "SELECT d.*, m.nama_makanan FROM pesanan_detail d JOIN menu m ON d.id_menu=m.id_menu WHERE d.id_pesanan='$id_pesanan'");
?>
<div class="main-content">
    <h2>Detail Pesanan #<?= $pesanan['id_pesanan'] ?></h2>
    <p>No Meja: <?= $pesanan['no_meja'] ?></p>
    <p>Tanggal: <?= $pesanan['tanggal'] ?></p>
    <form method="post" style="margin-bottom:16px;">
        <label>Status: </label>
        <select name="status">
            <option value="pending" <?= $pesanan['status']=='pending'?'selected':''; ?>>Pending</option>
            <option value="proses" <?= $pesanan['status']=='proses'?'selected':''; ?>>Proses</option>
            <option value="selesai" <?= $pesanan['status']=='selesai'?'selected':''; ?>>Selesai</option>
        </select>
        <button type="submit" name="ubah_status">Ubah Status</button>
    </form>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Menu</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
        <?php while($d = mysqli_fetch_assoc($q_detail)): ?>
        <tr>
            <td><?= $d['nama_makanan'] ?></td>
            <td><?= $d['qty'] ?></td>
            <td>Rp<?= number_format($d['harga'],0,',','.') ?></td>
            <td>Rp<?= number_format($d['subtotal'],0,',','.') ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p><b>Total: Rp<?= number_format($pesanan['total_harga'],0,',','.') ?></b></p>
    <a href="orders_new.php">Kembali</a>
</div>


<style>

            .main-content {
    margin-left: 220px;
    padding: 32px 24px 24px 24px;
    display: flex;
    flex-direction: column;
}
@media (max-width: 768px) {
    .main-content {
        margin-left: 0;
        padding: 16px;
    }
}

</style>