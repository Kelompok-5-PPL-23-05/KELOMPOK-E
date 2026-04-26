<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Mata Pelajaran — E-Rapor PKBM</title>
    <meta name="description" content="Pilih mata pelajaran yang Anda ampu untuk mengelola data siswa dan nilai.">
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
            text-decoration: none;
            color: #000;
        }

        .nav-child-item.active {
            background-color: #ccd6e4;
            font-weight: 600;
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
            padding: 40px 36px;
            overflow-y: auto;
        }

        .page-header {
            margin-bottom: 32px;
        }

        .page-header h1 {
            font-size: 26px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .page-header p {
            font-size: 14px;
            color: #4a5568;
            margin-top: 4px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #718096;
            margin-bottom: 12px;
        }

        .breadcrumb a {
            color: #4a6fa5;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb span { color: #a0aec0; }

        /* Alert */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: #c6f6d5;
            color: #22543d;
            border-left: 4px solid #48bb78;
        }

        .alert-error {
            background: #fed7d7;
            color: #742a2a;
            border-left: 4px solid #fc8181;
        }

        /* Card */
        .card {
            background: #fff;
            border-radius: 14px;
            padding: 32px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
        }

        .card-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #4a6fa5, #6c8bbf);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-icon svg {
            width: 24px;
            height: 24px;
            stroke: #fff;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .card-subtitle {
            font-size: 13px;
            color: #718096;
            margin-top: 2px;
        }

        /* Mapel Grid */
        .mapel-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .mapel-card {
            position: relative;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px 20px 20px 20px;
            cursor: pointer;
            transition: all 0.25s ease;
            background: #fff;
            overflow: hidden;
        }

        .mapel-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4a6fa5, #6c8bbf);
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .mapel-card:hover {
            border-color: #4a6fa5;
            box-shadow: 0 4px 12px rgba(74, 111, 165, 0.2);
            transform: translateY(-2px);
        }

        .mapel-card:hover::before {
            opacity: 1;
        }

        .mapel-card.selected {
            border-color: #4a6fa5;
            background: linear-gradient(135deg, #ebf4ff, #f0f7ff);
            box-shadow: 0 4px 12px rgba(74, 111, 165, 0.25);
        }

        .mapel-card.selected::before {
            opacity: 1;
        }

        .mapel-card input[type="checkbox"] {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #4a6fa5;
        }

        .mapel-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #eef2f6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            font-size: 20px;
        }

        .mapel-card.selected .mapel-card-icon {
            background: #bee3f8;
        }

        .mapel-name {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a2e;
            padding-right: 28px;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 28px 0;
        }

        /* Counter */
        .selection-counter {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #4a5568;
            margin-bottom: 24px;
        }

        .counter-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 28px;
            height: 28px;
            background: #4a6fa5;
            color: #fff;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            padding: 0 8px;
            transition: all 0.2s;
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            padding: 12px 28px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4a6fa5, #6c8bbf);
            color: #fff;
            box-shadow: 0 4px 12px rgba(74, 111, 165, 0.35);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3a5a90, #5a7aaf);
            box-shadow: 0 6px 16px rgba(74, 111, 165, 0.45);
            transform: translateY(-1px);
        }

        .btn-primary:active { transform: scale(0.98); }

        .btn-secondary {
            background: #e2e8f0;
            color: #2d3748;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
            transform: translateY(-1px);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 48px;
            color: #718096;
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            margin: 0 auto 16px;
            stroke: #a0aec0;
        }

        /* Info box */
        .info-hint {
            background: #ebf8ff;
            border-left: 4px solid #4299e1;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            color: #2b6cb0;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
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
                    <a href="{{ route('dashboard.select-mapel') }}" class="nav-child-item active" style="text-decoration: none; color: inherit;">
                        ⚙️ Pilih Mata Pelajaran
                    </a>
                    <a href="{{ route('dashboard.manage-students') }}" class="nav-child-item" style="text-decoration: none; color: inherit;">
                        👥 Kelola Siswa
                    </a>
                    @forelse ($mataPelajaranDiampu as $id)
                        @php $m = $semuaMataPelajaran->firstWhere('id_mapel', $id); @endphp
                        @if ($m)
                            <div class="nav-child-item">{{ $m->nama_mapel }}</div>
                        @endif
                    @empty
                        <div class="nav-child-item" style="color: #999; font-style: italic;">
                            Belum memilih mata pelajaran
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Masukkan Nilai -->
            <a href="{{ route('dashboard') }}" class="nav-item-single">
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
                <button type="submit" class="logout-btn">Keluar</button>
            </form>
        </div>
    </aside>

    <!-- ════════════ MAIN CONTENT ════════════ -->
    <main class="main-content">

        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>›</span>
            <span>Pilih Mata Pelajaran</span>
        </div>

        <div class="page-header">
            <h1>Pilih Mata Pelajaran yang Diampu</h1>
            <p>Pilih satu atau lebih mata pelajaran yang Anda ampu untuk mengelola data siswa dan nilai.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                ✗ {{ $errors->first() }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="card-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <div>
                    <div class="card-title">Daftar Mata Pelajaran</div>
                    <div class="card-subtitle">Klik pada kartu untuk memilih / membatalkan pilihan</div>
                </div>
            </div>

            <div class="info-hint">
                💡 Setelah menyimpan, Anda hanya dapat mengelola siswa pada mata pelajaran yang dipilih.
            </div>

            <form id="formSelectMapel" action="{{ route('dashboard.store-mapel') }}" method="POST">
                @csrf

                <div class="selection-counter">
                    <span id="counter-badge" class="counter-badge">{{ count($mataPelajaranDiampu) }}</span>
                    <span>mata pelajaran dipilih</span>
                </div>

                @if ($semuaMataPelajaran->isEmpty())
                    <div class="empty-state">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" stroke-width="2"/>
                        </svg>
                        <p>Tidak ada mata pelajaran tersedia.</p>
                    </div>
                @else
                    <div class="mapel-grid" id="mapel-grid">
                        @foreach ($semuaMataPelajaran as $mapel)
                            @php
                                $isChecked = in_array($mapel->id_mapel, $mataPelajaranDiampu);
                                $icons = ['📚','📖','✏️','🔬','🧮','🌍','🎨','🏃','💻','🎵'];
                                $icon = $icons[$loop->index % count($icons)];
                            @endphp
                            <label class="mapel-card {{ $isChecked ? 'selected' : '' }}" for="mapel_{{ $mapel->id_mapel }}" id="card_{{ $mapel->id_mapel }}">
                                <input
                                    type="checkbox"
                                    id="mapel_{{ $mapel->id_mapel }}"
                                    name="mata_pelajaran_ids[]"
                                    value="{{ $mapel->id_mapel }}"
                                    {{ $isChecked ? 'checked' : '' }}
                                    onchange="updateCard(this)"
                                >
                                <div class="mapel-card-icon">{{ $icon }}</div>
                                <div class="mapel-name">{{ $mapel->nama_mapel }}</div>
                            </label>
                        @endforeach
                    </div>
                @endif

                <div class="divider"></div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary" id="btn-save">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        Simpan Pilihan
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Guru -->
        @if ($guru)
        <div class="card">
            <div class="card-header" style="margin-bottom: 0;">
                <div class="card-icon" style="background: linear-gradient(135deg, #48bb78, #68d391);">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                    </svg>
                </div>
                <div>
                    <div class="card-title">{{ $guru->nama_guru }}</div>
                    <div class="card-subtitle">Guru &bull; E-Rapor PKBM</div>
                </div>
            </div>
        </div>
        @endif

    </main>

    <script>
        function updateCard(checkbox) {
            const label = checkbox.closest('.mapel-card');
            if (checkbox.checked) {
                label.classList.add('selected');
            } else {
                label.classList.remove('selected');
            }
            updateCounter();
        }

        function updateCounter() {
            const count = document.querySelectorAll('#mapel-grid input[type="checkbox"]:checked').length;
            document.getElementById('counter-badge').textContent = count;
        }

        // Init counter on load
        updateCounter();
    </script>

</body>
</html>
