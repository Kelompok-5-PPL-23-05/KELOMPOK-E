<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran — E-Rapor PKBM</title>
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

        /* ════════════ SIDEBAR (sama dengan halaman absensi) ════════════ */
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

        .sidebar-brand { font-size: 20px; font-weight: 700; color: #000; }

        .sidebar-search { padding: 0 20px 16px; }

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
        .search-box svg { width: 16px; height: 16px; color: #6c8bbf; flex-shrink: 0; }

        .nav-menu { flex: 1; padding: 0; border-top: 1px solid #9fb3ce; }
        .nav-section { border-bottom: 1px solid #9fb3ce; }

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

        .nav-section-title.open .arrow { transform: rotate(0deg); }
        .nav-children { display: none; padding-bottom: 12px; }
        .nav-children.open { display: block; }

        .nav-child-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 20px 8px 40px;
            font-size: 13.5px;
            font-weight: 400;
            cursor: pointer;
        }

        .nav-child-item .chevron { width: 14px; height: 14px; }

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
            font-weight: 600;
        }

        .nav-item-single .arrow { width: 16px; height: 16px; margin-right: 10px; }

        .sidebar-footer { padding: 30px 20px; margin-top: auto; }

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
        .main-content { flex: 1; padding: 50px 30px; overflow-y: auto; }

        /* Page title row */
        .page-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 700;
        }

        .page-title svg {
            width: 26px;
            height: 26px;
            flex-shrink: 0;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #4a6a9e;
            text-decoration: none;
            border: 1.5px solid #4a6a9e;
            border-radius: 8px;
            padding: 8px 18px;
            background: transparent;
            font-family: 'Poppins', sans-serif;
            transition: background 0.18s, color 0.18s;
        }

        .btn-back svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .btn-back:hover {
            background: #4a6a9e;
            color: #fff;
        }

        .btn-back:hover svg { stroke: #fff; }

        /* Filter */
        .filter-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            align-items: flex-end;
        }

        .filter-group { display: flex; flex-direction: column; gap: 8px; }
        .filter-group label { font-size: 16px; font-weight: 700; }

        .filter-select {
            appearance: none;
            background: #fff url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23000' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 12px center;
            background-size: 16px;
            border: none;
            border-radius: 8px;
            padding: 12px 40px 12px 16px;
            font-size: 15px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            color: #000;
            min-width: 260px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            cursor: pointer;
            outline: none;
        }

        .btn-filter {
            height: 48px;
            background-color: #6c8bbf;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0 24px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
        }

        .btn-filter:hover { background-color: #5575a8; }

        /* Rekap Table */
        .table-wrapper {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .rekap-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rekap-table thead {
            background-color: #6c8bbf;
            color: #fff;
        }

        .rekap-table thead th {
            padding: 14px 20px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }

        .rekap-table thead th:first-child { text-align: left; }

        .rekap-table tbody tr {
            border-bottom: 1px solid #e8edf3;
            transition: background 0.15s;
        }

        .rekap-table tbody tr:last-child { border-bottom: none; }
        .rekap-table tbody tr:hover { background-color: #f4f7fb; }

        .rekap-table tbody td {
            padding: 14px 20px;
            font-size: 13.5px;
            text-align: center;
        }

        .rekap-table tbody td:first-child {
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Badge warna per kategori */
        .badge {
            display: inline-block;
            min-width: 36px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-hadir  { background: #d4edda; color: #155724; }
        .badge-sakit  { background: #fff3cd; color: #856404; }
        .badge-izin   { background: #cce5ff; color: #004085; }
        .badge-alfa   { background: #f8d7da; color: #721c24; }
        .badge-total  { background: #e2e3e5; color: #383d41; }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 14px;
        }

        .kelas-label {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #333;
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
            <!-- Akun Pengguna -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="this.classList.toggle('open'); document.getElementById('c-akun').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Akun Pengguna
                </div>
                <div class="nav-children" id="c-akun">
                    <div class="nav-child-item">Informasi Pengguna</div>
                    <div class="nav-child-item">Ubah Kata Sandi</div>
                </div>
            </div>

            <!-- Kelas -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="this.classList.toggle('open'); document.getElementById('c-kelas').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Kelas
                </div>
                <div class="nav-children" id="c-kelas">
                    <div class="nav-child-item">Paket A
                        <svg class="chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </div>
                    <div class="nav-child-item">Paket B
                        <svg class="chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </div>
                    <div class="nav-child-item">Paket C
                        <svg class="chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Mata Pelajaran -->
            <div class="nav-section">
                <div class="nav-section-title" onclick="this.classList.toggle('open'); document.getElementById('c-mapel').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Mata Pelajaran
                </div>
                <div class="nav-children" id="c-mapel">
                    <div class="nav-child-item">Bahasa Indonesia</div>
                    <div class="nav-child-item">Bahasa Inggris</div>
                </div>
            </div>

            <!-- Masukkan Nilai -->
            <a href="{{ route('dashboard') }}" class="nav-item-single">
                Masukkan Nilai
            </a>

            <!-- Absensi (active) -->
            <a href="{{ route('absensi.index') }}" class="nav-item-single active">
                Absensi
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

    <!-- ════════════ MAIN CONTENT ════════════ -->
    <main class="main-content">

        <div class="page-title-row">
            <h1 class="page-title">
                {{-- SVG: bar-chart profesional --}}
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"/>
                    <line x1="12" y1="20" x2="12" y2="4"/>
                    <line x1="6"  y1="20" x2="6"  y2="14"/>
                    <line x1="2"  y1="20" x2="22" y2="20"/>
                </svg>
                Rekap Kehadiran Siswa
            </h1>
            @if($selectedKelas)
                <a href="{{ route('absensi.index', ['kelas_id' => $selectedKelas]) }}" class="btn-back">
                    {{-- SVG: arrow-left --}}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M5 12l7 7M5 12l7-7"/>
                    </svg>
                    Kembali ke Input Absensi
                </a>
            @endif
        </div>

        {{-- Filter Kelas --}}
        <form method="GET" action="{{ route('absensi.rekap') }}">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Pilih Kelas</label>
                    <select name="kelas_id" class="filter-select">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id_kelas }}"
                                {{ $selectedKelas == $kelas->id_kelas ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-filter">Tampilkan</button>
            </div>
        </form>

        {{-- Tabel Rekap --}}
        @if($selectedKelas)

            @php
                $namaKelas = $kelasList->firstWhere('id_kelas', $selectedKelas)?->nama_kelas ?? '';
            @endphp

            @if(count($rekap) > 0)
                <p class="kelas-label">Kelas: {{ $namaKelas }}</p>

                <div class="table-wrapper">
                    <table class="rekap-table">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Hadir</th>
                                <th>Sakit</th>
                                <th>Izin</th>
                                <th>Alfa</th>
                                <th>Total Hari</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rekap as $row)
                                <tr>
                                    <td>{{ $row['nama_siswa'] }}</td>
                                    <td><span class="badge badge-hadir">{{ $row['hadir'] }}</span></td>
                                    <td><span class="badge badge-sakit">{{ $row['sakit'] }}</span></td>
                                    <td><span class="badge badge-izin">{{ $row['izin'] }}</span></td>
                                    <td><span class="badge badge-alfa">{{ $row['alfa'] }}</span></td>
                                    <td><span class="badge badge-total">{{ $row['total'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="no-data">
                    Belum ada data absensi untuk kelas <strong>{{ $namaKelas }}</strong>.<br>
                    <a href="{{ route('absensi.index', ['kelas_id' => $selectedKelas]) }}" style="color:#5575a8;">
                        Klik di sini untuk mengisi absensi →
                    </a>
                </div>
            @endif

        @else
            <p class="no-data">Pilih kelas terlebih dahulu untuk melihat rekap kehadiran.</p>
        @endif

    </main>

</body>
</html>
