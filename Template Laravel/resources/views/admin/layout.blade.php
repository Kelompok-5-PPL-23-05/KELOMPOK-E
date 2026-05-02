<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — E-Rapor PKBM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #a8b8cc;
            min-height: 100vh;
            display: flex;
            color: #000;
        }

        /* ════════════ SIDEBAR ════════════ */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #eef2f6;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            border-right: 1px solid #d0d8e4;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 40px 24px 20px;
        }

        .hamburger-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 0;
        }

        .hamburger-btn span {
            display: block;
            width: 24px;
            height: 3px;
            background: #000;
            border-radius: 3px;
        }

        .sidebar-brand {
            font-size: 20px;
            font-weight: 700;
            color: #000;
        }

        .sidebar-search {
            padding: 0 20px 16px;
        }

        .search-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: transparent;
            border: 1px solid #6c8bbf;
            border-radius: 20px;
            padding: 8px 16px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            color: #000;
            width: 100%;
        }

        .search-box input::placeholder { color: #333; }

        .search-box svg {
            width: 16px;
            height: 16px;
            color: #6c8bbf;
            flex-shrink: 0;
        }

        /* Nav section collapsible */
        .nav-menu {
            flex: 1;
            padding: 0;
            border-top: 1px solid #9fb3ce;
        }

        .nav-section {
            border-bottom: 1px solid #9fb3ce;
        }

        .nav-section-title {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 400;
            color: #000;
            cursor: pointer;
            user-select: none;
        }

        .nav-section-title .arrow {
            width: 16px;
            height: 16px;
            margin-right: 10px;
            transition: transform 0.2s ease;
            transform: rotate(-90deg);
            flex-shrink: 0;
        }

        .nav-section-title.open .arrow {
            transform: rotate(0deg);
        }

        .nav-children {
            display: none;
            padding-bottom: 8px;
        }

        .nav-children.open {
            display: block;
        }

        .nav-child-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 20px 8px 40px;
            font-size: 13.5px;
            font-weight: 400;
            cursor: pointer;
            text-decoration: none;
            color: #000;
            transition: background-color 0.15s;
        }

        .nav-child-item:hover { background-color: #dde4ee; }
        .nav-child-item.active { background-color: #ccd6e4; font-weight: 600; }

        .nav-child-item svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            color: #4a6fa5;
        }

        /* Single nav item */
        .nav-item-single {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
            text-decoration: none;
            color: #000;
            border-bottom: 1px solid #9fb3ce;
            transition: background-color 0.15s;
        }

        .nav-item-single:hover { background-color: #dde4ee; }

        .nav-item-single.active {
            background-color: #ccd6e4;
            font-weight: 600;
        }

        .nav-item-single .nav-icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 30px 20px;
            margin-top: auto;
        }

        .logout-btn {
            background: none;
            border: none;
            font-size: 14px;
            font-weight: 400;
            color: #000;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            text-align: left;
            margin-left: 20px;
        }

        /* ════════════ MAIN CONTENT ════════════ */
        .main-content {
            flex: 1;
            padding: 50px 30px;
            overflow-y: auto;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-subtitle {
            font-size: 14px;
            color: #444;
            margin-bottom: 30px;
        }

        /* Alert */
        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger  { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* ════════ STAT CARDS ════════ */
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 22px 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background-color: #4a6fa5;
        }

        .stat-icon svg {
            width: 24px;
            height: 24px;
            color: #fff;
            stroke: #fff;
        }

        .stat-icon.green  { background-color: #27ae60; }
        .stat-icon.orange { background-color: #e67e22; }
        .stat-icon.purple { background-color: #8e44ad; }

        .stat-info h3 {
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
        }

        .stat-info p {
            font-size: 13px;
            color: #666;
            margin-top: 4px;
            font-weight: 400;
        }

        /* ════════ TABLE ════════ */
        .table-wrapper {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            margin-bottom: 30px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 24px;
            border-bottom: 1px solid #eee;
        }

        .table-title {
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-title svg {
            width: 18px;
            height: 18px;
            color: #4a6fa5;
        }

        /* Buttons */
        .btn {
            border: none;
            border-radius: 8px;
            padding: 10px 22px;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn svg { width: 14px; height: 14px; }

        .btn-primary { background-color: #4a6fa5; color: #fff; }
        .btn-primary:hover { background-color: #3b5d8a; }

        .btn-warning { background-color: #e67e22; color: #fff; }
        .btn-warning:hover { background-color: #ca6f1e; }

        .btn-danger { background-color: #c0392b; color: #fff; }
        .btn-danger:hover { background-color: #a93226; }

        .btn-cancel { background-color: #d0d8e4; color: #333; }
        .btn-cancel:hover { background-color: #bcc8d8; }

        .btn-sm { padding: 7px 14px; font-size: 12px; }

        /* Data table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead th {
            background-color: #4a6fa5;
            color: #fff;
            padding: 13px 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
        }

        .data-table thead th:first-child {
            text-align: center;
            width: 50px;
        }

        .data-table tbody td {
            padding: 13px 16px;
            font-size: 13.5px;
            border-bottom: 1px solid #f0f0f0;
        }

        .data-table tbody td:first-child {
            text-align: center;
            color: #888;
            font-weight: 600;
        }

        .data-table tbody tr:hover { background-color: #f5f8fb; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        .action-btns { display: flex; gap: 6px; }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-blue   { background: #d1ecf1; color: #0c5460; }
        .badge-green  { background: #d4edda; color: #155724; }
        .badge-count  { background: #e2e3e5; color: #383d41; }

        /* ════════ MODAL ════════ */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.4);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.show { display: flex; }

        .modal {
            background: #fff;
            border-radius: 12px;
            padding: 32px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.12);
        }

        .modal-title {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #eee;
        }

        .form-group { margin-bottom: 18px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
        }

        .form-group label .required { color: #c0392b; }

        .form-control, .form-select {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #ccd6e4;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: border-color 0.15s;
            background: #fff;
        }
        .form-control:focus, .form-select:focus { border-color: #4a6fa5; }

        .form-select {
            appearance: none;
            background: #fff url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23000' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 12px center;
            background-size: 14px;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #eee;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #888;
        }
        .empty-state svg {
            width: 48px;
            height: 48px;
            margin-bottom: 12px;
            opacity: 0.4;
        }
        .empty-state p { font-size: 14px; }

        /* Shortcut cards */
        .shortcut-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .shortcut-card {
            background: #fff;
            border-radius: 10px;
            padding: 28px 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #000;
            transition: transform 0.15s, box-shadow 0.15s;
            cursor: pointer;
        }

        .shortcut-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        }

        .shortcut-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background-color: #4a6fa5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .shortcut-icon svg {
            width: 26px;
            height: 26px;
            color: #fff;
            stroke: #fff;
        }

        .shortcut-icon.green  { background-color: #27ae60; }
        .shortcut-icon.orange { background-color: #e67e22; }
        .shortcut-icon.purple { background-color: #8e44ad; }

        .shortcut-label {
            font-size: 13.5px;
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- ════════════ SIDEBAR ════════════ -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <button class="hamburger-btn">
                <span></span><span></span><span></span>
            </button>
            <span class="sidebar-brand">E-Rapor</span>
        </div>

        <div class="sidebar-search">
            <div class="search-box">
                <input type="text" placeholder="Cari">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" stroke-width="2"/>
                </svg>
            </div>
        </div>

        <div class="nav-menu">

            {{-- Manajemen Data --}}
            <div class="nav-section">
                <div class="nav-section-title open" onclick="this.classList.toggle('open'); document.getElementById('nav-data').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    Manajemen Data
                </div>
                <div class="nav-children open" id="nav-data">
                    <a href="{{ route('admin.siswa.index') }}" class="nav-child-item {{ request()->routeIs('admin.siswa*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                        Data Siswa
                    </a>
                    <a href="{{ route('admin.kelas.index') }}" class="nav-child-item {{ request()->routeIs('admin.kelas*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 0h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                        Data Kelas
                    </a>
                   
                </div>
            </div>

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="nav-item-single {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
                Dashboard
            </a>

            {{-- Kembali ke Guru --}}
            <a href="{{ route('dashboard') }}" class="nav-item-single" style="border-bottom:none;">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/></svg>
                Halaman Guru
            </a>

        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Keluar</button>
            </form>
        </div>
    </aside>

    <!-- ════════════ MAIN CONTENT ════════════ -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error) {{ $error }}<br> @endforeach
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')

    <script>
        // Tutup modal klik backdrop
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (e) {
                    if (e.target === overlay) overlay.classList.remove('show');
                });
            });
        });
    </script>
</body>
</html>
