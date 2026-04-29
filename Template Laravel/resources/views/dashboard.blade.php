<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — E-Rapor PKBM</title>
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

        /* Nav Menu */
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

        .nav-child-item .chevron {
            width: 14px;
            height: 14px;
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
            overflow-x: hidden;
        }

        .filter-row {
            display: flex;
            gap: 40px;
            margin-bottom: 40px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-group label {
            font-size: 18px;
            font-weight: 700;
        }

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

        /* Student Card Structure */

        .student-list{
            width:100%;
            display:block;
        }
        .student-row {
            margin-bottom: 30px;
            width: 100%;
            display: block;
        }

        .student-name {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .student-name svg {
            width: 24px;
            height: 24px;
            stroke-width: 2px;
        }

        .input-row {
            display: flex;
            gap: 24px;
            align-items: flex-start;
            width: 100%;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .input-group.nilai {
            width: 220px;
        }

        .input-group.catatan {
            flex: 1; /* takes remaining space */
        }

        .input-group label {
            font-size: 13px;
            font-weight: 500;
            color: #000;
        }

        .input-group label .required {
            color: #e53e3e;
        }

        .form-input {
            width: 100%;
            height: 44px;
            background-color: #fff;
            border: none;
            border-radius: 4px;
            padding: 0 16px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            outline: none;
        }

        .form-input::placeholder {
            color: #888;
        }

        .submit-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
        }

        .btn-submit {
            background-color: #fff;
            color: #000;
            border: none;
            border-radius: 8px;
            padding: 10px 32px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.1s;
        }
        
        .btn-submit:active {
            transform: scale(0.98);
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
                <div class="nav-section-title open" onclick="this.classList.toggle('open'); document.getElementById('c-akun').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Akun Pengguna
                </div>
                <div class="nav-children open" id="c-akun">
                    <div class="nav-child-item">Informasi Pengguna</div>
                    <div class="nav-child-item">Ubah Kata Sandi</div>
                </div>
            </div>

            <!-- Kelas -->
            <div class="nav-section">
                <div class="nav-section-title open" onclick="this.classList.toggle('open'); document.getElementById('c-kelas').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Kelas
                </div>
                <div class="nav-children open" id="c-kelas">
                    <div class="nav-child-item">
                        Paket A <svg class="chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </div>
                    <div class="nav-child-item">
                        Paket B <svg class="chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </div>
                    <div class="nav-child-item">
                        Paket C <svg class="chevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Mata Pelajaran -->
            <div class="nav-section">
                <div class="nav-section-title open" onclick="this.classList.toggle('open'); document.getElementById('c-mapel').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Mata Pelajaran
                </div>
                <div class="nav-children open" id="c-mapel">
                    <div class="nav-child-item">Bahasa Indonesia</div>
                    <div class="nav-child-item">Bahasa Inggris</div>
                </div>
            </div>

            <!-- Masukkan Nilai -->
            <a href="#" class="nav-item-single active">
                Masukkan Nilai
            </a>

            <!-- Rapor Siswa -->
            <div class="nav-item-single" style="border-bottom:none;">
                <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg> Rapor Siswa
            </div>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- ════════════ MAIN CONTENT ════════════ -->
    <main class="main-content">

        {{-- ── Flash Messages ── --}}
        @if(session('success'))
            <div style="
                background-color:#d4edda; color:#155724;
                border:1px solid #c3e6cb; border-radius:8px;
                padding:14px 20px; margin-bottom:24px;
                font-size:14px; font-weight:500;">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div style="
                background-color:#f8d7da; color:#721c24;
                border:1px solid #f5c6cb; border-radius:8px;
                padding:14px 20px; margin-bottom:24px;
                font-size:14px; font-weight:500;">
                @foreach($errors->all() as $error){{ $error }}<br>@endforeach
            </div>
        @endif

        {{-- ── Filter Form (GET) ── --}}
        <form id="filter-form" method="GET" action="{{ route('dashboard') }}">

            <div class="filter-row">
                {{-- Dropdown Pilih Kelas --}}
                <div class="filter-group">
                    <label for="kelas_id">Pilih Kelas</label>
                    <select
                        id="kelas_id"
                        name="kelas_id"
                        class="filter-select"
                        onchange="document.getElementById('filter-form').submit()">
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelasList as $kelas)
                            <option
                                value="{{ $kelas->id_kelas }}"
                                {{ $selectedKelas == $kelas->id_kelas ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Dropdown Pilih Mata Pelajaran --}}
                <div class="filter-group">
                    <label for="mapel_id">Pilih Mata Pelajaran</label>
                    <select
                        id="mapel_id"
                        name="mapel_id"
                        class="filter-select"
                        onchange="document.getElementById('filter-form').submit()">
                        <option value="">— Pilih Mata Pelajaran —</option>
                        @foreach($mataPelajaran as $mapel)
                            <option
                                value="{{ $mapel->id_mapel }}"
                                {{ $selectedMapel == $mapel->id_mapel ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </form>

        {{-- ── Info heading kelas terpilih ── --}}
        @if($kelasTerpilih)
            <p style="font-size:15px; font-weight:600; margin-bottom:20px; color:#2c3e50;">
                Kelas: {{ $kelasTerpilih->nama_kelas }}
                <span style="font-weight:400; color:#555;">({{ $siswa->count() }} siswa)</span>
            </p>
        @endif

        {{-- ── Prompt jika belum pilih kelas ── --}}
        @if(!$selectedKelas)
            <div style="
                background:#fff; border-radius:10px;
                padding:48px 24px; text-align:center;
                box-shadow:0 2px 6px rgba(0,0,0,0.06);
                color:#888;">
                <svg style="width:48px;height:48px;margin-bottom:12px;opacity:.35;"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21
                             M6.75 6.75h.75m-.75 3h.75m-.75 3h.75
                             m3-6h.75m-.75 3h.75m-.75 3h.75
                             M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25
                             c.621 0 1.125.504 1.125 1.125V21
                             M3 3h12m-.75 4.5H21m-3.75 0h.008v.008h-.008v-.008z"/>
                </svg>
                <p style="font-size:14px;">Silakan pilih kelas terlebih dahulu untuk melihat daftar siswa.</p>
            </div>

        {{-- ── Form input nilai (tampil setelah kelas dipilih) ── --}}
        @else
            <form action="{{ route('nilai.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
                <input type="hidden" name="mapel_id" value="{{ $selectedMapel }}">

                <div class="student-list">

                    {{-- ── Siswa nyata dari database (dengan nama) ── --}}
                    @foreach($siswa as $s)
                    <div class="student-row">
                        <div class="student-name">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                            {{ strtoupper($s->nama_siswa) }}
                        </div>
                        <div class="input-row">
                            <div class="input-group nilai">
                                <label>Masukkan nilai <span class="required">*</span></label>
                                <input type="number" class="form-input" placeholder="1 - 100"
                                       min="1" max="100" oninput="batasNilai(this)">
                            </div>
                            <div class="input-group catatan">
                                <label>Catatan</label>
                                <input type="text" class="form-input" placeholder="Catatan untuk siswa">
                            </div>
                        </div>
                    </div>
                    @endforeach

                    {{-- ── Sisa slot kosong sampai 35 ── --}}
                    @for($i = $siswa->count() + 1; $i <= 35; $i++)
                    <div class="student-row">
                        <div class="student-name">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                            NAMA SISWA {{ $i }}
                        </div>
                        <div class="input-row">
                            <div class="input-group nilai">
                                <label>Masukkan nilai <span class="required">*</span></label>
                                <input type="number" class="form-input" placeholder="1 - 100"
                                       min="1" max="100" oninput="batasNilai(this)">
                            </div>
                            <div class="input-group catatan">
                                <label>Catatan</label>
                                <input type="text" class="form-input" placeholder="Catatan untuk siswa">
                            </div>
                        </div>
                    </div>
                    @endfor

                </div>

                <div class="submit-wrapper">
                    <button type="button" class="btn-submit">Submit</button>
                </div>
            </form>
        @endif

    </main>

<script>
function batasNilai(input){
    if(input.value > 100){
        input.value = 100;
    }

    if(input.value < 1 && input.value != ''){
        input.value = 1;
    }
}
</script>

</body>
</html>
