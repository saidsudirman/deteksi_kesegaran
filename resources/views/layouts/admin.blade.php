
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | FreshAI</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --fresh-dark: #173f32;
            --fresh-primary: #2e6b50;
            --fresh-hover: #24563f;
            --fresh-light: #e3f1e8;
            --fresh-bg: #f5f7f5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--fresh-bg);
            color: #26352d;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--fresh-dark);
            position: fixed;
            top: 0;
            left: 0;
            color: white;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            padding: 25px 24px 20px;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, .12);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 10px 0;
        }

        .sidebar-label {
            color: #91b2a1;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            padding: 15px 24px 8px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #d5e4dc;
            text-decoration: none;
            padding: 13px 16px;
            margin: 5px 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            transition: all .2s ease;
        }

        .sidebar a i {
            width: 20px;
            text-align: center;
            font-size: 15px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--fresh-primary);
            color: white;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, .12);
        }

        .admin-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #d9eddf;
            color: var(--fresh-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            flex-shrink: 0;
        }

        .sidebar-footer .user-name {
            font-size: 12px;
            font-weight: 700;
            color: white;
        }

        .sidebar-footer .user-role {
            font-size: 10px;
            color: #a9c7b6;
        }

        .btn-logout {
            border: 1px solid rgba(255, 255, 255, .3);
            color: white;
            background: transparent;
            border-radius: 9px;
            font-size: 12px;
            padding: 9px;
            width: 100%;
            margin-top: 14px;
            transition: .2s;
        }

        .btn-logout:hover {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            padding: 28px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--fresh-dark);
            margin: 0;
        }

        .topbar-subtitle {
            font-size: 12px;
            color: #89958d;
            margin-top: 5px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 8px 14px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .03);
        }

        .topbar-user i {
            color: var(--fresh-primary);
        }

        .content-card,
        .stat-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .04);
        }

        .btn-fresh {
            background: var(--fresh-primary);
            color: white;
            border: none;
        }

        .btn-fresh:hover {
            background: var(--fresh-hover);
            color: white;
        }

        .sidebar-overlay {
            display: none;
        }

        .mobile-menu-btn {
            display: none;
            border: none;
            background: var(--fresh-dark);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .45);
                z-index: 1040;
            }

            .main-content {
                margin-left: 0;
                padding: 18px;
            }

            .mobile-menu-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .topbar {
                gap: 12px;
            }

            .topbar-user {
                padding: 8px;
            }

            .topbar-user .user-info {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <div class="d-flex align-items-center gap-3">
                <div class="brand-icon">
                    <i class="fas fa-leaf"></i>
                </div>

                <div>
                    <h5 class="fw-bold mb-0">FreshAI</h5>
                    <small class="text-white-50">Admin Panel</small>
                </div>
            </div>
        </div>

        <hr class="mx-3 my-1 opacity-25">

        <div class="sidebar-menu">

            <div class="sidebar-label">MENU UTAMA</div>

            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Data Pengguna</span>
            </a>

            <a href="{{ route('admin.detection-histories.index') }}"
                class="{{ request()->routeIs('admin.detection-histories.*') ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                <span>Riwayat Deteksi</span>
            </a>

            <a href="{{ route('admin.reports.index') }}"
                class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i>
                <span>Laporan Deteksi</span>
            </a>

            <div class="sidebar-label">PENGATURAN</div>

            <a href="#">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>

            <a href="{{ route('profile.edit') }}"
                class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i>
                <span>Profil Saya</span>
            </a>

        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">

            <div class="d-flex align-items-center gap-2">
                <div class="admin-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="flex-grow-1 overflow-hidden">
                    <div class="user-name text-truncate">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="user-role">Administrator</div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Keluar dari Akun
                </button>
            </form>

        </div>

    </aside>

    <!-- Overlay Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <main class="main-content">

        <!-- Topbar -->
        <div class="topbar">

            <div class="d-flex align-items-center gap-3">
                <button class="mobile-menu-btn" type="button" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>

                <div>
                    <h5 class="topbar-title">@yield('title', 'Dashboard Admin')</h5>

                    <div class="topbar-subtitle">
                        Selamat datang kembali di FreshAI.
                    </div>
                </div>
            </div>

            <div class="topbar-user">
                <i class="fas fa-user-circle fs-5"></i>

                <div class="user-info">
                    <div class="fw-bold small">{{ auth()->user()->name }}</div>
                    <div class="text-muted" style="font-size: 10px;">Administrator</div>
                </div>
            </div>

        </div>

        <!-- Page Content -->
        @yield('content')

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }
    </script>

    @stack('scripts')

</body>

</html>
