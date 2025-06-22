<?php
session_start(); // Mulai session
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/auth.php';      // Cek autentikasi user
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';   // Koneksi ke database
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/header.php';    // Tampilkan header/navbar
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/sidebar.php';   // Tampilkan sidebar

// Query join pembayaran, pesanan, user untuk ambil data riwayat pembayaran
$query = mysqli_query($koneksi, "
    SELECT pb.*, p.no_meja, p.nama_pemesan, p.total_harga, p.tanggal AS tgl_pesan, u.nama AS kasir
    FROM pembayaran pb
    JOIN pesanan p ON pb.id_pesanan = p.id_pesanan
    JOIN user u ON p.id_user = u.id_user
    ORDER BY pb.tanggal DESC
");
?>

<!-- ================== STYLE TABEL & LAYOUT ================== -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

body {
  font-family: 'Poppins', sans-serif;
  background:rgb(251, 253, 255);
  margin: 0;
  padding: 0;
}
.main-content {
  margin-left: 250px;
  padding: 80px 30px 30px;
  min-height: 100vh;
}
h2 {
  font-size: 24px;
  margin-bottom: 20px;
  font-weight: 600;
}
button, .btn, .btn-success {
  padding: 6px 14px;
  background-color: #007BFF;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  transition: background-color 0.3s;
  font-size: 14px;
}
button:hover, .btn:hover, .btn-success:hover {
  background-color: #0056b3;
}
.btn-success {
  background-color: #43a047;
}
.btn-success:hover {
  background-color: #2e7d32;
}
a {
  color: #dc3545;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s ease;
}
a:hover {
  color: #a71d2a;
  text-decoration: underline;
}

table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  margin-top: 20px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 3px 6px rgba(0,0,0,0.1);
  overflow: hidden;
  font-size: 15px;
}

table thead tr {
  background-color: #f5f5f5;
  font-weight: 700;
  color: #333;
}

table th, table td {
  padding: 14px 18px;
  border-bottom: 1px solid #e0e0e0;
  text-align: left;
}

table th:first-child {
  border-top-left-radius: 10px;
}

table th:last-child {
  border-top-right-radius: 10px;
}

table tbody tr:last-child td:first-child {
  border-bottom-left-radius: 10px;
}

table tbody tr:last-child td:last-child {
  border-bottom-right-radius: 10px;
}

table tbody tr {
  background: #f9f9f9;
  transition: background 0.3s;
}
table tbody tr:hover {
  background: #e6f0ff;
}
</style>

<!-- ================== KONTEN UTAMA ================== -->
<div class="main-content">
    <h2>Riwayat Pembayaran</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Bayar</th>
                <th>No Meja</th>
                <th>Nama Pemesan</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembalian</th>
                <th>Kasir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?= $no++ ?></td> <!-- Nomor urut -->
                <td><?= $row['tanggal'] ?></td> <!-- Tanggal pembayaran -->
                <td>Meja <?= $row['no_meja'] ?></td> <!-- Nomor meja -->
                <td><?= htmlspecialchars($row['nama_pemesan']) ?></td> <!-- Nama pemesan -->
                <td>Rp<?= number_format($row['total_harga']) ?></td> <!-- Total harga -->
                <td>Rp<?= number_format($row['bayar']) ?></td> <!-- Uang yang dibayarkan -->
                <td>Rp<?= number_format($row['kembalian']) ?></td> <!-- Kembalian -->
                <td><?= htmlspecialchars($row['kasir']) ?></td> <!-- Nama kasir -->
                <td>
                    <!-- Tombol cetak struk pembayaran -->
                    <a href="cetak_struk.php?id=<?= $row['id_pembayaran'] ?>" target="_blank" class="btn btn-success">Cetak Struk</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>