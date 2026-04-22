<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <i class="bi bi-shield-lock-fill logo-icon"></i>
        <span class="sidebar-title fw-bold">LICENSE APP</span>
    </div>

    <div class="nav-links mt-4">
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

    <div class="mt-auto border-top pt-3">
        <a href="/license_aplikasi/public/logout.php" class="sidebar-link logout-link text-danger">
            <i class="bi bi-box-arrow-left"></i>
            <span class="link-text">Logout</span>
        </a>
    </div>
</nav>

<style>
    :root {
        --primary-pastel: #5d55cb;
        --primary-light: #8379f7;
        --sidebar-bg: #ffffff;
        --sidebar-width: 260px;
        --sidebar-collapsed-width: 85px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar {
        width: var(--sidebar-width);
        min-height: 100vh;
        background: var(--sidebar-bg);
        display: flex;
        flex-direction: column;
        padding: 20px 15px;
        transition: var(--transition);
        border-right: 1px solid #eee;
        position: fixed;
        z-index: 1000;
    }

    .sidebar.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    .sidebar.collapsed .link-text, 
    .sidebar.collapsed .sidebar-title {
        display: none;
    }

    .sidebar.collapsed .sidebar-header {
        justify-content: center;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        color: var(--primary-pastel);
    }

    .logo-icon { font-size: 1.8rem; }
    .sidebar-title { font-size: 1.2rem; letter-spacing: 1px; }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 14px 18px;
        color: #7f8c8d;
        text-decoration: none;
        border-radius: 14px;
        margin-bottom: 8px;
        transition: var(--transition);
        white-space: nowrap;
    }

    .sidebar-link i {
        font-size: 1.3rem;
        min-width: 35px;
    }

    .sidebar-link:hover {
        background: #f8f9ff;
        color: var(--primary-pastel);
        transform: translateX(5px);
    }

    .sidebar-link.active {
        background: var(--primary-pastel);
        color: white !important;
        box-shadow: 0 8px 15px rgba(93, 85, 203, 0.25);
    }

    .logout-link:hover {
        background: #fff5f5;
    }
</style>