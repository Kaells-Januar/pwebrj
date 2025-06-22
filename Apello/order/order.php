<?php
session_start(); // Mulai session
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php'; // Koneksi ke database
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/header.php';  // Tampilkan header/navbar
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/sidebar.php'; // Tampilkan sidebar

// Query: Ambil semua pesanan dengan status 'dipesan' (JOIN ke menu, pesanan, user)
$query = mysqli_query($koneksi, "
    SELECT pd.*, m.nama_makanan, m.harga, p.no_meja, p.nama_pemesan, u.nama AS nama_user, p.status
    FROM pesanan_detail pd
    JOIN menu m ON pd.id_menu = m.id_menu
    JOIN pesanan p ON pd.id_pesanan = p.id_pesanan
    JOIN user u ON p.id_user = u.id_user
    WHERE p.status = 'dipesan'
    ORDER BY pd.id_detail DESC
");

// Query: Ambil daftar menu yang tersedia
$menuList = mysqli_query($koneksi, "SELECT * FROM menu WHERE status_masakan = 'tersedia'");
$nama_user = isset($_SESSION['user']['nama']) ? $_SESSION['user']['nama'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Order | Apello</title>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    h2, h4 {
      font-size: 24px;
      margin-bottom: 20px;
      font-weight: 600;
      color: #2e7d32;
    }
    button, .btn, .btn-danger, .btn-success {
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
    button:hover, .btn:hover {
      background-color: #0056b3;
    }
    .btn-danger { background-color: #dc3545; }
    .btn-danger:hover { background-color: #a71d2a; }
    .btn-success { background-color: #43a047; }
    .btn-success:hover { background-color: #2e7d32; }
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
    .form-group { margin-bottom: 16px; }
    input, select {
      width: 100%;
      padding: 10px 12px;
      border: 1.5px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      margin-bottom: 10px;
    }
    .row {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 18px;
    }
    .col-md-4, .col-md-3, .col-md-2 {
      flex: 1 1 0;
      min-width: 120px;
    }
    .col-md-2 { max-width: 120px; }
    .select2-container--default .select2-selection--multiple {
      border-radius: 6px;
      padding: 4px;
    }
    .form-inline {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 18px;
    }
    .form-row {
      display: flex;
      gap: 18px;
      align-items: flex-end;
      width: 100%;
    }
    .form-col {
      display: flex;
      flex-direction: column;
      min-width: 180px;
      flex: 1;
    }
    .form-col label {
      font-size: 14px;
      margin-bottom: 6px;
      color: #555;
    }
    .form-col-btn {
      min-width: 100px;
      flex: none;
      display: flex;
      align-items: flex-end;
    }
    .form-col-btn button {
      width: 100%;
      margin-bottom: 0;
    }
    @media (max-width: 700px) {
      .form-row { flex-direction: column; gap: 10px; }
      .form-col, .form-col-btn { min-width: 100%; }
    }
  </style>
</head>
<body>
<div class="main-content">
  <h2>Tambah Pesanan</h2>

  <!-- Form tambah pesanan -->
  <form action="tambah_pesanan.php" method="POST" class="form-pesanan">
    <input type="hidden" name="nama" value="<?= htmlspecialchars($nama_user) ?>">
    <div class="form-row">
      <div class="form-col">
        <label for="no_meja">No Meja</label>
        <select name="no_meja" id="no_meja" required>
          <option value="">Pilih Meja</option>
          <?php for ($i = 1; $i <= 10; $i++): ?>
            <option value="<?= $i ?>">Meja <?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="form-col">
        <label for="id_menu">Menu</label>
        <select name="id_menu" id="id_menu" required>
          <option value="">Pilih Menu</option>
          
          <?php

          // Ambil ulang menuList karena udah habis di atas
          $menuList2 = mysqli_query($koneksi, "SELECT * FROM menu WHERE status_masakan = 'tersedia'");
          while($menu = mysqli_fetch_assoc($menuList2)): ?>
            <option value="<?= $menu['id_menu'] ?>"><?= $menu['nama_makanan'] ?> (Rp<?= number_format($menu['harga']) ?>)</option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-col form-col-btn">
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>
    </div>
  </form>

  <h4>Pesanan Dipesan</h4>
  <!-- Tabel pesanan yang statusnya 'dipesan' -->
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>No Meja</th>
        <th>Nama Pemesan</th>
        <th>Menu</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Subtotal</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- Loop data pesanan dari $query -->
      <?php $no=1; while($row = mysqli_fetch_assoc($query)): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td>Meja <?= $row['no_meja'] ?></td>
          <td><?= $row['nama_user'] ?></td>
          <td><?= $row['nama_makanan'] ?></td>
          <td><?= $row['qty'] ?></td>
          <td>Rp<?= number_format($row['harga']) ?></td>
          <td>Rp<?= number_format($row['qty'] * $row['harga']) ?></td>
          <td><?= $row['status'] ?></td>
          <td>
            <button class="btn btn-success" onclick="showDetailModal(<?= $row['id_pesanan'] ?>)">Detail</button>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- klik detail -->
<div id="detailModal" style="display:none; position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.4);">
  <div style="background:white; margin:100px auto; padding:20px; border-radius:8px; max-width:600px;">
    <h3>Detail Pesanan</h3>
    <div id="modalContent">Loading...</div>
    <div style="text-align:right; margin-top:10px;">
      <form id="formProses" method="POST" action="status_pesanan.php">
        <input type="hidden" name="id_pesanan" id="modal_id_pesanan">
        <button type="submit" class="btn-success">Proses</button>
        <button type="button" onclick="document.getElementById('detailModal').style.display='none'">Tutup</button>
      </form>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
  $('.menu-select').select2({ placeholder: 'Pilih Menu' });
});

// Script: showDetailModal untuk menampilkan detail pesanan via AJAX
function showDetailModal(id) {
  $('#modalContent').html('Memuat...');
  $('#modal_id_pesanan').val(id);
  $('#detailModal').show();
  $.get('detail_pesanan.php', { id_pesanan: id }, function(data) {
    $('#modalContent').html(data);
  });
}
</script>
</body>
</html>
