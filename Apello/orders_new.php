<?php
include 'includes/koneksi.php';
include 'includes/header.php';
include 'includes/sidebar.php';

$toast = '';
// update status n toast notifikasi
if (isset($_POST['selesaikan'])) {
    $id_pesanan = intval($_POST['id_pesanan']);
    // Update jadi beres
    mysqli_query($koneksi, "UPDATE pesanan SET status='selesai' WHERE id_pesanan='$id_pesanan'");

    // Insert dei bisi eweuh
    $cek = mysqli_query($koneksi, "SELECT * FROM laporan_penjualan WHERE id_pesanan='$id_pesanan'");
    if (mysqli_num_rows($cek) == 0) {
        $pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan='$id_pesanan'"));
        mysqli_query($koneksi, "INSERT INTO laporan_penjualan (id_pesanan, tanggal, total_harga, no_meja) VALUES ('$id_pesanan', '{$pesanan['tanggal']}', '{$pesanan['total_harga']}', '{$pesanan['no_meja']}')");
    }
    $toast = 'Pesanan telah diselesaikan dan masuk ke laporan!';
}

// jeung nyokt data pesanan
$query = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE status != 'selesai' ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan - Admin</title>
    
</head>
<body>
    <div class="main-content">
        <h2>Daftar Pesanan</h2>
        <table>
            <tr>
                <th>ID Pesanan</th>
                <th>No Meja</th>
                <th>Tanggal</th>
                <th>Makanan yang Dipesan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?= $row['id_pesanan'] ?></td>
                    <td><?= $row['no_meja'] ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td>
                        <?php
                        $q_detail = mysqli_query($koneksi, "SELECT d.qty, m.nama_makanan FROM pesanan_detail d JOIN menu m ON d.id_menu=m.id_menu WHERE d.id_pesanan='{$row['id_pesanan']}'");
                        $list = [];
                        while ($d = mysqli_fetch_assoc($q_detail)) {
                            $list[] = $d['nama_makanan'] . " (x" . $d['qty'] . ")";
                        }
                        echo implode(', ', $list);
                        ?>
                    </td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <?php if ($row['status'] != 'selesai'): ?>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id_pesanan" value="<?= $row['id_pesanan'] ?>">
                            <button type="submit" name="selesaikan" onclick="return confirm('Tandai pesanan ini sebagai selesai?')">Selesai</button>
                        </form>
                        <?php else: ?>
                            <span style="color:green;font-weight:bold;">Selesai</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <div id="toast" class="toast"><?= $toast ?></div>
    </div>
    <?php if ($toast): ?>
    <script>
        window.onload = function() {
            var x = document.getElementById("toast");
            x.className = "toast show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
    </script>
    <?php endif; ?>
</body>

</html>


<style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 24px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .main-content {
            margin-left: 220px;
            padding: 32px 24px 24px 24px;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 16px;
            }
        }

        button {
            padding: 4px 8px;
        }

        .toast {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #4caf50;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 16px;
            position: fixed;
            z-index: 9999;
            left: 50%;
            bottom: 30px;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }
    </style>