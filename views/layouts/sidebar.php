<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <div class="logo-wrapper">
            <i class="bi bi-shield-lock-fill logo-icon"></i>
        </div>
        <span class="sidebar-title fw-bold">LICENSE APP</span>
    </div>

    <div class="nav-links mt-4">
        <p class="nav-heading">MAIN MENU</p>
        
        <a href="/license_aplikasi/public/index.php" 
           class="sidebar-link <?= ($activePage == 'products') ? 'active' : '' ?>">
            <i class="bi bi-grid-1x2-fill"></i>
            <span class="link-text">Aplikasi</span>
        </a>

        <a href="/license_aplikasi/public/index.php?action=history" 
           class="sidebar-link <?= ($activePage == 'history') ? 'active' : '' ?>">
            <i class="bi bi-clock-history"></i>
            <span class="link-text">Last Order</span>
        </a>
    </div>

    <div class="sidebar-footer mt-auto">
        <a href="/license_aplikasi/public/logout.php" class="sidebar-link logout-link text-danger">
            <i class="bi bi-box-arrow-left"></i>
            <span class="link-text">Logout</span>
        </a>
    </div>
</nav>

<style>
    :root {
        --sidebar-w: 280px;
        --sidebar-collapsed-w: 85px;
    }

    .sidebar {
        width: var(--sidebar-w);
        height: 100vh;
        background: #fff;
        display: flex;
        flex-direction: column;
        padding: 25px 15px;
        transition: all 0.3s ease;
        border-right: 1px solid rgba(0,0,0,0.05);
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        overflow-x: hidden;
    }

    .sidebar.collapsed {
        width: var(--sidebar-collapsed-w);
    }

    .sidebar.collapsed .link-text, 
    .sidebar.collapsed .sidebar-title,
    .sidebar.collapsed .nav-heading {
        opacity: 0;
        visibility: hidden;
        display: none;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 0 10px;
        height: 50px;
    }

    .logo-wrapper {
        min-width: 45px;
        height: 45px;
        background: rgba(93, 85, 203, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        color: #5d55cb;
    }

    .sidebar-title {
        color: #5d55cb;
        font-size: 1.1rem;
        white-space: nowrap;
    }

    .nav-heading {
        font-size: 0.7rem;
        font-weight: 700;
        color: #b2bec3;
        padding-left: 15px;
        margin-bottom: 15px;
        letter-spacing: 1px;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: #636e72;
        text-decoration: none;
        border-radius: 12px;
        margin-bottom: 8px;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .sidebar-link i {
        font-size: 1.4rem;
        min-width: 45px; 
        display: flex;
        align-items: center;
    }

    .sidebar-link:hover {
        background: #f8f9ff;
        color: #5d55cb;
    }

    .sidebar-link.active {
        background: #5d55cb;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(93, 85, 203, 0.2);
    }

    .sidebar-footer {
        padding-top: 20px;
        border-top: 1px solid #f1f2f6;
    }
</style>