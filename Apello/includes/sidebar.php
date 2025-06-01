<div class="sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-title">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard Admin
        </div>
    </div>
    <!-- Sidebar Navigation -->
    <nav class="sidebar-nav">
        <div class="nav-item">
            <a href="admin.php" class="nav-link<?=basename($_SERVER['PHP_SELF'])=='admin.php'?' active':''?>">
                <span class="nav-icon"><i class="fas fa-home"></i></span>
                <span>Dashboard</span>
            </a>
        </div>
        <div class="nav-item">
            <a href="orders_new.php" class="nav-link<?=basename($_SERVER['PHP_SELF'])=='orders_new.php'?' active':''?>">
                <span class="nav-icon"><i class="fas fa-shopping-cart"></i></span>
                <span>Pesanan</span>
            </a>
        </div>
    </nav>
</div>


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