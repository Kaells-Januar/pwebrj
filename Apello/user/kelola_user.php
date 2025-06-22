<!--Buatt include koneksi dan hanya bisa diakses oleh level adminnn  -->
<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/sidebar.php';

if ($_SESSION['level'] !== 'administrator') {
    echo "<script>alert('Akses ditolak'); window.location.href='index.php';</script>";
    exit;
}


// ini buat ngambill seluruh data user dari databbase
$query = mysqli_query($koneksi, "SELECT * FROM user");
?>

<!-- Konten Utama -->


<div class="main-content">
    <h2>Kelola User</h2>
    <button onclick="showModal('modalTambah')">+ Tambah User</button>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            while ($row = mysqli_fetch_assoc($query)) {
                $id = $row['id_user'];
                echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['level']}</td>
                    <td>
                        <button onclick=\"showModal('modalEdit$id')\">Edit</button>
                        <a href='hapus_user.php?id={$id}' onclick='return confirm(\"Yakin ingin hapus?\")'>Delete</a>
                    </td>
                </tr>";

                // Modal Edit dari atas ampe bawah termasuk select and dropdown, di atas ada hapus user
                echo "
                <div id='modalEdit$id' class='modal'> 
                  <div class='modal-content'>
                    <div class='modal-header'>
                      Edit User
                      <span class='close-btn' onclick=\"hideModal('modalEdit$id')\">&times;</span>
                    </div>
                    <form class='editUserForm' data-id='{$id}'>
                      <input type='hidden' name='id_user' value='{$id}'>
                      <div class='form-group'>
                        <label>Username</label>
                        <input name='username' value='{$row['username']}' required>
                      </div>
                      <div class='form-group'>
                        <label>Nama</label>
                        <input name='nama' value='{$row['nama']}' required>
                      </div>
                      <div class='form-group'>
                        <label>Level</label>
                        <select name='level' required>
                          <option value='administrator' " . ($row['level'] == 'administrator' ? 'selected' : '') . ">Administrator</option>
                          <option value='kasir' " . ($row['level'] == 'kasir' ? 'selected' : '') . ">Kasir</option>
                          <option value='owner' " . ($row['level'] == 'owner' ? 'selected' : '') . ">Owner</option>
                          <option value='waiter' " . ($row['level'] == 'waiter' ? 'selected' : '') . ">Waiter</option>
                          <option value='pelanggan' " . ($row['level'] == 'pelanggan' ? 'selected' : '') . ">Pelanggan</option>
                        </select>
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

<!-- Modal nambah, ciiiik -->
<div id="modalTambah" class="modal">
  <div class="modal-content">
    <div class="modal-header">
      Tambah User
      <span class="close-btn" onclick="hideModal('modalTambah')">&times;</span>
    </div>
    <form id="addUserForm">
      <div class="form-group">
        <label>Username</label>
        <input name="username" required>
      </div>
      <div class="form-group">
        <label>Nama</label>
        <input name="nama" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
      </div>
      <div class="form-group">
        <label>Level</label>
        <select name="level" required>
          <option value="administrator">Administrator</option>
          <option value="kasir">Kasir</option>
          <option value="owner">Owner</option>
          <option value="waiter">Waiter</option>
          <option value="pelanggan">Pelanggan</option>
        </select>
      </div>
      <button type="submit">Tambah</button>
      <button type="button" onclick="hideModal('modalTambah')">Batal</button>
    </form>
  </div>
</div>


<!-- tampil tampil doloe -->
<script>
function showModal(id) {
  document.getElementById(id).style.display = 'block';
}
function hideModal(id) {
  document.getElementById(id).style.display = 'none';
}
window.onclick = function (event) {
  if (event.target.classList && event.target.classList.contains('modal')) {
    event.target.style.display = 'none';
  }
}

// Tambah User AJAX supaya ndaaa refresh 
document.getElementById('addUserForm').onsubmit = function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  fetch('tambah_user.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(response => {
    // alert(response);
    hideModal('modalTambah');
    location.reload();
  });
};

// Edit User AJAX
document.querySelectorAll('.editUserForm').forEach(function(form) {
  form.onsubmit = function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('update_user.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(response => {
      // alert(response);
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
button {
  padding: 6px 14px;
  background-color: #007BFF;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
  transition: background-color 0.3s ease;
}
button:hover {
  background-color: #0056b3;
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