<?php
// filepath: c:\xampp_new\htdocs\Apello\Apello\index.php
session_start();
include 'includes/koneksi.php';

// Ambil kategori unik
$kategori = [];
$q = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM menu");
while ($row = mysqli_fetch_assoc($q)) {
    $kategori[] = $row['kategori'];
}

// Proses pencarian dan filter kategori
$where = [];
if (!empty($_GET['cari'])) {
    $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
    $where[] = "nama_makanan LIKE '%$cari%'";
}
if (!empty($_GET['kategori'])) {
    $kat = mysqli_real_escape_string($koneksi, $_GET['kategori']);
    $where[] = "kategori='$kat'";
}
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Ambil data menu
$menu = [];
$q = mysqli_query($koneksi, "SELECT * FROM menu $where_sql");
while ($row = mysqli_fetch_assoc($q)) {
    $menu[] = $row;
}

// Inisialisasi keranjang di session
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Tambah ke keranjang
if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id_menu'];
    $qty = max(1, intval($_POST['qty']));
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
    header("Location: index.php");
    exit;
}

// Hapus dari keranjang
if (isset($_GET['hapus'])) {
    unset($_SESSION['cart'][$_GET['hapus']]);
    header("Location: index.php");
    exit;
}

// Konfirmasi pesanan (hanya contoh, belum insert ke DB)
if (isset($_POST['konfirmasi']) && !empty($_SESSION['cart'])) {
    $no_meja = intval($_POST['no_meja']);
    $total_harga = 0;

    // Hitung total harga
    foreach ($_SESSION['cart'] as $id => $qty) {
        $q = mysqli_query($koneksi, "SELECT harga FROM menu WHERE id_menu='$id'");
        $m = mysqli_fetch_assoc($q);
        if ($m) {
            $total_harga += $m['harga'] * $qty;
        }
    }

    // Insert ke tabel pesanan
    $insert_pesanan = mysqli_query($koneksi, "INSERT INTO pesanan (no_meja, total_harga, status) VALUES ('$no_meja', '$total_harga', 'pending')");
    if ($insert_pesanan) {
        $id_pesanan = mysqli_insert_id($koneksi);

        // Insert detail pesanan
        foreach ($_SESSION['cart'] as $id => $qty) {
            $q = mysqli_query($koneksi, "SELECT harga FROM menu WHERE id_menu='$id'");
            $m = mysqli_fetch_assoc($q);
            if ($m) {
                $harga = $m['harga'];
                $subtotal = $harga * $qty;
                mysqli_query($koneksi, "INSERT INTO pesanan_detail (id_pesanan, id_menu, qty, harga, subtotal) VALUES ('$id_pesanan', '$id', '$qty', '$harga', '$subtotal')");
            }
        }

        $_SESSION['cart'] = [];
        echo "<script>alert('Pesanan berhasil dikonfirmasi!');window.location='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menyimpan pesanan!');</script>";
    }
}

// Hitung total item dan harga untuk cart
$total_items = 0;
$total_harga = 0;
$cart_items = [];

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $qty) {
        $q = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu='$id'");
        $m = mysqli_fetch_assoc($q);
        if ($m) {
            $subtotal = $m['harga'] * $qty;
            $total_harga += $subtotal;
            $total_items += $qty;
            $cart_items[] = [
                'id' => $id,
                'nama' => $m['nama_makanan'],
                'qty' => $qty,
                'harga' => $m['harga'],
                'subtotal' => $subtotal
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apello Restaurant</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/index.css">
    <!-- Tambahkan link Google Fonts di <head> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="container">
        

<!-- Search & Filter Section -->
<div class="search-section">
    <form method="get" class="search-form">
        <div class="search-box">
            <input type="text" name="cari" placeholder="Cari makanan favorit Anda..." 
                   value="<?=isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''?>">
            
            <select name="kategori">
                <option value="">Semua Kategori</option>
                <?php foreach($kategori as $kat): ?>
                    <option value="<?=$kat?>" <?=isset($_GET['kategori']) && $_GET['kategori']==$kat ? 'selected' : ''?>>
                        <?=$kat?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit" class="search-submit-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
</div>


        <!-- Menu Grid -->
        <div class="menu-grid">
            <?php foreach($menu as $m): ?>
                <div class="menu-card">
                    <img src="image.php?id_menu=<?=$m['id_menu']?>" alt="<?=$m['nama_makanan']?>" class="menu-image"
                         onerror="this.onerror=null;this.src='https://via.placeholder.com/300x200/4caf50/ffffff?text=<?=urlencode($m['nama_makanan'])?>';">
                    <div class="menu-info">
                        <div class="menu-name"><?=$m['nama_makanan']?></div>
                        <div class="menu-price">Rp<?=number_format($m['harga'], 0, ',', '.')?></div>
                        <form method="post" class="add-to-cart-form">
                            <input type="hidden" name="id_menu" value="<?=$m['id_menu']?>">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" name="add_to_cart" class="add-btn">
                                Tambah
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Floating Cart -->
    <div class="floating-cart">
        <div class="cart-content">
            <div class="cart-summary">
                <div class="cart-info">
                    <div class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if ($total_items > 0): ?>
                            <div class="cart-badge"><?=$total_items?></div>
                        <?php endif; ?>
                    </div>
                    <div class="cart-details">
                        <div class="cart-items"><?=$total_items?> item<?=$total_items > 1 ? 's' : ''?></div>
                        <div class="cart-total">Rp<?=number_format($total_harga, 0, ',', '.')?></div>
                    </div>
                </div>
            </div>
            <div class="cart-actions">
                <button type="button" class="cart-btn view-cart-btn" onclick="toggleCartModal()">
                    <i class="fas fa-list"></i> Detail
                </button>
                <form method="post" style="display: inline-flex; align-items: center; gap: 0.75rem;">
                    <input type="number" name="no_meja" placeholder="Meja" class="table-input" required min="1">
                    <button type="submit" name="konfirmasi" class="cart-btn confirm-btn" 
                            <?=empty($_SESSION['cart'])?'disabled':''?>>
                        <i class="fas fa-check"></i> Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Cart Modal -->
    <div class="cart-modal" id="cartModal">
        <div class="cart-modal-content">
            <div class="cart-modal-header">
                <div class="cart-modal-title">
                    <i class="fas fa-shopping-cart"></i> Detail Pesanan
                </div>
                <button type="button" class="close-modal" onclick="toggleCartModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="cart-modal-body">
                <?php if (empty($cart_items)): ?>
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <div>Keranjang masih kosong</div>
                        <small>Silakan pilih makanan yang ingin dipesan</small>
                    </div>
                <?php else: ?>
                    <?php foreach($cart_items as $item): ?>
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <div class="cart-item-name"><?=$item['nama']?></div>
                                <div class="cart-item-details">
                                    <?=$item['qty']?> x Rp <?=number_format($item['harga'], 0, ',', '.')?>
                                </div>
                                <div class="cart-item-price">
                                    Rp <?=number_format($item['subtotal'], 0, ',', '.')?>
                                </div>
                            </div>
                            <a href="?hapus=<?=$item['id']?>" class="remove-btn" 
                               onclick="return confirm('Hapus item ini dari keranjang?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <div class="cart-item" style="border-bottom: none; padding-top: 1rem; border-top: 2px solid #4caf50;">
                        <div class="cart-item-info">
                            <div class="cart-item-name" style="font-size: 1.1rem;">Total Pesanan</div>
                        </div>
                        <div class="cart-item-price" style="font-size: 1.2rem;">
                            Rp <?=number_format($total_harga, 0, ',', '.')?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleCartModal() {
            const modal = document.getElementById('cartModal');
            modal.style.display = modal.style.display === 'block' ? 'none' : 'block';
        }

        // Close modal when clicking outside
        document.getElementById('cartModal').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleCartModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('cartModal').style.display = 'none';
            }
        });

        // Add smooth scrolling and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate menu cards on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.menu-card').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        });

        // Add to cart animation
        document.querySelectorAll('.add-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const originalText = this.innerHTML;
                this.innerHTML = 'Ditambahkan!';
                this.style.background = '#45a049';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.background = '';
                }, 1200);
            });
        });
    </script>
</body>
</html>