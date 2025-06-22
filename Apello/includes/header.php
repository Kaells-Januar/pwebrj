<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<nav class="navbar">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="navbar-brand">
        <div class="brand-icon">
            <i class="fas fa-utensils"></i>
        </div>
        <span>Apello</span>
    </a>
    
    <!-- Mobile Menu Toggle -->
    <button class="menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Navbar Actions -->
    <div class="navbar-actions">
        <!-- Hanya tombol logout -->
        <a href="/Apello/Apello/logout.php" class="dropdown-item logout" style="display:flex;align-items:center;gap:10px;font-weight:600;color:#d32f2f;padding:12px 18px;border-radius:16px;text-decoration:none;" onclick="return confirm('Yakin ingin keluar?')">
            <span class="dropdown-icon">
                <i class="fas fa-sign-out-alt"></i>
            </span>
            <span>Keluar</span>
        </a>
    </div>
</nav>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Inter', 'Segoe UI', -apple-system, BlinkMacSystemFont, sans-serif;
        background: linear-gradient(135deg, #f0f9f0 0%, #e8f5e8 100%);
        color: #1a2e1a;
        font-weight: 400;
        padding-top: 85px
    }
    
    .navbar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        height: 75px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 2.5rem;
        box-shadow: 
            0 2px 20px rgba(129, 199, 132, 0.15),
            0 8px 40px rgba(76, 175, 80, 0.08),
            0 1px 0 rgba(255, 255, 255, 0.8);
        border-bottom: 1px solid rgba(129, 199, 132, 0.1);
    }
    
    .navbar-brand {
        display: flex;
        align-items: center;
        gap: 16px;
        color: #2e7d32;
        text-decoration: none;
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -1px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .navbar-brand:hover {
        transform: translateY(-2px);
        color: #1b5e20;
    }
    
    .brand-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #81c784 0%, #66bb6a 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: white;
        box-shadow: 
            0 4px 20px rgba(129, 199, 132, 0.4),
            0 8px 40px rgba(76, 175, 80, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .brand-icon:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 
            0 6px 25px rgba(129, 199, 132, 0.5),
            0 12px 50px rgba(76, 175, 80, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.4);
    }
    
    .menu-toggle {
        display: none;
        background: rgba(129, 199, 132, 0.1);
        border: none;
        color: #2e7d32;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 12px;
        border-radius: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 10px rgba(129, 199, 132, 0.2);
    }
    
    .menu-toggle:hover {
        background: rgba(129, 199, 132, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(129, 199, 132, 0.3);
    }
    
    .navbar-actions {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .dropdown-item.logout {
        color: #d32f2f;
        font-size: 1rem;
        font-weight: 600;
        background: rgba(211, 47, 47, 0.08);
        border: 2px solid rgba(211, 47, 47, 0.12);
        transition: background 0.2s, color 0.2s;
    }
    .dropdown-item.logout:hover {
        background: rgba(211, 47, 47, 0.18);
        color: #b71c1c;
    }
    
    @media (max-width: 768px) {
        .navbar {
            padding: 0 1.5rem;
            height: 70px;
        }
        
        .menu-toggle {
            display: block;
        }
        
        .search-box {
            display: none;
        }
        
        .user-info {
            display: none;
        }
        
        .user-menu {
            padding: 10px;
            border-radius: 16px;
        }
        
        .brand-icon {
            width: 42px;
            height: 42px;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .navbar {
            padding: 0 1rem;
        }
        
        .navbar-brand {
            font-size: 1.3rem;
        }
        
        .brand-icon {
            width: 38px;
            height: 38px;
            font-size: 1.2rem;
        }
        
        .notification-btn {
            width: 45px;
            height: 45px;
        }
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        if (sidebar) {
            sidebar.classList.toggle('mobile-open');
        }
        if (overlay) {
            overlay.classList.toggle('active');
        }
    }
</script>