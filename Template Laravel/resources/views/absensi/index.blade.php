<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Absensi — E-Rapor PKBM</title>
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
            font-weight: 600;
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

        /* Flash message */
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 8px;
            padding: 12px 20px;
            margin-bottom: 28px;
            font-size: 14px;
        }

        /* Filter row */
        .filter-row {
            display: flex;
            gap: 40px;
            margin-bottom: 10px;
            align-items: flex-end;
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
            transition: background 0.2s;
        }

        .btn-filter:hover { background-color: #5575a8; }

        .rekap-link-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 28px;
        }

        .rekap-link {
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

        .rekap-link svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .rekap-link:hover {
            background: #4a6a9e;
            color: #fff;
        }

        .rekap-link:hover svg { stroke: #fff; }

        /* Header kehadiran */
        .absensi-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 2px solid #9fb3ce;
            margin-bottom: 8px;
        }

        .absensi-header span {
            font-size: 13px;
            font-weight: 700;
            text-align: center;
            color: #333;
        }

        .absensi-header span:first-child { text-align: left; }

        /* Student Row */
        .student-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            gap: 12px;
            align-items: center;
            margin-bottom: 16px;
        }

        .student-name {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .student-name svg {
            width: 22px;
            height: 22px;
            stroke-width: 2px;
            flex-shrink: 0;
        }

        .absensi-input {
            width: 100%;
            height: 44px;
            background-color: #fff;
            border: none;
            border-radius: 4px;
            padding: 0 12px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            outline: none;
            text-align: center;
        }

        .absensi-input.is-invalid {
            border: 2px solid #e53e3e;
        }

        .absensi-input::placeholder { color: #aaa; }

        /* Error text */
        .error-text {
            font-size: 11px;
            color: #e53e3e;
            margin-top: 2px;
            text-align: center;
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

        .btn-submit:active { transform: scale(0.98); }

        .no-siswa {
            text-align: center;
            color: #666;
            margin-top: 40px;
            font-size: 14px;
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

            <!-- Absensi (ACTIVE) -->
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

        {{-- Flash success --}}
        @if(session('success'))
            <div class="alert-success" id="flash-msg">{{ session('success') }}</div>
        @endif

        {{-- Filter Kelas --}}
        <form method="GET" action="{{ route('absensi.index') }}">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Pilih Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="filter-select">
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

        {{-- Link ke Rekap --}}
        @if($selectedKelas)
            <div class="rekap-link-row">
                <a href="{{ route('absensi.rekap', ['kelas_id' => $selectedKelas]) }}" class="rekap-link">
                    {{-- SVG: bar-chart --}}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"/>
                        <line x1="12" y1="20" x2="12" y2="4"/>
                        <line x1="6"  y1="20" x2="6"  y2="14"/>
                        <line x1="2"  y1="20" x2="22" y2="20"/>
                    </svg>
                    Lihat Rekap Kehadiran
                    {{-- SVG: arrow-right --}}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M14 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        @endif

        {{-- Form Input Absensi --}}
        @if($selectedKelas && count($siswa) > 0)

            {{-- Validasi server-side errors --}}
            @if($errors->any())
                <div style="background:#fff3cd;border:1px solid #ffc107;color:#856404;border-radius:8px;padding:12px 20px;margin-bottom:20px;font-size:13px;">
                    <strong>Terdapat kesalahan input:</strong>
                    <ul style="margin-top:6px;padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('absensi.store') }}" method="POST" id="absensi-form">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">

                {{-- Header kolom --}}
                <div class="absensi-header">
                    <span>Nama Siswa</span>
                    <span>Hadir</span>
                    <span>Sakit</span>
                    <span>Izin</span>
                    <span>Alfa</span>
                </div>

                @foreach($siswa as $index => $s)
                    {{-- Ambil data absensi yang sudah ada (jika ada) --}}
                    @php
                        $existingAbsensi = \App\Models\Absensi::where('Siswaid_siswa', $s->id_siswa)->first();
                    @endphp

                    <div class="student-row">
                        {{-- Nama Siswa --}}
                        <div class="student-name">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                            </svg>
                            {{ strtoupper($s->nama_siswa) }}
                        </div>

                        <input type="hidden" name="absensi[{{ $index }}][siswa_id]" value="{{ $s->id_siswa }}">

                        {{-- Hadir --}}
                        <div>
                            <input type="number"
                                   id="hadir_{{ $s->id_siswa }}"
                                   name="absensi[{{ $index }}][hadir]"
                                   class="absensi-input @error('absensi.'.$index.'.hadir') is-invalid @enderror"
                                   placeholder="0"
                                   min="0"
                                   value="{{ old('absensi.'.$index.'.hadir', $existingAbsensi?->hadir ?? 0) }}"
                                   required>
                        </div>

                        {{-- Sakit --}}
                        <div>
                            <input type="number"
                                   id="sakit_{{ $s->id_siswa }}"
                                   name="absensi[{{ $index }}][sakit]"
                                   class="absensi-input @error('absensi.'.$index.'.sakit') is-invalid @enderror"
                                   placeholder="0"
                                   min="0"
                                   value="{{ old('absensi.'.$index.'.sakit', $existingAbsensi?->sakit ?? 0) }}"
                                   required>
                        </div>

                        {{-- Izin --}}
                        <div>
                            <input type="number"
                                   id="izin_{{ $s->id_siswa }}"
                                   name="absensi[{{ $index }}][izin]"
                                   class="absensi-input @error('absensi.'.$index.'.izin') is-invalid @enderror"
                                   placeholder="0"
                                   min="0"
                                   value="{{ old('absensi.'.$index.'.izin', $existingAbsensi?->izin ?? 0) }}"
                                   required>
                        </div>

                        {{-- Alfa --}}
                        <div>
                            <input type="number"
                                   id="alfa_{{ $s->id_siswa }}"
                                   name="absensi[{{ $index }}][alfa]"
                                   class="absensi-input @error('absensi.'.$index.'.alfa') is-invalid @enderror"
                                   placeholder="0"
                                   min="0"
                                   value="{{ old('absensi.'.$index.'.alfa', $existingAbsensi?->alfa ?? 0) }}"
                                   required>
                        </div>
                    </div>
                @endforeach

                <div class="submit-wrapper">
                    <button type="submit" class="btn-submit">Simpan Absensi</button>
                </div>
            </form>

        @elseif($selectedKelas && count($siswa) === 0)
            <p class="no-siswa">Tidak ada siswa pada kelas ini.</p>
        @else
            <p class="no-siswa">Pilih kelas terlebih dahulu untuk menampilkan daftar siswa.</p>
        @endif

    </main>

    <script>
        // Auto-dismiss flash message setelah 4 detik
        const flash = document.getElementById('flash-msg');
        if (flash) {
            setTimeout(() => {
                flash.style.transition = 'opacity 0.5s';
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 500);
            }, 4000);
        }

        // PPLE-67: Validasi client-side — nilai tidak boleh negatif
        document.getElementById('absensi-form')?.addEventListener('submit', function(e) {
            let valid = true;
            const inputs = this.querySelectorAll('input[type="number"]');
            inputs.forEach(input => {
                input.classList.remove('is-invalid');
                const val = parseInt(input.value, 10);
                if (isNaN(val) || val < 0) {
                    input.classList.add('is-invalid');
                    valid = false;
                }
            });
            if (!valid) {
                e.preventDefault();
                alert('Pastikan semua nilai tidak negatif dan sudah terisi.');
            }
        });
    </script>

</body>
</html>
