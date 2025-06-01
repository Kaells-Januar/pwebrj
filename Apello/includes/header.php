<?php
// navbar.php - Pure Navbar Component
?>
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
    
    .search-box {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .search-input {
        background: rgba(129, 199, 132, 0.08);
        border: 2px solid rgba(129, 199, 132, 0.15);
        border-radius: 25px;
        padding: 14px 50px 14px 20px;
        color: #2e7d32;
        font-size: 0.95rem;
        width: 320px;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 2px 10px rgba(129, 199, 132, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }
    
    .search-input::placeholder {
        color: rgba(46, 125, 50, 0.6);
        font-weight: 400;
    }
    
    .search-input:focus {
        outline: none;
        background: rgba(129, 199, 132, 0.12);
        border-color: rgba(129, 199, 132, 0.3);
        width: 380px;
        box-shadow: 
            0 4px 20px rgba(129, 199, 132, 0.2),
            0 0 0 4px rgba(129, 199, 132, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
    }
    
    .search-btn {
        position: absolute;
        right: 16px;
        background: none;
        border: none;
        color: rgba(46, 125, 50, 0.7);
        cursor: pointer;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    
    .search-btn:hover {
        color: #2e7d32;
        transform: scale(1.1);
    }
    
    .notification-btn {
        position: relative;
        background: rgba(129, 199, 132, 0.08);
        border: 2px solid rgba(129, 199, 132, 0.15);
        border-radius: 16px;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2e7d32;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 2px 10px rgba(129, 199, 132, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }
    
    .notification-btn:hover {
        background: rgba(129, 199, 132, 0.15);
        border-color: rgba(129, 199, 132, 0.25);
        transform: translateY(-3px);
        box-shadow: 
            0 6px 25px rgba(129, 199, 132, 0.25),
            0 12px 50px rgba(76, 175, 80, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
    }
    
    .notification-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background: linear-gradient(135deg, #ff5722, #f44336);
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 0.75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid white;
        box-shadow: 0 2px 10px rgba(244, 67, 54, 0.4);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    .user-menu {
        position: relative;
        display: flex;
        align-items: center;
        gap: 14px;
        background: rgba(129, 199, 132, 0.08);
        border: 2px solid rgba(129, 199, 132, 0.15);
        padding: 10px 20px;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 2px 10px rgba(129, 199, 132, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }
    
    .user-menu:hover {
        background: rgba(129, 199, 132, 0.15);
        border-color: rgba(129, 199, 132, 0.25);
        transform: translateY(-3px);
        box-shadow: 
            0 6px 25px rgba(129, 199, 132, 0.25),
            0 12px 50px rgba(76, 175, 80, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4caf50, #2e7d32);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: 
            0 3px 15px rgba(76, 175, 80, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.4);
    }
    
    .user-info {
        display: flex;
        flex-direction: column;
        color: #2e7d32;
    }
    
    .user-name {
        font-size: 0.95rem;
        font-weight: 700;
        line-height: 1.3;
    }
    
    .user-role {
        font-size: 0.8rem;
        opacity: 0.7;
        line-height: 1.3;
        font-weight: 500;
    }
    
    .dropdown-arrow {
        color: rgba(46, 125, 50, 0.6);
        font-size: 0.9rem;
        margin-left: 8px;
        transition: transform 0.3s ease;
    }
    
    .user-menu:hover .dropdown-arrow {
        transform: rotate(180deg);
    }
    
    /* User Dropdown Menu */
    .user-dropdown {
        position: absolute;
        top: calc(100% + 15px);
        right: 0;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        min-width: 220px;
        box-shadow: 
            0 10px 40px rgba(129, 199, 132, 0.2),
            0 20px 80px rgba(76, 175, 80, 0.1),
            0 1px 0 rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(129, 199, 132, 0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1001;
    }
    
    .user-menu.active .user-dropdown {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        color: #2e7d32;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border-radius: 16px;
        margin: 8px;
    }
    
    .dropdown-item:hover {
        background: rgba(129, 199, 132, 0.1);
        transform: translateX(4px);
    }
    
    .dropdown-item.logout {
        color: #d32f2f;
        border-top: 1px solid rgba(129, 199, 132, 0.1);
        margin-top: 4px;
    }
    
    .dropdown-item.logout:hover {
        background: rgba(211, 47, 47, 0.1);
        color: #b71c1c;
    }
    
    .dropdown-icon {
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
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
        <!-- Search Box -->
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Cari menu, pesanan, atau pelanggan...">
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>
        
        <!-- Notifications -->
        <button class="notification-btn">
            <i class="fas fa-bell"></i>
            <span class="notification-badge">3</span>
        </button>
        
        <!-- User Menu -->
        <div class="user-menu" onclick="toggleUserDropdown()">
            <div class="user-avatar">
                A
            </div>
            <div class="user-info">
                <span class="user-name">Admin Apello</span>
                <span class="user-role">Administrator</span>
            </div>
            <i class="fas fa-chevron-down dropdown-arrow"></i>
            
            <!-- User Dropdown -->
            <div class="user-dropdown">
                <a href="profile.php" class="dropdown-item">
                    <div class="dropdown-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <span>Profile Saya</span>
                </a>
                <a href="settings.php" class="dropdown-item">
                    <div class="dropdown-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <span>Pengaturan</span>
                </a>
                <a href="help.php" class="dropdown-item">
                    <div class="dropdown-icon">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <span>Bantuan</span>
                </a>
                <a href="logout.php" class="dropdown-item logout" onclick="return confirm('Yakin ingin keluar?')">
                    <div class="dropdown-icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
    </div>
</nav>

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
    
    function toggleUserDropdown() {
        const userMenu = document.querySelector('.user-menu');
        userMenu.classList.toggle('active');
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function closeDropdown(e) {
            if (!userMenu.contains(e.target)) {
                userMenu.classList.remove('active');
                document.removeEventListener('click', closeDropdown);
            }
        });
    }
    
    // Auto-hide search suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-box')) {
            // Hide search suggestions
        }
    });
    
    // Smooth scroll behavior for better UX
    document.documentElement.style.scrollBehavior = 'smooth';
</script>