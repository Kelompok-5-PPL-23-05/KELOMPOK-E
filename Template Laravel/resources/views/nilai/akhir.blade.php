<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Akhir — E-Rapor PKBM</title>
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
        .nav-item-single { display: flex; align-items: center; padding: 12px 20px; font-size: 14px; font-weight: 400; cursor: pointer; text-decoration: none; color: #000; border-bottom: 1px solid #9fb3ce; }
        .nav-item-single.active { background-color: #ccd6e4; font-weight: 600; }
        .sidebar-footer { padding: 30px 20px; margin-top: auto; }
        .logout-btn { background: none; border: none; font-size: 14px; font-weight: 400; color: #000; cursor: pointer; font-family: 'Poppins', sans-serif; text-align: left; margin-left: 20px; }

        .main-content { flex: 1; padding: 50px 30px; overflow-y: auto; }
        .page-title { font-size: 22px; font-weight: 700; margin-bottom: 8px; }
        .page-subtitle { font-size: 14px; color: #444; margin-bottom: 30px; }

        .filter-row { display: flex; gap: 24px; margin-bottom: 30px; align-items: flex-end; }
        .filter-group { display: flex; flex-direction: column; gap: 8px; }
        .filter-group label { font-size: 13px; font-weight: 600; color: #333; }
        .filter-select {
            appearance: none;
            background: #fff url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23000' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 12px center;
            background-size: 14px;
            border: none; border-radius: 8px; padding: 11px 40px 11px 16px;
            font-size: 14px; font-family: 'Poppins', sans-serif;
            min-width: 220px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            cursor: pointer; outline: none;
        }

        .table-wrapper { background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.06); margin-bottom: 30px; }
        .table-header { display: flex; justify-content: space-between; align-items: center; padding: 18px 24px; border-bottom: 1px solid #eee; }
        .table-title { font-size: 15px; font-weight: 700; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead th { background-color: #4a6fa5; color: #fff; padding: 13px 16px; text-align: left; font-size: 13px; font-weight: 600; }
        .data-table thead th:first-child { text-align: center; width: 50px; }
        .data-table tbody td { padding: 13px 16px; font-size: 13.5px; border-bottom: 1px solid #f0f0f0; }
        .data-table tbody td:first-child { text-align: center; color: #888; font-weight: 600; }
        .data-table tbody tr:hover { background-color: #f5f8fb; }
        .data-table tbody tr:last-child td { border-bottom: none; }

        .badge { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-green { background: #d4edda; color: #155724; }
        .badge-yellow { background: #fff3cd; color: #856404; }
        .badge-red { background: #f8d7da; color: #721c24; }

        .empty-state { text-align: center; padding: 50px 20px; color: #888; font-size: 14px; }

        .info-box { background: #fff; border-radius: 10px; padding: 20px 24px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); margin-bottom: 24px; font-size: 13.5px; color: #555; line-height: 1.8; }
        .info-box strong { color: #000; }
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
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" stroke-width="2"/></svg>
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
                <div class="nav-section-title" onclick="this.classList.toggle('open'); document.getElementById('c-mapel').classList.toggle('open');">
                    <svg class="arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg> Mata Pelajaran
                </div>
                <div class="nav-children" id="c-mapel">
                    <div class="nav-child-item">Pilih Mata Pelajaran</div>
                    <div class="nav-child-item">Kelola Siswa</div>
                </div>
            </div>
            <a href="{{ route('dashboard') }}" class="nav-item-single">Masukkan Nilai</a>
            <a href="{{ route('absensi.index') }}" class="nav-item-single">Absensi</a>
            <a href="{{ route('nilai.akhir') }}" class="nav-item-single active" style="border-bottom:none;">Nilai Akhir</a>
        </div>
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <h1 class="page-title">Nilai Akhir Siswa</h1>
        <p class="page-subtitle">Nilai akhir dihitung otomatis: UTS (30%) + UAS (30%) + Tugas (40%)</p>

        <div class="info-box">
            <strong>Cara kerja:</strong> Nilai akhir dihitung otomatis setelah guru menginput nilai UTS, UAS, dan Tugas untuk mata pelajaran yang sama. Formula: <strong>(UTS × 30%) + (UAS × 30%) + (Tugas × 40%)</strong>
        </div>

        <form method="GET" action="{{ route('nilai.akhir') }}">
            <div class="filter-row">
                <div class="filter-group">
                    <label>Pilih Kelas</label>
                    <select name="kelas_id" class="filter-select" onchange="this.form.submit()">
                        <option value="">— Pilih Kelas —</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id_kelas }}" {{ $selectedKelas == $kelas->id_kelas ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        @if($selectedKelas)
            @if($rapor->isEmpty())
                <div class="empty-state">
                    Belum ada nilai akhir untuk kelas ini. Pastikan semua jenis nilai (UTS, UAS, Tugas) sudah diinput.
                </div>
            @else
                @foreach($rapor as $siswaId => $raporSiswa)
                <div class="table-wrapper" style="margin-bottom: 24px;">
                    <div class="table-header">
                        <div class="table-title">{{ $raporSiswa->first()->siswa->nama_siswa ?? 'Siswa' }}</div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Nilai Akhir</th>
                                <th>Predikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($raporSiswa as $i => $r)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $r->mata_pelajaran }}</td>
                                <td><strong>{{ $r->nilai_akhir }}</strong></td>
                                <td>
                                    @if($r->nilai_akhir >= 85)
                                        <span class="badge badge-green">A — Sangat Baik</span>
                                    @elseif($r->nilai_akhir >= 70)
                                        <span class="badge badge-yellow">B — Baik</span>
                                    @else
                                        <span class="badge badge-red">C — Perlu Perbaikan</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            @endif
        @else
            <div class="empty-state">Pilih kelas untuk melihat nilai akhir siswa.</div>
        @endif
    </main>

</body>
</html>