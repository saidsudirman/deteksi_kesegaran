<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pengguna') | FreshAI</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f5f7f5;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #173f32;
            position: fixed;
            top: 0;
            left: 0;
            color: white;
        }

        .sidebar a {
            display: block;
            color: #d5e4dc;
            text-decoration: none;
            padding: 13px 20px;
            margin: 5px 12px;
            border-radius: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #2e6b50;
            color: white;
        }

        .main-content {
            margin-left: 260px;
            padding: 25px;
        }

        .stat-card,
        .content-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .04);
        }

        .welcome-card {
            background: linear-gradient(120deg, #173f32, #347653);
            color: white;
            border-radius: 16px;
            padding: 30px;
        }

        .btn-fresh {
            background: #2e6b50;
            color: white;
            border: none;
        }

        .btn-fresh:hover {
            background: #24563f;
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .sidebar .position-absolute {
                position: static !important;
            }

            .main-content {
                margin-left: 0;
                padding: 18px;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="p-4">
            <h5 class="fw-bold mb-1">
                <i class="fas fa-leaf me-2"></i>FreshAI
            </h5>
            <small class="text-white-50">User Panel</small>
        </div>

        <hr class="mx-3">

        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line me-2"></i> Dashboard
        </a>

        <a href="{{ route('user.detection') }}" class="{{ request()->routeIs('user.detection') ? 'active' : '' }}">
            <i class="fas fa-camera me-2"></i> Deteksi Kesegaran
        </a>

        <a href="{{ route('user.history.index') }}" class="{{ request()->routeIs('user.history.*') ? 'active' : '' }}">
            <i class="fas fa-history me-2"></i> Riwayat Deteksi
        </a>

        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fas fa-user me-2"></i> Profil
        </a>

        <div class="position-absolute bottom-0 w-100 p-3">
            <div class="small mb-2">{{ auth()->user()->name }}</div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-sm w-100">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>