<?php
include 'includes/koneksi.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Ambil data laporan
$query = mysqli_query($koneksi, "SELECT * FROM laporan_penjualan ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 24px;}
        th, td { border: 1px solid #ccc; padding: 8px 12px; text-align: left;}
        th { background: #f0f0f0; }
        .main-content { margin-left: 220px; padding: 32px 24px 24px 24px; }
        @media (max-width: 768px) {
            .main-content { margin-left: 0; padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Laporan Penjualan</h2>
        <table>
            <tr>
                <th>ID Pesanan</th>
                <th>No Meja</th>
                <th>Tanggal</th>
                <th>Makanan yang Dipesan</th>
                <th>Total Harga</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?= $row['id_pesanan'] ?></td>
                    <td><?= $row['no_meja'] ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td>
                        <?php
                        // Ambil detail makanan dari pesanan_detail
                        $q_detail = mysqli_query($koneksi, "SELECT d.qty, m.nama_makanan FROM pesanan_detail d JOIN menu m ON d.id_menu=m.id_menu WHERE d.id_pesanan='{$row['id_pesanan']}'");
                        $list = [];
                        while ($d = mysqli_fetch_assoc($q_detail)) {
                            $list[] = $d['nama_makanan'] . " (x" . $d['qty'] . ")";
                        }
                        echo implode(', ', $list);
                        ?>
                    </td>
                    <td>Rp<?= number_format($row['total_harga'],0,',','.') ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>