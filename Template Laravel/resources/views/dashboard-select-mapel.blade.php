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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
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

        /* Choices.js Customization to match theme */
        .choices__inner {
            background-color: #fff;
            border: 1.5px solid #ccd6e4;
            border-radius: 10px;
            padding: 7px 10px 3px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        .choices.is-focused .choices__inner {
            border-color: #4a6fa5;
        }
        .choices__list--multiple .choices__item {
            background-color: #4a6fa5;
            border: 1px solid #3b5d8a;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
        }
        .choices[data-type*=select-multiple] .choices__button {
            border-left: 1px solid #3b5d8a;
            margin-left: 5px;
        }
        .choices__list--dropdown {
            font-family: 'Poppins', sans-serif;
            border-radius: 10px;
            border: 1.5px solid #ccd6e4;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-top: 5px;
        }
        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background-color: #eef2f6;
            color: #1a1a2e;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #1a1a2e;
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
            <a href="{{ route('dashboard') }}" class="nav-item-single">
                <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="width:16px; height:16px; margin-right:10px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
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
                    <a id="link-pilih-mapel" href="{{ route('dashboard.select-mapel') }}" class="nav-child-item active" style="text-decoration: none; color: inherit;">
                        ⚙️ Pilih Mata Pelajaran
                    </a>
                    <a href="{{ route('dashboard.manage-students') }}" class="nav-child-item" style="text-decoration: none; color: inherit;">
                        👥 Kelola Siswa
                    </a>
                </div>
            </div>

            <!-- Masukkan Nilai -->
            <a href="{{ route('input-nilai') }}" class="nav-item-single">
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
                    <div class="card-subtitle">Gunakan dropdown di bawah untuk memilih mata pelajaran yang Anda ampu</div>
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
                    <div class="form-group">
                        <label for="mata_pelajaran_ids">Pilih Mata Pelajaran (Dropdown)</label>
                        <select 
                            name="mata_pelajaran_ids[]" 
                            id="mata_pelajaran_ids" 
                            multiple 
                            style="width: 100%;">
                            @foreach ($semuaMataPelajaran as $mapel)
                                @php
                                    $isSelected = in_array($mapel->id_mapel, $mataPelajaranDiampu);
                                @endphp
                                <option 
                                    value="{{ $mapel->id_mapel }}" 
                                    {{ $isSelected ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        <p style="font-size:12px; color:#718096; margin-top:8px;">
                            💡 <i>Ketik untuk mencari mata pelajaran. Anda dapat memilih lebih dari satu mata pelajaran.</i>
                        </p>
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

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        function updateCounter() {
            const select = document.getElementById('mata_pelajaran_ids');
            let count = 0;
            if (select) {
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].selected) {
                        count++;
                    }
                }
                const badge = document.getElementById('counter-badge');
                if (badge) {
                    badge.textContent = count;
                }
            }
        }

        // Init counter and Choices.js on load
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.getElementById('mata_pelajaran_ids');
            if (selectElement) {
                const choices = new Choices(selectElement, {
                    removeItemButton: true,
                    searchPlaceholderValue: 'Cari mata pelajaran...',
                    placeholder: true,
                    placeholderValue: 'Silakan ketik atau pilih mapel',
                    noResultsText: 'Tidak ada hasil ditemukan',
                    noChoicesText: 'Tidak ada pilihan lagi untuk dipilih',
                    itemSelectText: 'Klik untuk memilih',
                });
                
                // Update counter whenever an item is added or removed
                selectElement.addEventListener('addItem', updateCounter);
                selectElement.addEventListener('removeItem', updateCounter);
            }
            updateCounter();
        });
    </script>

</body>
</html>