<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rapor — E-Rapor PKBM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #a8b8cc; margin: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #eef2f6; border-right: 1px solid #d0d8e4; padding: 20px; }
        .main-content { flex: 1; padding: 40px; }
        .card { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; overflow-x: auto; }
        .btn { padding: 10px 15px; background: #4a6fa5; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; display: inline-block; white-space: nowrap; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        select { padding: 10px; border-radius: 5px; border: 1px solid #ccc; width: 300px;}
        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>E-Rapor Admin</h2>
        <a href="{{ route('admin.dashboard') }}" style="display:inline-flex; align-items:center; color:#4a6fa5; text-decoration:none; margin-bottom:16px; font-size:18px;" title="Kembali ke Admin Dashboard">&#8592;</a>
        <br>
        <a href="{{ route('rapor.index') }}" style="display:block; margin-bottom: 10px; color: #333; font-weight: bold;">Cetak Rapor</a>
        <a href="{{ route('rapor.arsip') }}" style="display:block; color: #333;">Arsip Rapor</a>
    </div>
    
    <div class="main-content">
        <h1>Cetak Rapor Siswa</h1>
        
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <form action="{{ route('rapor.index') }}" method="GET" id="filterForm">
                <label>Pilih Kelas:</label><br><br>
                <select name="kelas_id" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id_kelas }}" {{ $selectedKelas == $kelas->id_kelas ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if($selectedKelas)
        <div class="card">
            <h2>Daftar Siswa</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s->nama_siswa }}</td>
                        <td>
                            <form action="{{ route('rapor.generate', $s->id_siswa) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn">Generate & Arsipkan Rapor PDF</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3">Belum ada siswa di kelas ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif
    </div>
</body>
</html>
