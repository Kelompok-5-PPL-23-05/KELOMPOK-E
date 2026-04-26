<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa — E-Rapor PKBM</title>
    <meta name="description" content="Halaman detail siswa beserta nilai dan absensi.">
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
            width: 250px; min-height: 100vh; background-color: #eef2f6;
            display: flex; flex-direction: column; flex-shrink: 0;
            border-right: 1px solid #d0d8e4;
        }
        .sidebar-header { display: flex; align-items: center; gap: 16px; padding: 40px 24px 20px; }
        .hamburger-btn { background: none; border: none; cursor: pointer; display: flex; flex-direction: column; gap: 5px; padding: 0; }
        .hamburger-btn span { display: block; width: 24px; height: 3px; background: #000; border-radius: 3px; }
        .sidebar-brand { font-size: 20px; font-weight: 700; color: #000; }
        .sidebar-search { padding: 0 20px 16px; }
        .search-box { display: flex; align-items: center; justify-content: space-between; background: transparent; border: 1px solid #6c8bbf; border-radius: 20px; padding: 8px 16px; }
        .search-box input { border: none; background: transparent; outline: none; font-size: 13px; font-family: 'Poppins', sans-serif; color: #000; width: 100%; }
        .search-box input::placeholder { color: #333; }
        .search-box svg { width: 16px; height: 16px; color: #6c8bbf; flex-shrink: 0; }
        .nav-menu { flex: 1; padding: 0; border-top: 1px solid #9fb3ce; }
        .nav-section { border-bottom: 1px solid #9fb3ce; }
        .nav-section-title { display: flex; align-items: center; padding: 12px 20px; font-size: 14px; font-weight: 400; color: #000; cursor: pointer; }
        .nav-section-title .arrow { width: 16px; height: 16px; margin-right: 10px; transition: transform 0.2s ease; transform: rotate(-90deg); }
        .nav-section-title.open .arrow { transform: rotate(0deg); }
        .nav-children { display: none; padding-bottom: 12px; }
        .nav-children.open { display: block; }
        .nav-child-item { display: flex; align-items: center; justify-content: space-between; padding: 8px 20px 8px 40px; font-size: 13.5px; font-weight: 400; cursor: pointer; text-decoration: none; color: #000; }
        .nav-child-item.active { background-color: #ccd6e4; font-weight: 600; }
        .nav-item-single { display: flex; align-items: center; padding: 12px 20px; font-size: 14px; font-weight: 400; cursor: pointer; text-decoration: none; color: #000; border-bottom: 1px solid #9fb3ce; }
        .nav-item-single .arrow { width: 16px; height: 16px; margin-right: 10px; }
        .sidebar-footer { padding: 30px 20px; margin-top: auto; }
        .logout-btn { background: none; border: none; font-size: 14px; font-weight: 400; color: #000; cursor: pointer; font-family: 'Poppins', sans-serif; text-align: left; margin-left: 20px; }

        /* ════ MAIN CONTENT ════ */
        .main-content { flex: 1; padding: 40px 36px; overflow-y: auto; }

        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #718096; margin-bottom: 12px; }
        .breadcrumb a { color: #4a6fa5; text-decoration: none; font-weight: 500; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb span { color: #a0aec0; }

        .page-header { margin-bottom: 28px; }
        .page-header h1 { font-size: 26px; font-weight: 700; color: #1a1a2e; }
        .page-header p { font-size: 14px; color: #4a5568; margin-top: 4px; }

        .alert { display: flex; align-items: flex-start; gap: 12px; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 500; }
        .alert-success { background: #c6f6d5; color: #22543d; border-left: 4px solid #48bb78; }
        .alert-error { background: #fed7d7; color: #742a2a; border-left: 4px solid #fc8181; }

        /* Cards */
        .card { background: #fff; border-radius: 14px; padding: 28px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); margin-bottom: 24px; }
        .card-title { font-size: 16px; font-weight: 700; color: #1a1a2e; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .card-title svg { width: 20px; height: 20px; stroke: #4a6fa5; }

        /* Student Profile Card */
        .profile-card {
            background: linear-gradient(135deg, #4a6fa5 0%, #6c8bbf 100%);
            border-radius: 14px; padding: 28px;
            box-shadow: 0 8px 24px rgba(74,111,165,0.35);
            margin-bottom: 24px; color: #fff;
            display: flex; align-items: center; gap: 24px;
        }
        .profile-avatar {
            width: 80px; height: 80px; border-radius: 50%;
            background: rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; font-weight: 700; color: #fff;
            border: 3px solid rgba(255,255,255,0.5);
            flex-shrink: 0;
        }
        .profile-info h2 { font-size: 22px; font-weight: 700; }
        .profile-info p { font-size: 14px; opacity: 0.85; margin-top: 4px; }
        .profile-badges { display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap; }
        .profile-badge {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.4);
            border-radius: 20px; padding: 4px 14px;
            font-size: 12px; font-weight: 600; color: #fff;
        }

        /* Stats row */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #fff; border-radius: 12px; padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.07);
            text-align: center;
        }
        .stat-card .stat-value { font-size: 28px; font-weight: 700; color: #1a1a2e; }
        .stat-card .stat-label { font-size: 12px; color: #718096; margin-top: 4px; font-weight: 500; }
        .stat-card.hadir .stat-value { color: #38a169; }
        .stat-card.sakit .stat-value { color: #d69e2e; }
        .stat-card.izin  .stat-value  { color: #4a6fa5; }
        .stat-card.alfa  .stat-value  { color: #e53e3e; }

        /* Nilai table */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #f7fafc; border-bottom: 2px solid #e2e8f0; }
        th { padding: 12px 16px; text-align: left; font-weight: 600; color: #2d3748; font-size: 13px; text-transform: uppercase; letter-spacing: 0.04em; }
        td { padding: 14px 16px; border-bottom: 1px solid #edf2f7; font-size: 14px; color: #4a5568; }
        tbody tr { transition: background 0.15s; }
        tbody tr:hover { background: #f7fafc; }
        tbody tr:last-child td { border-bottom: none; }

        /* Nilai badge */
        .nilai-badge {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 52px; padding: 6px 14px; border-radius: 8px;
            font-size: 15px; font-weight: 700;
        }
        .nilai-a    { background: #c6f6d5; color: #22543d; }
        .nilai-b    { background: #bee3f8; color: #2c5282; }
        .nilai-c    { background: #fefcbf; color: #744210; }
        .nilai-d    { background: #fed7d7; color: #742a2a; }

        /* No data */
        .no-data { text-align: center; padding: 40px; color: #a0aec0; font-size: 14px; }
        .no-data-icon { font-size: 36px; margin-bottom: 10px; }

        /* Back + action btn */
        .action-row { display: flex; gap: 12px; align-items: center; margin-bottom: 28px; flex-wrap: wrap; }
        .btn {
            padding: 10px 22px; border-radius: 8px; border: none;
            font-size: 14px; font-weight: 600; font-family: 'Poppins', sans-serif;
            cursor: pointer; transition: all 0.2s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-back { background: #e2e8f0; color: #2d3748; }
        .btn-back:hover { background: #cbd5e0; transform: translateY(-1px); }
        .btn-primary {
            background: linear-gradient(135deg, #4a6fa5, #6c8bbf);
            color: #fff; box-shadow: 0 4px 12px rgba(74,111,165,0.3);
        }
        .btn-primary:hover { background: linear-gradient(135deg, #3a5a90, #5a7aaf); transform: translateY(-1px); }

        /* Divider */
        .divider { height: 1px; background: #e2e8f0; margin: 4px 0 20px; }

        /* Info highlight */
        .info-hint {
            background: #ebf8ff; border-left: 4px solid #4299e1;
            border-radius: 8px; padding: 11px 15px; font-size: 13px;
            color: #2b6cb0; margin-bottom: 18px;
        }
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
                        <a href="{{ route('dashboard.manage-students') }}?mapel_id={{ $m->id_mapel }}" class="nav-child-item" style="text-decoration:none; color:inherit;">
                            {{ $m->nama_mapel }}
                        </a>
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
            <a href="{{ route('dashboard.manage-students') }}{{ $selectedMapel ? '?mapel_id='.$selectedMapel.'&kelas_id='.$selectedKelas : '' }}">Kelola Siswa</a>
            <span>›</span>
            <span>{{ $siswa->nama_siswa }}</span>
        </div>

        @if (session('error'))
            <div class="alert alert-error">✗ {{ session('error') }}</div>
        @endif

        <div class="action-row">
            <a href="{{ route('dashboard.manage-students') }}{{ $selectedMapel ? '?mapel_id='.$selectedMapel.'&kelas_id='.$selectedKelas : '' }}" class="btn btn-back">
                ← Kembali ke Daftar Siswa
            </a>
        </div>

        <!-- Profile Card -->
        <div class="profile-card">
            <div class="profile-avatar">
                {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h2>{{ $siswa->nama_siswa }}</h2>
                <p>ID Siswa: #{{ $siswa->id_siswa }}</p>
                <div class="profile-badges">
                    <span class="profile-badge">📚 {{ $siswa->kelas->nama_kelas ?? 'Kelas N/A' }}</span>
                    <span class="profile-badge">✅ Aktif</span>
                    @if ($selectedMapel && $mataPelajaran->firstWhere('id_mapel', $selectedMapel))
                        <span class="profile-badge">🎯 {{ $mataPelajaran->firstWhere('id_mapel', $selectedMapel)->nama_mapel }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Absensi Stats -->
        <div class="card">
            <div class="card-title">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 9v7.5"/>
                </svg>
                Rekap Absensi
            </div>
            @if ($absensi)
                @php
                    $total = $absensi->hadir + $absensi->sakit + $absensi->izin + $absensi->alfa;
                    $persenHadir = $total > 0 ? round(($absensi->hadir / $total) * 100) : 0;
                @endphp
                <div class="stats-grid">
                    <div class="stat-card hadir">
                        <div class="stat-value">{{ $absensi->hadir }}</div>
                        <div class="stat-label">Hadir</div>
                    </div>
                    <div class="stat-card sakit">
                        <div class="stat-value">{{ $absensi->sakit }}</div>
                        <div class="stat-label">Sakit</div>
                    </div>
                    <div class="stat-card izin">
                        <div class="stat-value">{{ $absensi->izin }}</div>
                        <div class="stat-label">Izin</div>
                    </div>
                    <div class="stat-card alfa">
                        <div class="stat-value">{{ $absensi->alfa }}</div>
                        <div class="stat-label">Alfa</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" style="color:#4a6fa5;">{{ $persenHadir }}%</div>
                        <div class="stat-label">Kehadiran</div>
                    </div>
                </div>
            @else
                <div class="no-data">
                    <div class="no-data-icon">📋</div>
                    <p>Belum ada data absensi untuk siswa ini.</p>
                </div>
            @endif
        </div>

        <!-- Nilai Akademik -->
        <div class="card">
            <div class="card-title">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75"/>
                </svg>
                Nilai Akademik
                @if ($nilaiList->count() > 0)
                    <span style="font-size:13px; font-weight:500; color:#718096; margin-left:4px;">
                        ({{ $nilaiList->count() }} mata pelajaran)
                    </span>
                @endif
            </div>

            @if ($nilaiList->count() > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:40px;">No</th>
                                <th>Mata Pelajaran</th>
                                <th style="text-align:center;">Nilai</th>
                                <th style="text-align:center;">Predikat</th>
                                <th>Deskripsi / Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nilaiList as $i => $nilai)
                                @php
                                    $n = $nilai->nilai_angka;
                                    if ($n >= 90)      { $predikat = 'A'; $cls = 'nilai-a'; }
                                    elseif ($n >= 75)  { $predikat = 'B'; $cls = 'nilai-b'; }
                                    elseif ($n >= 60)  { $predikat = 'C'; $cls = 'nilai-c'; }
                                    else               { $predikat = 'D'; $cls = 'nilai-d'; }
                                @endphp
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td style="font-weight:600; color:#1a1a2e;">
                                        {{ $nilai->mataPelajaran->nama_mapel ?? 'N/A' }}
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="nilai-badge {{ $cls }}">{{ $n }}</span>
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="nilai-badge {{ $cls }}" style="min-width:36px;">{{ $predikat }}</span>
                                    </td>
                                    <td style="color:#718096; font-size:13px;">
                                        {{ $nilai->deskripsi ?? '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="info-hint">
                    💡 Belum ada nilai yang dimasukkan untuk siswa ini pada mata pelajaran yang Anda ampu.
                </div>
                <div class="no-data">
                    <div class="no-data-icon">📝</div>
                    <p>Belum ada data nilai.</p>
                </div>
            @endif
        </div>

    </main>

</body>
</html>
