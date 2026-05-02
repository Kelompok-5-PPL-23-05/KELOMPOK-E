<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Siswa — E-Rapor PKBM</title>
    <meta name="description" content="Kelola data siswa berdasarkan mata pelajaran yang diampu.">
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

        /* ════ SIDEBAR ════ */
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
            background: none; border: none; cursor: pointer;
            display: flex; flex-direction: column; gap: 5px; padding: 0;
        }
        .hamburger-btn span {
            display: block; width: 24px; height: 3px;
            background: #000; border-radius: 3px;
        }
        .sidebar-brand { font-size: 20px; font-weight: 700; color: #000; }
        .sidebar-search { padding: 0 20px 16px; }
        .search-box {
            display: flex; align-items: center; justify-content: space-between;
            background: transparent; border: 1px solid #6c8bbf;
            border-radius: 20px; padding: 8px 16px;
        }
        .search-box input {
            border: none; background: transparent; outline: none;
            font-size: 13px; font-family: 'Poppins', sans-serif; color: #000; width: 100%;
        }
        .search-box input::placeholder { color: #333; }
        .search-box svg { width: 16px; height: 16px; color: #6c8bbf; flex-shrink: 0; }
        .nav-menu { flex: 1; padding: 0; border-top: 1px solid #9fb3ce; }
        .nav-section { border-bottom: 1px solid #9fb3ce; }
        .nav-section-title {
            display: flex; align-items: center; padding: 12px 20px;
            font-size: 14px; font-weight: 400; color: #000; cursor: pointer;
        }
        .nav-section-title .arrow {
            width: 16px; height: 16px; margin-right: 10px;
            transition: transform 0.2s ease; transform: rotate(-90deg);
        }
        .nav-section-title.open .arrow { transform: rotate(0deg); }
        .nav-children { display: none; padding-bottom: 12px; }
        .nav-children.open { display: block; }
        .nav-child-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 8px 20px 8px 40px; font-size: 13.5px; font-weight: 400;
            cursor: pointer; text-decoration: none; color: #000;
        }
        .nav-child-item.active { background-color: #ccd6e4; font-weight: 600; }
        .nav-item-single {
            display: flex; align-items: center; padding: 12px 20px;
            font-size: 14px; font-weight: 400; cursor: pointer;
            text-decoration: none; color: #000; border-bottom: 1px solid #9fb3ce;
        }
        .nav-item-single .arrow { width: 16px; height: 16px; margin-right: 10px; }
        .sidebar-footer { padding: 30px 20px; margin-top: auto; }
        .logout-btn {
            background: none; border: none; font-size: 14px; font-weight: 400;
            color: #000; cursor: pointer; font-family: 'Poppins', sans-serif;
            text-align: left; margin-left: 20px;
        }

        /* ════ MAIN CONTENT ════ */
        .main-content { flex: 1; padding: 40px 36px; overflow-y: auto; }

        .breadcrumb {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: #718096; margin-bottom: 12px;
        }
        .breadcrumb a { color: #4a6fa5; text-decoration: none; font-weight: 500; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb span { color: #a0aec0; }

        .page-header { margin-bottom: 28px; }
        .page-header h1 { font-size: 26px; font-weight: 700; color: #1a1a2e; }
        .page-header p { font-size: 14px; color: #4a5568; margin-top: 4px; }

        /* Alert */
        .alert {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 14px 18px; border-radius: 10px; margin-bottom: 20px;
            font-size: 14px; font-weight: 500;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert-success { background: #c6f6d5; color: #22543d; border-left: 4px solid #48bb78; }
        .alert-error   { background: #fed7d7; color: #742a2a; border-left: 4px solid #fc8181; }

        /* Card */
        .card {
            background: #fff; border-radius: 14px; padding: 28px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08); margin-bottom: 24px;
        }
        .card-title {
            font-size: 17px; font-weight: 700; color: #1a1a2e; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }
        .card-title svg { width: 22px; height: 22px; stroke: #4a6fa5; }

        /* Filter row */
        .filter-form { display: flex; gap: 20px; flex-wrap: wrap; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; gap: 6px; min-width: 200px; flex: 1; }
        .filter-group label { font-size: 13px; font-weight: 600; color: #2d3748; }
        .filter-select {
            appearance: none;
            background: #f7fafc url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23000' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 12px center;
            background-size: 16px;
            border: 1.5px solid #cbd5e0; border-radius: 8px;
            padding: 10px 40px 10px 14px;
            font-size: 14px; font-family: 'Poppins', sans-serif; color: #1a1a2e;
            outline: none; cursor: pointer; transition: border-color 0.2s;
        }
        .filter-select:focus { border-color: #4a6fa5; }

        .btn-filter {
            padding: 10px 22px; border-radius: 8px; border: none;
            font-size: 14px; font-weight: 600; font-family: 'Poppins', sans-serif;
            cursor: pointer; transition: all 0.2s; white-space: nowrap;
            background: linear-gradient(135deg, #4a6fa5, #6c8bbf);
            color: #fff; box-shadow: 0 4px 12px rgba(74,111,165,0.3);
        }
        .btn-filter:hover {
            background: linear-gradient(135deg, #3a5a90, #5a7aaf);
            transform: translateY(-1px);
        }

        /* Info box */
        .info-box {
            background: #ebf8ff; border-left: 4px solid #4299e1;
            border-radius: 8px; padding: 12px 16px; font-size: 13.5px;
            color: #2b6cb0; margin: 16px 0;
        }

        /* Stats row */
        .stats-row {
            display: flex; gap: 16px; margin-bottom: 20px; flex-wrap: wrap;
        }
        .stat-chip {
            display: flex; align-items: center; gap: 8px;
            background: #f7fafc; border: 1.5px solid #e2e8f0;
            border-radius: 10px; padding: 10px 18px;
            font-size: 13px; font-weight: 600; color: #2d3748;
        }
        .stat-chip .stat-num {
            font-size: 18px; font-weight: 700; color: #4a6fa5;
        }

        /* Table */
        .table-wrapper { overflow-x: auto; margin-top: 8px; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f7fafc; border-bottom: 2px solid #e2e8f0; }
        th {
            padding: 12px 16px; text-align: left;
            font-weight: 600; color: #2d3748; font-size: 13px;
            text-transform: uppercase; letter-spacing: 0.04em;
        }
        td { padding: 14px 16px; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #4a5568; }
        tbody tr { transition: background 0.15s; }
        tbody tr:hover { background: #f7fafc; }
        tbody tr:last-child td { border-bottom: none; }

        .badge {
            display: inline-flex; align-items: center;
            padding: 4px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
        }
        .badge-blue  { background: #bee3f8; color: #2c5282; }
        .badge-green { background: #c6f6d5; color: #22543d; }

        /* No row */
        .no-data {
            text-align: center; padding: 48px;
            color: #a0aec0; font-size: 14px;
        }
        .no-data-icon { font-size: 40px; margin-bottom: 12px; }

        /* Guru info */
        .guru-info-row { display: flex; align-items: center; gap: 16px; }
        .guru-avatar {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #4a6fa5, #6c8bbf);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: 20px; color: #fff; font-weight: 700;
        }
        .guru-detail h3 { font-size: 16px; font-weight: 700; color: #1a1a2e; }
        .guru-detail p  { font-size: 13px; color: #718096; }
        .guru-mapel-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px; }
        .mapel-tag {
            background: #ebf4ff; color: #2c5282;
            border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 600;
        }
        .mapel-tag-empty { color: #a0aec0; font-size: 13px; font-style: italic; }

        /* Action link */
        .action-link {
            color: #4a6fa5; text-decoration: none; font-weight: 600; font-size: 13px;
            padding: 5px 12px; border-radius: 6px; background: #ebf4ff;
            transition: all 0.2s;
        }
        .action-link:hover { background: #bee3f8; color: #2c5282; }
    </style>
</head>
<body>

    <!-- ════ SIDEBAR ════ -->
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
            <div class="nav-section">
                <div class="nav-section-title open" onclick="this.classList.toggle('open'); document.getElementById('c-akun').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Akun Pengguna
                </div>
                <div class="nav-children open" id="c-akun">
                    <div class="nav-child-item">Informasi Pengguna</div>
                    <div class="nav-child-item">Ubah Kata Sandi</div>
                </div>
            </div>
            <div class="nav-section">
                <div class="nav-section-title open" onclick="this.classList.toggle('open'); document.getElementById('c-kelas').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Kelas
                </div>
                <div class="nav-children open" id="c-kelas">
                    @forelse ($kelas as $k)
                        <div class="nav-child-item">{{ $k->nama_kelas }}</div>
                    @empty
                        <div class="nav-child-item" style="color:#999; font-style:italic;">Tidak ada kelas</div>
                    @endforelse
                </div>
            </div>
            <div class="nav-section">
                <div class="nav-section-title open" onclick="this.classList.toggle('open'); document.getElementById('c-mapel').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Mata Pelajaran
                </div>
                <div class="nav-children open" id="c-mapel">
                    <a href="{{ route('dashboard.select-mapel') }}" class="nav-child-item" style="text-decoration:none; color:inherit;">
                        ⚙️ Pilih Mata Pelajaran
                    </a>
                    <a href="{{ route('dashboard.manage-students') }}" class="nav-child-item active" style="text-decoration:none; color:inherit;">
                        👥 Kelola Siswa
                    </a>
                    @forelse ($mataPelajaran as $m)
                        <div class="nav-child-item">{{ $m->nama_mapel }}</div>
                    @empty
                        <div class="nav-child-item" style="color:#999; font-style:italic;">Belum memilih</div>
                    @endforelse
                </div>
            </div>
            <a href="{{ route('dashboard') }}" class="nav-item-single">Masukkan Nilai</a>
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

    <!-- ════ MAIN CONTENT ════ -->
    <main class="main-content">

        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>›</span>
            <a href="{{ route('dashboard.select-mapel') }}">Pilih Mata Pelajaran</a>
            <span>›</span>
            <span>Kelola Siswa</span>
        </div>

        <div class="page-header">
            <h1>Kelola Data Siswa</h1>
            <p>Pilih mata pelajaran dan kelas untuk melihat dan mengelola daftar siswa.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">✗ {{ session('error') }}</div>
        @endif

        <!-- Filter Card -->
        <div class="card">
            <div class="card-title">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z"/>
                </svg>
                Filter Data Siswa
            </div>

            <form action="{{ route('dashboard.manage-students') }}" method="GET" id="filterForm">
                <div class="filter-form">
                    <div class="filter-group">
                        <label for="mapel_id">Mata Pelajaran <span style="color:#e53e3e;">*</span></label>
                        <select id="mapel_id" name="mapel_id" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @forelse ($mataPelajaran as $mapel)
                                <option value="{{ $mapel->id_mapel }}" {{ $selectedMapel == $mapel->id_mapel ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @empty
                                <option value="" disabled>Belum ada mata pelajaran diampu</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="kelas_id">Kelas <span style="color:#e53e3e;">*</span></label>
                        <select id="kelas_id" name="kelas_id" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="">-- Pilih Kelas --</option>
                            @forelse ($kelas as $k)
                                <option value="{{ $k->id_kelas }}" {{ $selectedKelas == $k->id_kelas ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada kelas</option>
                            @endforelse
                        </select>
                    </div>

                    <button type="submit" class="btn-filter">🔍 Tampilkan</button>
                </div>
            </form>

            @if (!$mataPelajaran->count())
                <div class="info-box" style="margin-top: 16px;">
                    ⚠️ Anda belum memilih mata pelajaran yang diampu.
                    <a href="{{ route('dashboard.select-mapel') }}" style="color:#2b6cb0; font-weight:600;">Pilih sekarang →</a>
                </div>
            @endif
        </div>

        <!-- Data Siswa Card -->
        <div class="card">
            <div class="card-title">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                </svg>
                Daftar Siswa
                @if ($mapelTerpilih && $kelasTerpilih)
                    <span style="font-size:13px; font-weight:500; color:#718096; margin-left:4px;">
                        — {{ $mapelTerpilih->nama_mapel }}
                        &bull; {{ $kelasTerpilih->nama_kelas }}
                    </span>
                @endif
            </div>

            @if ($selectedMapel && $selectedKelas)
                @if ($siswa->count() > 0)
                    <div class="stats-row">
                        <div class="stat-chip">
                            <span class="stat-num">{{ $siswa->count() }}</span>
                            &nbsp;Siswa ditemukan di kelas
                            <strong>{{ $kelasTerpilih->nama_kelas ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 48px;">No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th style="text-align:center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $index => $s)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td style="font-weight:600; color:#1a1a2e;">{{ $s->nama_siswa }}</td>
                                        <td>
                                            <span class="badge badge-blue">
                                                {{ $s->kelas->nama_kelas ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge badge-green">Aktif</span>
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('dashboard.student-detail', $s->id_siswa) }}?mapel_id={{ $selectedMapel }}&kelas_id={{ $selectedKelas }}"
                                               class="action-link">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="no-data">
                        <div class="no-data-icon">📭</div>
                        <p>Tidak ada siswa dalam kelas <strong>{{ $kelasTerpilih->nama_kelas ?? '' }}</strong>.</p>
                    </div>
                @endif
            @elseif ($selectedKelas && !$selectedMapel)
                <div class="no-data">
                    <div class="no-data-icon">📚</div>
                    <p>Silakan pilih <strong>mata pelajaran</strong> juga untuk melihat daftar siswa.</p>
                </div>
            @elseif ($selectedMapel && !$selectedKelas)
                <div class="no-data">
                    <div class="no-data-icon">🏫</div>
                    <p>Silakan pilih <strong>kelas</strong> juga untuk melihat daftar siswa.</p>
                </div>
            @else
                <div class="no-data">
                    <div class="no-data-icon">👆</div>
                    <p>Silakan pilih <strong>mata pelajaran</strong> dan <strong>kelas</strong> untuk melihat daftar siswa.</p>
                </div>
            @endif
        </div>

        <!-- Info Guru Card -->
        @if ($guru)
        <div class="card">
            <div class="card-title">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
                Informasi Guru
            </div>
            <div class="guru-info-row">
                <div class="guru-avatar">{{ strtoupper(substr($guru->nama_guru, 0, 1)) }}</div>
                <div class="guru-detail">
                    <h3>{{ $guru->nama_guru }}</h3>
                    <p>Guru &bull; E-Rapor PKBM</p>
                </div>
            </div>
            <div style="margin-top: 16px;">
                <p style="font-size:13px; font-weight:600; color:#2d3748; margin-bottom:8px;">Mata Pelajaran Diampu:</p>
                @if ($mataPelajaran->count() > 0)
                    <div class="guru-mapel-tags">
                        @foreach ($mataPelajaran as $m)
                            <span class="mapel-tag">{{ $m->nama_mapel }}</span>
                        @endforeach
                    </div>
                @else
                    <span class="mapel-tag-empty">Belum memilih mata pelajaran</span>
                @endif
            </div>
        </div>
        @endif

    </main>
</body>
</html>
