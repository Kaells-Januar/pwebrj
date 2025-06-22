<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php'; // Koneksi ke database

$id_pesanan = intval($_GET['id_pesanan']); // Ambil id pesanan dari parameter GET

// Query data pesanan utama dan user pemesan
$q = mysqli_query($koneksi, "
    SELECT p.*, u.nama AS nama_user
    FROM pesanan p
    JOIN user u ON p.id_user = u.id_user
    WHERE p.id_pesanan = $id_pesanan
");
$pesanan = mysqli_fetch_assoc($q);

// Query detail pesanan (menu, qty, harga, subtotal)
$q_detail = mysqli_query($koneksi, "
    SELECT d.*, m.nama_makanan, m.harga
    FROM pesanan_detail d
    JOIN menu m ON d.id_menu = m.id_menu
    WHERE d.id_pesanan = $id_pesanan
");
$total = 0; // Inisialisasi total harga
?>

<!-- Tampilkan info pemesan dan tanggal -->
<b>Nama Pemesan:</b> <?= htmlspecialchars(-$pesanan['nama_pemesan']) ?><br>
<b>Tanggal:</b> <?= $pesanan['tanggal'] ?><br>

<!-- Tabel detail pesanan -->
<table style="width:100%;margin-top:10px;">
  <tr>
    <th>Menu</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Subtotal</th>
  </tr>
  <?php while($d = mysqli_fetch_assoc($q_detail)): 
    $total += $d['subtotal']; // Hitung total
  ?>
    <tr>
      <td><?= htmlspecialchars($d['nama_makanan']) ?></td>
      <td><?= $d['qty'] ?></td>
      <td>Rp<?= number_format($d['harga']) ?></td>
      <td>Rp<?= number_format($d['subtotal']) ?></td>
    </tr>
  <?php endwhile; ?>
  <tr>
    <td colspan="3" style="text-align:right;font-weight:bold;">Total</td>
    <td style="font-weight:bold;">Rp<?= number_format($total) ?></td>
  </tr>
</table>

<!-- Form pembayaran -->
<form id="formBayar" method="POST" action="proses_bayar.php" style="margin-top:18px;">
  <input type="hidden" name="id_pesanan" value="<?= $id_pesanan ?>">
  <div style="margin-bottom:10px;">
    <label for="bayar">Uang Pembayaran:</label>
    <input type="number" name="bayar" id="bayar" min="<?= $total ?>" required style="padding:6px 10px;border-radius:6px;border:1.5px solid #ccc;">
  </div>
  <div style="margin-bottom:10px;">
    <label for="kembalian">Kembalian:</label>
    <input type="text" id="kembalian" readonly style="padding:6px 10px;border-radius:6px;border:1.5px solid #ccc;background:#f5f5f5;">
  </div>
  <button type="submit" class="btn btn-success">Selesaikan Pembayaran</button>
</form>

<!-- Script untuk menghitung kembalian otomatis saat input pembayaran -->
<script>
document.getElementById('bayar').addEventListener('input', function() {
  var total = <?= $total ?>;
  var bayar = parseInt(this.value) || 0;
  var kembalian = bayar - total;
  document.getElementById('kembalian').value = kembalian > 0 ? 'Rp' + kembalian.toLocaleString() : 'Rp0';
});
</script>

<style>
.modal {
  display: none;
  position: fixed;
  z-index: 99;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.4);
}
.modal-content {
  background: #fff;
  margin: 5% auto;
  padding: 24px;
  width: 90%;
  max-width: 500px;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0,0,0,0.1);
  position: relative;
}
.modal-header {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 16px;
  color: #333;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.close-btn {
  cursor: pointer;
  font-size: 22px;
  color: #999;
  transition: color 0.3s;
}
.close-btn:hover {
  color: #000;
}
</style>