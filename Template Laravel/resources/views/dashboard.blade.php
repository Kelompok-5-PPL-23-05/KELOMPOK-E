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
            padding: 50px 30px 50px 30px;
            overflow-y: auto;
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
        .student-row {
            margin-bottom: 30px;
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
            <!-- Dashboard Link -->
            <a href="{{ route('dashboard') }}" class="nav-item-single active">
                <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

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
                <div class="nav-section-title" onclick="this.classList.toggle('open'); document.getElementById('c-kelas').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Kelas
                </div>
                <div class="nav-children" id="c-kelas">
                    <div class="nav-child-item">Paket A</div>
                    <div class="nav-child-item">Paket B</div>
                    <div class="nav-child-item">Paket C</div>
                </div>
            </div>

            <!-- Mata Pelajaran -->
            <div class="nav-section">
                <div class="nav-section-title open" onclick="this.classList.toggle('open'); document.getElementById('c-mapel').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Mata Pelajaran
                </div>
                <div class="nav-children open" id="c-mapel">
                    @if ($guru)
                        <a href="{{ route('dashboard.select-mapel') }}" class="nav-child-item" style="text-decoration: none; color: inherit;">
                            ⚙️ Pilih Mata Pelajaran
                        </a>
                        <a href="{{ route('dashboard.manage-students') }}" class="nav-child-item" style="text-decoration: none; color: inherit;">
                            👥 Kelola Siswa
                        </a>
                    @else
                        <div class="nav-child-item" style="color: #999; font-style: italic;">
                            Data guru tidak ditemukan
                        </div>
                    @endif
                </div>
            </div>

            <!-- Masukkan Nilai -->
            <a href="{{ route('input-nilai') }}" class="nav-item-single">
                Masukkan Nilai
            </a>

            <!-- Absensi -->
            <a href="{{ route('absensi.index') }}" class="nav-item-single">
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

        {{-- ── WELCOME MESSAGE (TOP) ── --}}
        <div style="background:#fff; border-radius:12px; padding:32px; box-shadow:0 4px 12px rgba(0,0,0,0.05); text-align:center; color:#555; margin-bottom: 24px;">
            <h2 style="margin-bottom:16px; color:#333;">Selamat Datang, {{ $guru->nama_guru ?? 'Guru' }}!</h2>
            <p>Gunakan menu di samping untuk mengelola data siswa, absensi, dan menginput nilai rapor.</p>
        </div>

        {{-- ── DASHBOARD STATISTIK ── --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            
            {{-- Progress Card (Line Chart) --}}
            <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
                <h3 style="font-size: 16px; color:#333; margin-bottom:16px; font-weight:600;">Progres Input Nilai</h3>
                <div style="margin-bottom: 12px; font-size: 14px; color: #666;">
                    Siswa Dinilai: <strong>{{ $totalSiswaDinilai }}</strong> dari <strong>{{ $totalSiswa }}</strong> 
                    <span style="float: right; font-weight: 700; color: #4CAF50;">{{ $progressNilai }}%</span>
                </div>
                <div style="height: 200px; position: relative;">
                    <canvas id="progressLineChart"></canvas>
                </div>
            </div>

            {{-- Rata-rata Kelas Card (Bar Chart) --}}
            <div style="background:#fff; border-radius:12px; padding:24px; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
                <h3 style="font-size: 16px; color:#333; margin-bottom:16px; font-weight:600;">Rata-rata Nilai per Kelas</h3>
                <div style="height: 200px; position: relative;">
                    @if($kelasStats->isEmpty())
                        <p style="font-size: 14px; color:#888; text-align:center; margin-top: 80px;">Belum ada data kelas.</p>
                    @else
                        <canvas id="kelasBarChart"></canvas>
                    @endif
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Progress Line Chart ---
            const ctxLine = document.getElementById('progressLineChart').getContext('2d');
            
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ['Start', 'Progres', 'Target'],
                    datasets: [{
                        label: 'Persentase Progres',
                        data: [0, {{ $progressNilai }}, 100],
                        borderColor: '#4CAF50',
                        backgroundColor: 'rgba(76, 175, 80, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: ['#fff', '#4CAF50', '#fff'],
                        pointBorderColor: '#4CAF50',
                        pointRadius: [0, 6, 0],
                        pointHoverRadius: 8,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) { return value + '%'; }
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // --- Kelas Bar Chart ---
            @if(!$kelasStats->isEmpty())
            const ctxBar = document.getElementById('kelasBarChart').getContext('2d');
            const labelsBar = [@foreach($kelasStats as $ks) 'Kelas {{ $ks->nama_kelas }}', @endforeach];
            const dataBar = [@foreach($kelasStats as $ks) {{ $ks->rata_rata }}, @endforeach];

            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: labelsBar,
                    datasets: [{
                        label: 'Rata-rata Nilai',
                        data: dataBar,
                        backgroundColor: 'rgba(26, 115, 232, 0.7)',
                        borderColor: '#1a73e8',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
            @endif
        });
    </script>

</body>
</html>
