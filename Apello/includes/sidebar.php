<?php
include 'auth.php'; // Cek autentikasi dan ambil level user
?>
<div class="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-title">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard <?= ucfirst($level) ?> <!-- Tampilkan level user di sidebar -->
        </div>
    </div>
    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav">
        <!-- Menu Dashboard: semua level -->
        <div class="nav-item">
            <a href="/Apello/Apello/admin.php" class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'admin.php' ? ' active' : '' ?>">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Menu Kelola User: hanya administrator -->
        <?php if (isset($level) && $level === 'administrator'): ?>
        <div class="nav-item">
            <a href="/Apello/Apello/user/kelola_user.php" class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'kelola_user.php' ? ' active' : '' ?>">
                <span class="nav-icon"><i class="fas fa-users-cog"></i></span>
                <span>Kelola User</span>
            </a>
        </div>
        <?php endif; ?>

        <!-- Menu Kelola Menu: hanya administrator -->
        <?php if (isset($level) && ($level === 'administrator')): ?>
        <div class="nav-item">
            <a href="/Apello/Apello/menu/kelola_menu.php" class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'kelola_menu.php' ? ' active' : '' ?>">
                <span class="nav-icon"><i class="fas fa-utensils"></i></span>
                <span>Kelola Menu</span>
            </a>
        </div>
        <?php endif; ?>

        <!-- Menu Order: hanya administrator -->
        <?php if (isset($level) && ($level === 'administrator')): ?>
        <div class="nav-item">
            <a href="/Apello/Apello/order/order.php" class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'order.php' ? ' active' : '' ?>">
                <span class="nav-icon"><i class="fas fa-receipt"></i></span>
                <span>Order</span>
            </a>
        </div>
        <?php endif; ?>

        <!-- Menu Order: khusus waiter & pelanggan -->
        <?php if (isset($level) && ( $level === 'waiter' || $level === 'pelanggan')): ?>
        <div class="nav-item">
            <a href="/Apello/Apello/order/entry.php" class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'entry.php' ? ' active' : '' ?>">
                <span class="nav-icon"><i class="fas fa-receipt"></i></span>
                <span>Order</span>
            </a>
        </div>
        <?php endif; ?>

        <!-- Menu Bayar: administrator & kasir -->
        <?php if (isset($level) && ($level === 'administrator' || $level === 'kasir')): ?>
        <div class="nav-item">
            <a href="/Apello/Apello/bayar/bayar.php" class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'bayar.php' ? ' active' : '' ?>">
                <span class="nav-icon"><i class="fas fa-cash-register"></i></span>
                <span>Bayar</span>
            </a>
        </div>
        <?php endif; ?>

        <!-- Menu Riwayat Transaksi: administrator, owner, kasir, waiter -->
        <?php if (isset($level) && ($level === 'administrator' || $level === 'owner' || $level === 'kasir' || $level === 'waiter')): ?>
        <div class="nav-item">
            <a href="/Apello/Apello/REPORT/riwayat.php" class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'riwayat.php' ? ' active' : '' ?>">
                <span class="nav-icon"><i class="fas fa-history"></i></span>
                <span>Riwayat Transaksi</span>
            </a>
        </div>
        <?php endif; ?>
    </nav>
</div>

<?php
// Blok debug session (sudah dihapus, tidak aktif)
// Fungsinya dulu untuk menampilkan isi session dan level user di tengah layar saat debug
?>

<style>
.sidebar {
    position: fixed;
    left: 0;
    top: 75px; /* ganti sesuai tinggi header */
    width: 220px;
    height: calc(100vh - 75px); /* supaya sidebar tidak keluar layar */
    background: #e8f5e8;
    border-right: 1px solid #b2dfdb;
    box-shadow: 2px 0 12px rgba(129,199,132,0.08);
    z-index: 999;
    padding-top: 0;
}
.sidebar-header {
    padding: 2rem 1.5rem 1rem;
    border-bottom: 1px solid #b2dfdb;
    margin-bottom: 1rem;
}
.sidebar-title {
    color: #2e7d32;
    font-size: 1.1rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
}
.sidebar-nav {
    padding: 0 1rem;
}
.nav-item {
    margin-bottom: 0.5rem;
}
.nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.75rem 1rem;
    color: #2d5016;
    text-decoration: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
}
.nav-link.active, .nav-link:hover {
    background: #81c784;
    color: #fff;
}
.nav-icon {
    width: 20px;
    text-align: center;
}
@media (max-width: 768px) {
    .sidebar { width: 100%; max-width: 220px; }
}
</style>