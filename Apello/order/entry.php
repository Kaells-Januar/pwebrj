<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/sidebar.php';

// Ambil daftar menu
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
    h2 {
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
          $menuList2 = mysqli_query($koneksi, "SELECT * FROM menu WHERE status_masakan = 'tersedia'");
          while($menu = mysqli_fetch_assoc($menuList2)): ?>
            <option value="<?= $menu['id_menu'] ?>"><?= $menu['nama_makanan'] ?> (Rp<?= number_format($menu['harga']) ?>)</option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-col">
        <label for="qty">Jumlah</label>
        <input type="number" name="qty" id="qty" min="1" value="1" required>
      </div>
      <div class="form-col form-col-btn">
        <button type="submit" class="btn btn-primary">Tambah</button>
      </div>
    </div>
  </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
  $('#id_menu').select2({ placeholder: 'Pilih Menu' });
});
</script>
</body>
</html>
