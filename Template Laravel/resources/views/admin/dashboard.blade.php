<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — E-Rapor PKBM</title>
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
        }

        .nav-section-title .arrow {
            width: 16px;
            height: 16px;
            margin-right: 10px;
            transition: transform 0.2s ease;
            transform: rotate(-90deg);
        }

        .nav-section-title.open .arrow {
            transform: rotate(0deg);
        }

        .nav-children {
            display: none;
            padding-bottom: 12px;
        }

        .nav-children.open {
            display: block;
        }

        .nav-child-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 20px 8px 40px;
            font-size: 13.5px;
            font-weight: 400;
            cursor: pointer;
        }

        .nav-item-single {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
            text-decoration: none;
            color: #000;
            border-bottom: 1px solid #9fb3ce;
        }

        .nav-item-single.active {
            background-color: #ccd6e4;
        }

        .nav-item-single .arrow {
            width: 16px;
            height: 16px;
            margin-right: 10px;
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

        .page-header { margin-bottom: 40px; }
        .page-title { font-size: 22px; font-weight: 700; margin-bottom: 6px; }
        .page-subtitle { font-size: 14px; color: #444; }

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
            width: 48px; height: 48px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg { width: 24px; height: 24px; color: #fff; stroke: #fff; }
        .stat-icon.blue   { background-color: #4a6fa5; }
        .stat-icon.green  { background-color: #27ae60; }
        .stat-icon.orange { background-color: #e67e22; }
        .stat-icon.purple { background-color: #8e44ad; }

        .stat-info h3 { font-size: 28px; font-weight: 700; line-height: 1; }
        .stat-info p  { font-size: 13px; color: #666; margin-top: 4px; }

        .table-wrapper {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
            margin-bottom: 30px;
        }

        .table-header {
            padding: 18px 24px;
            border-bottom: 1px solid #eee;
            font-size: 15px;
            font-weight: 700;
        }

        .data-table { width: 100%; border-collapse: collapse; }

        .data-table thead th {
            background-color: #4a6fa5;
            color: #fff;
            padding: 13px 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
        }

        .data-table thead th:first-child { text-align: center; width: 50px; }

        .data-table tbody td {
            padding: 13px 16px;
            font-size: 13.5px;
            border-bottom: 1px solid #f0f0f0;
        }

        .data-table tbody td:first-child { text-align: center; color: #888; font-weight: 600; }
        .data-table tbody tr:hover { background-color: #f5f8fb; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        .badge { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-count { background: #e2e3e5; color: #383d41; }
        .badge-green { background: #d4edda; color: #155724; }

        .empty-state { text-align: center; padding: 50px 20px; color: #888; font-size: 14px; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <button class="hamburger-btn"><span></span><span></span><span></span></button>
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
            <!-- Akun Pengguna -->
            <div class="nav-section">
                <div class="nav-section-title open" onclick="this.classList.toggle('open'); document.getElementById('c-akun').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Akun Pengguna
                </div>
                <div class="nav-children open" id="c-akun">
                    <div class="nav-child-item">Informasi Pengguna</div>
                    <div class="nav-child-item">Ubah Kata Sandi</div>
                </div>
            </div>

            <!-- Data Siswa -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="this.classList.toggle('open'); document.getElementById('c-siswa').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Data Siswa
                </div>
                <div class="nav-children" id="c-siswa">
                    <div class="nav-child-item">Daftar Siswa</div>
                    <div class="nav-child-item">Tambah Siswa</div>
                </div>
            </div>

            <!-- Data Kelas -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="this.classList.toggle('open'); document.getElementById('c-kelas').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Data Kelas
                </div>
                <div class="nav-children" id="c-kelas">
                    <div class="nav-child-item">Daftar Kelas</div>
                    <div class="nav-child-item">Tambah Kelas</div>
                </div>
            </div>

            <!-- Data Guru -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="this.classList.toggle('open'); document.getElementById('c-guru').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Data Guru
                </div>
                <div class="nav-children" id="c-guru">
                    <div class="nav-child-item">Daftar Guru</div>
                    <div class="nav-child-item">Tambah Guru</div>
                </div>
            </div>

            <!-- Mata Pelajaran -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="this.classList.toggle('open'); document.getElementById('c-mapel').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Mata Pelajaran
                </div>
                <div class="nav-children" id="c-mapel">
                    <div class="nav-child-item">Daftar Mapel</div>
                    <div class="nav-child-item">Tambah Mapel</div>
                </div>
            </div>

            <!-- Lembaga -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="this.classList.toggle('open'); document.getElementById('c-lembaga').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Lembaga
                </div>
                <div class="nav-children" id="c-lembaga">
                    <div class="nav-child-item">Profil Lembaga</div>
                    <div class="nav-child-item">Data Lembaga</div>
                </div>
            </div>

            <!-- Dashboard (aktif) -->
            <a href="{{ route('admin.dashboard') }}" class="nav-item-single active">
                Dashboard
            </a>

            <!-- Rapor Siswa -->
            <div class="nav-item-single" style="border-bottom:none;">
                <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg> Rapor Siswa
            </div>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main-content">

        <div class="page-header">
            <h1 class="page-title">Dashboard Admin</h1>
            <p class="page-subtitle">Selamat datang, <strong>{{ Auth::user()->username }}</strong>. Berikut ringkasan data E-Rapor PKBM.</p>
        </div>

        <!-- STAT CARDS -->
        <div class="stat-cards">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_siswa'] }}</h3>
                    <p>Total Siswa</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_guru'] }}</h3>
                    <p>Total Guru</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21"/></svg>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_kelas'] }}</h3>
                    <p>Total Kelas</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div class="stat-info">
                    <h3>{{ $stats['total_mapel'] }}</h3>
                    <p>Mata Pelajaran</p>
                </div>
            </div>
        </div>

        <!-- RINGKASAN PER KELAS -->
        <div class="table-wrapper">
            <div class="table-header">Ringkasan Siswa per Kelas</div>
            @if($kelas->count() > 0)
            <table class="data-table">
                <thead><tr><th>No</th><th>Nama Kelas</th><th>Jumlah Siswa</th></tr></thead>
                <tbody>
                    @foreach($kelas as $i => $k)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td><span class="badge badge-count">{{ $k->siswa_count }} siswa</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">Belum ada data kelas.</div>
            @endif
        </div>

        <!-- DAFTAR GURU -->
        <div class="table-wrapper">
            <div class="table-header">Daftar Guru</div>
            @if($guruList->count() > 0)
            <table class="data-table">
                <thead><tr><th>No</th><th>Nama Guru</th><th>Username</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($guruList as $i => $g)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $g->nama_guru }}</td>
                        <td>{{ $g->user->username ?? '-' }}</td>
                        <td><span class="badge badge-green">Aktif</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">Belum ada data guru.</div>
            @endif
        </div>

    </main>

</body>
</html>
