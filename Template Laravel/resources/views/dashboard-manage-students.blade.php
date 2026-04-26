<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Siswa — E-Rapor PKBM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            min-height: 100vh;
        }

        .navbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        .navbar h1 {
            font-size: 18px;
            color: #1a1a2e;
        }

        .logout-btn {
            background: #e53e3e;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: #c53030;
        }

        .container {
            max-width: 1200px;
            margin: 32px auto;
            padding: 0 20px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 24px;
        }

        .card h2 {
            font-size: 20px;
            color: #1a1a2e;
            margin-bottom: 20px;
        }

        .filter-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 14px;
        }

        .form-group select {
            padding: 10px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            align-self: flex-end;
        }

        .btn-primary {
            background: #4a6fa5;
            color: #fff;
        }

        .btn-primary:hover {
            background: #3a5a90;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        table thead tr {
            background: #f7fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        table th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #1a1a2e;
            font-size: 14px;
        }

        table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
            font-size: 14px;
        }

        table tbody tr:hover {
            background: #f9fafb;
        }

        .no-data {
            text-align: center;
            padding: 32px;
            color: #718096;
        }

        .info-box {
            background: #e6fffa;
            border-left: 4px solid #38b2ac;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 14px;
            color: #234e52;
            margin-bottom: 16px;
        }

        .back-link {
            color: #4a6fa5;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 16px;
            display: inline-block;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-primary {
            background: #bee3f8;
            color: #2c5282;
        }

        .badge-secondary {
            background: #fed7d7;
            color: #742a2a;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>E-Rapor PKBM — Kelola Data Siswa</h1>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="container">
        <a href="{{ route('dashboard') }}" class="back-link">← Kembali ke Dashboard</a>

        @if (session('success'))
            <div class="info-box" style="background: #c6f6d5; border-left-color: #48bb78; color: #22543d;">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="info-box" style="background: #fed7d7; border-left-color: #fc8181; color: #742a2a;">
                ✗ {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <h2>Data Siswa Berdasarkan Mata Pelajaran</h2>

            <form action="{{ route('dashboard.manage-students') }}" method="GET">
                <div class="filter-group">
                    <div class="form-group">
                        <label for="mapel_id">Mata Pelajaran <span style="color: #e53e3e;">*</span></label>
                        <select id="mapel_id" name="mapel_id" required onchange="this.form.submit()">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @forelse ($mataPelajaran as $mapel)
                                <option value="{{ $mapel->id_mapel }}" {{ $selectedMapel == $mapel->id_mapel ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @empty
                                <option value="">Tidak ada mata pelajaran</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kelas_id">Kelas <span style="color: #e53e3e;">*</span></label>
                        <select id="kelas_id" name="kelas_id" required onchange="this.form.submit()">
                            <option value="">-- Pilih Kelas --</option>
                            @forelse ($kelas as $k)
                                <option value="{{ $k->id_kelas }}" {{ $selectedKelas == $k->id_kelas ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @empty
                                <option value="">Tidak ada kelas</option>
                            @endforelse
                        </select>
                    </div>
                </div>
            </form>

            @if ($selectedMapel && $selectedKelas)
                <div class="info-box">
                    📚 Menampilkan siswa untuk mata pelajaran dan kelas yang dipilih. Anda dapat mengelola nilai, absensi, dan data lainnya dari sini.
                </div>

                @if (count($siswa) > 0)
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $index => $s)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $s->nama_siswa }}</td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ $s->kelas->nama_kelas ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" style="color: #4a6fa5; text-decoration: none; font-weight: 500;">
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
                        <p>📭 Tidak ada siswa dalam kelas yang dipilih.</p>
                    </div>
                @endif
            @else
                <div class="no-data">
                    <p>👆 Silakan pilih mata pelajaran dan kelas untuk melihat daftar siswa.</p>
                </div>
            @endif
        </div>

        <div class="card">
            <h2>📋 Informasi Guru</h2>
            <table style="width: 100%;">
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="width: 150px; padding: 12px 0; font-weight: 600; color: #1a1a2e;">Nama Guru:</td>
                    <td style="padding: 12px 0; color: #4a5568;">{{ $guru->nama_guru ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="width: 150px; padding: 12px 0; font-weight: 600; color: #1a1a2e;">Mata Pelajaran Diampu:</td>
                    <td style="padding: 12px 0; color: #4a5568;">
                        @if ($mataPelajaran->count() > 0)
                            {{ $mataPelajaran->pluck('nama_mapel')->join(', ') }}
                        @else
                            <span style="color: #718096;">Belum memilih mata pelajaran</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
