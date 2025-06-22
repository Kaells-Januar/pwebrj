<?php
if (!isset($_SESSION)) session_start(); 
$level = isset($_SESSION['level']) ? $_SESSION['level'] : ''; // Ambil level user dari session

include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/header.php';  
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/sidebar.php'; 

$query = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY id_menu DESC"); // Query semua menu
?>

<!-- Konten Utama -->
<div class="main-content">
    <h2>Kelola Menu</h2>
    <button onclick="showModal('modalTambah')">+ Tambah Menu</button> <!-- modal tambah-->

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Makanan</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($row = mysqli_fetch_assoc($query)) {
                $id = $row['id_menu'];
                echo "<tr>
                    <td>{$no}</td>
                    <td>" . htmlspecialchars($row['nama_makanan']) . "</td>
                    <td>Rp" . number_format($row['harga'], 0, ',', '.') . "</td>
                    <td>" . htmlspecialchars($row['kategori']) . "</td>
                    <td>{$row['status_masakan']}</td>
                    <td>";
                // Tampilkan gambar menu jika ada, jika tidak tampilkan teks
                if ($row['gambar']) {
                    echo '<img src="data:image/*;base64,' . base64_encode($row['gambar']) . '" style="max-width:60px;max-height:40px;border-radius:6px;">';
                } else {
                    echo '<span style="color:#aaa;">(tidak ada)</span>';
                }
                echo "</td>
                    <td>
                        <!-- Tombol edit buka modal edit -->
                        <button onclick=\"showModal('modalEdit$id')\">Edit</button>
                        <!-- Tombol hapus menu (POST ke hapus_menu.php) -->
                        <form action='hapus_menu.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Yakin ingin hapus menu ini?\")'>
                            <input type='hidden' name='id_menu' value='{$id}'>
                            <button type='submit' class='btn-danger'>Delete</button>
                        </form>
                    </td>
                </tr>";

                // MEM
                echo "
                <div id='modalEdit$id' class='modal'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      Edit Menu
                      <span class='close-btn' onclick=\"hideModal('modalEdit$id')\">&times;</span>
                    </div>
                    <form class='editMenuForm' data-id='{$id}' enctype='multipart/form-data'>
                      <input type='hidden' name='id_menu' value='{$id}'>
                      <div class='form-group'>
                        <label>Nama Makanan</label>
                        <input name='nama_makanan' value=\"" . htmlspecialchars($row['nama_makanan']) . "\" required>
                      </div>
                      <div class='form-group'>
                        <label>Harga</label>
                        <input name='harga' type='number' min='0' value='{$row['harga']}' required>
                      </div>
                      <div class='form-group'>
                        <label>Kategori</label>
                        <input name='kategori' value=\"" . htmlspecialchars($row['kategori']) . "\" required>
                      </div>
                      <div class='form-group'>
                        <label>Status</label>
                        <select name='status_masakan' required>
                          <option value='tersedia' " . ($row['status_masakan'] == 'tersedia' ? 'selected' : '') . ">Tersedia</option>
                          <option value='habis' " . ($row['status_masakan'] == 'habis' ? 'selected' : '') . ">Habis</option>
                        </select>
                      </div>
                      <div class='form-group'>
                        <label>Ganti Gambar (kosongkan jika tidak diganti)</label>
                        <input type='file' name='gambar' accept='image/*'>
                      </div>
                      <button type='submit'>Simpan</button>
                      <button type='button' onclick=\"hideModal('modalEdit$id')\">Batal</button>
                    </form>
                  </div>
                </div>
                ";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Tambah Menu -->
<div id="modalTambah" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      Tambah Menu
      <span class="close-btn" onclick="hideModal('modalTambah')">&times;</span>
    </div>
    <form id="addMenuForm" enctype="multipart/form-data">
      <div class="form-group">
        <label>Nama Makanan</label>
        <input name="nama_makanan" required>
      </div>
      <div class="form-group">
        <label>Harga</label>
        <input name="harga" type="number" min="0" required>
      </div>
      <div class="form-group">
        <label>Kategori</label>
        <input name="kategori" required>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select name="status_masakan" required>
          <option value="tersedia">Tersedia</option>
          <option value="habis">Habis</option>
        </select>
      </div>
      <div class="form-group">
        <label>Gambar</label>
        <input type="file" name="gambar" accept="image/*">
      </div>
      <button type="submit">Tambah</button>
      <button type="button" onclick="hideModal('modalTambah')">Batal</button>
    </form>
  </div>
</div>

<script>
// tampilin modall
function showModal(id) {
  document.getElementById(id).style.display = 'block';
}
// Hide modalssssssssssssssssssssssssssssssssssssssssssssssssssssssssss
function hideModal(id) {
  document.getElementById(id).style.display = 'none';
}
// Tutup modal jika klik di luar konten modal
window.onclick = function (event) {
  if (event.target.classList && event.target.classList.contains('modal')) {
    event.target.style.display = 'none';
  }
}

// Submit 
document.getElementById('addMenuForm').onsubmit = function(e) {
  e.preventDefault();
  var formData = new FormData(this);
  fetch('tambah_menu.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(response => {
    hideModal('modalTambah');
    location.reload();
  });
};


document.querySelectorAll('.editMenuForm').forEach(function(form) {
  form.onsubmit = function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    fetch('update_menu.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(response => {
      hideModal('modalEdit' + this.dataset.id);
      location.reload();
    });
  }
});
</script>

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
button, .btn-danger {
  padding: 6px 14px;
  background-color: #007BFF;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  transition: background-color 0.3s ease;
}
button:hover, .btn-danger:hover {
  background-color: #0056b3;
}
.btn-danger {
  background-color: #dc3545;
}
.btn-danger:hover {
  background-color: #a71d2a;
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

.modal {
  display: none;
  position: fixed;
  z-index: 99;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.4);
}

.modal-content {
  background: #fff;
  margin: 5% auto;
  padding: 24px;
  width: 90%;
  max-width: 450px;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.modal-header {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 16px;
  color: #333;
}

.close-btn {
  float: right;
  cursor: pointer;
  font-size: 20px;
  color: #999;
  transition: color 0.3s ease;
}
.close-btn:hover {
  color: #000;
}

.form-group {
  margin-bottom: 16px;
}

label {
  display: block;
  font-size: 14px;
  margin-bottom: 6px;
  color: #555;
}

input, select {
  width: 100%;
  padding: 10px 12px;
  border: 1.5px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  transition: border-color 0.3s ease;
}
input:focus, select:focus {
  border-color: #007BFF;
  outline: none;
}
</style>
