<?php
include $_SERVER['DOCUMENT_ROOT'] . '/Apello/Apello/includes/koneksi.php'; // Koneksi ke database

$id_pembayaran = intval($_GET['id']); // Ambil id pembayaran dari parameter GET

// Query data pembayaran, pesanan, user (kasir)
$q = mysqli_query($koneksi, "
    SELECT pb.*, p.no_meja, p.nama_pemesan, p.total_harga, p.tanggal AS tgl_pesan, u.nama AS kasir
    FROM pembayaran pb
    JOIN pesanan p ON pb.id_pesanan = p.id_pesanan
    JOIN user u ON p.id_user = u.id_user
    WHERE pb.id_pembayaran = $id_pembayaran
");
$data = mysqli_fetch_assoc($q);

// Query detail pesanan (menu, qty, harga, subtotal)
$q_detail = mysqli_query($koneksi, "
    SELECT d.*, m.nama_makanan
    FROM pesanan_detail d
    JOIN menu m ON d.id_menu = m.id_menu
    WHERE d.id_pesanan = {$data['id_pesanan']}
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
    body {
        font-family: 'Poppins', Arial, sans-serif;
        background: #fff;
        margin: 0;
        padding: 0;
    }
    .struk-box {
        width: 340px;
        margin: 30px auto;
        background: #fff;
        border: 1.5px dashed #888;
        border-radius: 10px;
        padding: 24px 18px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    }
    .struk-box h3 {
        text-align: center;
        margin: 0 0 12px 0;
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 1px;
    }
    .struk-info {
        font-size: 14px;
        margin-bottom: 10px;
    }
    .struk-info b {
        display: inline-block;
        width: 110px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
        font-size: 14px;
    }
    th, td {
        padding: 6px 4px;
        text-align: left;
    }
    th {
        border-bottom: 1px solid #bbb;
        font-weight: 600;
    }
    tfoot td {
        font-weight: bold;
        border-top: 1px solid #bbb;
    }
    .center { text-align: center; }
    .right { text-align: right; }
    @media print {
        body { background: #fff; }
        .struk-box { box-shadow: none; border: none; }
    }
    </style>
</head>
<body>
<div class="struk-box">
    <h3>Apello Resto</h3>
    <!-- Info utama struk: meja, nama, tanggal, kasir -->
    <div class="struk-info">
        <b>No Meja</b>: <?= $data['no_meja'] ?><br>
        <b>Nama</b>: <?= htmlspecialchars($data['nama_pemesan']) ?><br>
        <b>Tanggal</b>: <?= date('d-m-Y H:i', strtotime($data['tanggal'])) ?><br>
        <b>Kasir</b>: <?= htmlspecialchars($data['kasir']) ?><br>
    </div>
    <!-- Tabel detail menu yang dipesan -->
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th class="center">Qty</th>
                <th class="right">Harga</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; while($d = mysqli_fetch_assoc($q_detail)): $total += $d['subtotal']; ?>
            <tr>
                <td><?= htmlspecialchars($d['nama_makanan']) ?></td>
                <td class="center"><?= $d['qty'] ?></td>
                <td class="right">Rp<?= number_format($d['harga']) ?></td>
                <td class="right">Rp<?= number_format($d['subtotal']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <!-- Total, Bayar, Kembalian -->
            <tr>
                <td colspan="3" class="right">Total</td>
                <td class="right">Rp<?= number_format($data['total_harga']) ?></td>
            </tr>
            <tr>
                <td colspan="3" class="right">Bayar</td>
                <td class="right">Rp<?= number_format($data['bayar']) ?></td>
            </tr>
            <tr>
                <td colspan="3" class="right">Kembalian</td>
                <td class="right">Rp<?= number_format($data['kembalian']) ?></td>
            </tr>
        </tfoot>
    </table>
    <!-- Ucapan terima kasih -->
    <div class="center" style="margin-top:18px;font-size:13px;">
        Terima kasih atas kunjungan Anda!<br>
        <b>Apello Resto</b>
    </div>
    <!-- Tombol cetak struk -->
    <div class="center" style="margin: 20px 0;">
        <button onclick="window.print()" class="btn btn-success" style="padding:8px 24px;font-size:15px;border-radius:6px;border:none;cursor:pointer;">Cetak</button>
    </div>
</div>
</body>
</html>