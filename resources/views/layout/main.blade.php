<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ROHMAN PERCETAKAN DAN FOTOKOPY')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary: #2563EB;
            --primary-dark: #1D4ED8;
            --primary-light: #3B82F6;
            --secondary: #64748B;
            --dark: #1E293B;
            --light: #F8FAFC;
            --white: #FFFFFF;
            --gray: #E2E8F0;
            --danger: #EF4444;
            --success: #10B981;
            --warning: #F59E0B;
            --info: #3B82F6;
            --merah: #2563EB;
            --kuning: #EAB308;
            --hijau: #22C55E;
            --biru: #3B82F6;
            --sidebar-width: 280px;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: #F1F5F9;
            color: var(--dark);
            overflow-x: hidden;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
            box-shadow: 0 2px 20px rgba(37, 99, 235, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            width: 100%;
            backdrop-filter: blur(10px);
        }
        
        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            height: 70px;
            gap: 12px;
        }
        
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .brand img {
            height: 42px;
            border-radius: 10px;
        }
        
        .brand-text {
            font-size: 20px;
            font-weight: 700;
            color: white;
        }
        
        .brand-sub {
            font-size: 11px;
            color: rgba(255,255,255,0.8);
            margin-top: -2px;
        }
        
        /* Menu Horizontal */
        .menu {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 10px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        
        .menu-item:hover {
            background: rgba(255,255,255,0.25);
            color: white;
        }
        
        .menu-item.active {
            background: rgba(255,255,255,0.2);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
        }
        
        .menu-item i {
            font-size: 16px;
        }
        
        /* Right Section */
        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .user-dropdown:hover {
            background: rgba(255,255,255,0.25);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563EB;
            font-weight: 600;
        }
        
        .user-info {
            text-align: left;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: white;
        }
        
        .user-role {
            font-size: 12px;
            color: rgba(255,255,255,0.8);
        }
        
        .btn-logout {
            padding: 10px 16px;
            border-radius: 10px;
            border: none;
            background: rgba(255,255,255,0.25);
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-logout:hover {
            background: white !important;
            color: #2563EB;
        }
        
        /* Main Content */
        .main-content {
            margin-top: 70px;
            padding: 24px;
            min-height: calc(100vh - 70px);
            background-image: url("{{ asset('img/bg halaman.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .page-header {
            background: var(--white);
            padding: 20px 24px;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            background: var(--white);
        }
        
        .card-body {
            padding: 24px;
        }
        
        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .stat-info h3 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
        }
        
        .stat-info p {
            font-size: 14px;
            color: var(--secondary);
            margin: 0;
        }
        
        .bg-primary-soft { background: rgba(220, 38, 38, 0.1); color: var(--primary); }
        .bg-success-soft { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .bg-warning-soft { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
        .bg-danger-soft { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
        
        .table thead th {
            background: #F8FAFC;
            border: none;
            font-weight: 600;
            color: var(--secondary);
            font-size: 12px;
            text-transform: uppercase;
            padding: 14px 16px;
        }
        
        .table tbody tr:hover {
            background: #F8FAFC;
        }
        
        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--gray);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        
        .btn-secondary {
            background: var(--gray);
            border: none;
            color: var(--secondary);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 500;
        }
        
        .text-primary { color: var(--primary) !important; }
        
        .stok-rendah {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .badge.bg-danger { background: var(--danger) !important; }
        .badge.bg-success { background: var(--success) !important; }
        .badge.bg-warning { background: var(--warning) !important; color: var(--white) !important; }
        .badge.bg-info { background: var(--info) !important; color: var(--white) !important; }
        .badge.bg-merah { background: var(--merah) !important; color: var(--white) !important; }
        .badge.bg-kuning { background: var(--kuning) !important; color: var(--dark) !important; }
        .badge.bg-hijau { background: var(--hijau) !important; color: var(--white) !important; }
        .badge.bg-biru { background: var(--biru) !important; color: var(--white) !important; }
        
        @media (max-width: 768px) {
            .menu { display: none; }
            .brand-sub { display: none; }
            .hamburger-toggle { display: flex; }
            .header-inner { gap: 8px; padding: 0 12px; }
        }
        @media (min-width: 769px) {
            .hamburger-toggle { display: none !important; }
        }
        @media (max-width: 1199.98px) {
            .menu-item span { display: none; }
            .menu { gap: 4px; }
            .menu-item { padding: 10px 12px; gap: 0; }
        }
        @media (min-width: 992px) {
            .menu-item span { display: inline; }
        }
        
        .btn {
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 13px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4);
        }
        
        .btn-secondary {
            background: var(--gray);
            border: none;
            color: var(--secondary);
        }
        
        .btn-secondary:hover {
            background: #CBD5E1;
            color: var(--dark);
        }
        
        .btn-success {
            background: var(--success);
            border: none;
        }
        
        .btn-danger {
            background: var(--danger);
            border: none;
        }
        
        .btn-warning {
            background: var(--warning);
            border: none;
            color: var(--white);
        }
        
        .btn-info {
            background: #3B82F6;
            border: none;
            color: var(--white);
        }
        
        .form-control, .form-select {
            border: 2px solid var(--gray);
            border-radius: 10px;
            padding: 10px 14px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }
        
        .badge {
            padding: 6px 10px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 12px;
        }
        
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            background: var(--white);
        }
        
        .modal-header {
            border-bottom: 1px solid var(--gray);
            padding: 20px 24px;
        }
        
        .modal-body {
            padding: 24px;
        }
        
        .modal-footer {
            border-top: 1px solid var(--gray);
            padding: 16px 24px;
        }
        
        .table {
            margin: 0;
        }
        
        .table thead th {
            background: #F8FAFC;
            border: none;
            font-weight: 600;
            color: var(--secondary);
            font-size: 12px;
            text-transform: uppercase;
            padding: 14px 16px;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: #F8FAFC;
        }
        
        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--gray);
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            background: var(--white);
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--gray);
            padding: 16px 20px;
        }

        .bg-merah { background-color: var(--merah) !important; color: white; }
        .bg-kuning { background-color: var(--kuning) !important; color: var(--dark); }
        .bg-hijau { background-color: var(--hijau) !important; color: white; }
        .bg-biru { background-color: var(--biru) !important; color: white; }
        .bg-kuning-kuning { background-color: #FEF08A !important; color: var(--dark); }
        .bg-hijau-muda { background-color: #BBF7D0 !important; color: var(--dark); }
        .bg-biru-muda { background-color: #BFDBFE !important; color: var(--dark); }
        .bg-merah-muda { background-color: #FECACA !important; color: var(--danger); }
        .text-merah { color: var(--merah) !important; }
        .text-kuning { color: var(--kuning) !important; }
        .text-hijau { color: var(--hijau) !important; }
        .text-biru { color: var(--biru) !important; }

        /* ─── Hamburger Toggle Button ─── */
        .hamburger-toggle {
            display: none;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.15);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: background 0.2s ease;
            flex-shrink: 0;
        }
        .hamburger-toggle:hover { background: rgba(255,255,255,0.3); }
        .hamburger-toggle.active { background: rgba(255,255,255,0.35); }

        /* ─── Overlay ─── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 998;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .sidebar-overlay.visible {
            display: block;
            opacity: 1;
        }

        /* ─── Mobile Menu Drawer ─── */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 70px;
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            max-width: 85vw;
            background: var(--white);
            z-index: 999;
            box-shadow: 4px 0 24px rgba(0,0,0,0.15);
            flex-direction: column;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
        }
        .mobile-menu.open {
            display: flex;
            transform: translateX(0);
        }

        .mobile-menu-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--gray);
        }
        .mobile-menu-header .brand-text { font-size: 18px; }

        .menu-close-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light);
            border: none;
            border-radius: 12px;
            color: var(--secondary);
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .menu-close-btn:hover {
            background: var(--gray);
            color: var(--dark);
        }

        .mobile-menu-nav {
            flex: 1;
            padding: 12px 0;
            overflow-y: auto;
        }

        .mobile-menu-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 20px;
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.2s ease;
        }
        .mobile-menu-item:hover {
            background: var(--light);
            color: var(--primary);
        }
        .mobile-menu-item.active {
            background: rgba(37,99,235,0.08);
            color: var(--primary);
            border-right: 4px solid var(--primary);
            font-weight: 600;
        }
        .mobile-menu-item i {
            width: 22px;
            text-align: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .mobile-menu-footer {
            padding: 20px;
            border-top: 1px solid var(--gray);
            background: var(--light);
        }
        .mobile-menu-footer .user-info { display: block; }
        
        .btn-logout.w-100 {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px 16px;
            border-radius: 10px;
            border: none;
            background: var(--danger);
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .btn-logout.w-100:hover { background: #DC2626; }

        /* ── Table / card full width on small screens ── */
        .table-responsive {
            border-radius: 12px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    @yield('styles')
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <div class="d-flex align-items-center gap-3">
                <button class="hamburger-toggle" id="menuToggle" type="button" aria-label="Toggle Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="brand">
                    <img src="{{ asset('img/logo 1.png') }}" alt="ROHMAN" style="height: 42px; border-radius: 10px;">
                    <div>
                        <div class="brand-text">ROHMAN</div>
                        <div class="brand-sub">Percetakan & Fotokopi</div>
                    </div>
                </div>
            </div>
            
            <nav class="menu">
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('transaksi.index') }}" class="menu-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                    <i class="fas fa-cash-register"></i> Transaksi
                </a>
                <a href="{{ route('barang.index') }}" class="menu-item {{ request()->routeIs('barang.index') ? 'active' : '' }}">
                    <i class="fas fa-boxes-stacked"></i> Data Barang
                </a>
                <a href="{{ route('barang.stokrendah') }}" class="menu-item {{ request()->routeIs('barang.stokrendah') ? 'active' : '' }}">
                    <i class="fas fa-warehouse"></i> Stok
                </a>
                <a href="{{ route('kategori.index') }}" class="menu-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Kategori
                </a>
                <a href="{{ route('laporan.index') }}" class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i> Laporan
                </a>
                <a href="{{ route('akun.index') }}" class="menu-item {{ request()->routeIs('akun.*') ? 'active' : '' }}">
                    <i class="fas fa-user-gear"></i> Akun
                </a>
            </nav>
            
            <div class="header-right">
                <div class="user-dropdown">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="user-role">{{ Auth::user()->role ?? 'Admin' }}</div>
                    </div>
                </div>
                <form method="GET" action="{{ route('logout') }}" class="d-inline">
                    <button type="submit" class="btn-logout" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="main-content">
        <div class="page-header" style="background: rgba(255,255,255,0.85); backdrop-filter: blur(10px);">
            <div class="d-flex justify-content-between align-items-center">
                <div class="page-title">@yield('page-title', 'Dashboard')</div>
                <div class="text-muted">
                    <i class="fas fa-calendar-alt me-2"></i>{{ date('d F Y') }}
                </div>
            </div>
        </div>
        @yield('main-content')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ─── Mobile Menu Toggle ───
        const menuToggle   = document.getElementById('menuToggle');
        const mobileMenu   = document.getElementById('mobileMenu');
        const menuOverlay  = document.getElementById('sidebarOverlay');
        const menuCloseBtn = document.getElementById('menuCloseBtn');

        function openMobileMenu() {
            mobileMenu.classList.add('open');
            menuOverlay.classList.add('visible');
            menuToggle.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            mobileMenu.classList.remove('open');
            menuOverlay.classList.remove('visible');
            menuToggle.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', function () {
                mobileMenu.classList.contains('open')
                    ? closeMobileMenu()
                    : openMobileMenu();
            });
        }
        if (menuCloseBtn)  menuCloseBtn.addEventListener('click', closeMobileMenu);
        if (menuOverlay)   menuOverlay.addEventListener('click', closeMobileMenu);

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMobileMenu();
        });

        // Responsive: re-show desktop menu on resize
        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) closeMobileMenu();
        });

        // ─── Alert helper ───
        function showAlert(icon, title, text) {
            Swal.fire({ icon, title, text, timer: 2000, showConfirmButton: false });
        }
        @if(session('success'))
            showAlert('success', 'Berhasil', '{{ session("success") }}');
        @endif
        @if(session('error'))
            showAlert('error', 'Gagal', '{{ session("error") }}');
        @endif
    </script>
    <!-- Mobile Menu Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Mobile Menu Drawer -->
    <aside class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-header">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('img/logo 1.png') }}" alt="ROHMAN" style="height: 40px; border-radius: 10px;">
                <div>
                    <div class="brand-text">ROHMAN</div>
                    <div class="brand-sub">Percetakan & Fotokopi</div>
                </div>
            </div>
            <button class="menu-close-btn" id="menuCloseBtn" type="button" aria-label="Tutup Menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <nav class="mobile-menu-nav">
            <a href="{{ route('dashboard') }}" class="mobile-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-chart-pie"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('transaksi.index') }}" class="mobile-menu-item {{ request()->routeIs('transaksi.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-cash-register"></i><span>Transaksi</span>
            </a>
            <a href="{{ route('barang.index') }}" class="mobile-menu-item {{ request()->routeIs('barang.index') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-boxes-stacked"></i><span>Data Barang</span>
            </a>
            <a href="{{ route('barang.stokrendah') }}" class="mobile-menu-item {{ request()->routeIs('barang.stokrendah') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-warehouse"></i><span>Stok</span>
            </a>
            <a href="{{ route('kategori.index') }}" class="mobile-menu-item {{ request()->routeIs('kategori.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-tags"></i><span>Kategori</span>
            </a>
            <a href="{{ route('laporan.index') }}" class="mobile-menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-file-invoice"></i><span>Laporan</span>
            </a>
            <a href="{{ route('akun.index') }}" class="mobile-menu-item {{ request()->routeIs('akun.*') ? 'active' : '' }}" onclick="closeMobileMenu()">
                <i class="fas fa-user-gear"></i><span>Akun</span>
            </a>
        </nav>
        <div class="mobile-menu-footer">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="user-role">{{ Auth::user()->role ?? 'Admin' }}</div>
                </div>
            </div>
            <form method="GET" action="{{ route('logout') }}">
                <button type="submit" class="btn-logout w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </aside>

    @yield('scripts')
</body>
</html>