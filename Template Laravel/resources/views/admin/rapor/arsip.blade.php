<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Rapor — E-Rapor PKBM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #a8b8cc; margin: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #eef2f6; border-right: 1px solid #d0d8e4; padding: 20px; }
        .main-content { flex: 1; padding: 40px; }
        .card { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; overflow-x: auto; }
        .btn { padding: 10px 15px; background: #4a6fa5; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; display: inline-block; white-space: nowrap; text-align: center; }
        .btn-success { background: #28a745; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>E-Rapor Admin</h2>
        <a href="{{ route('admin.dashboard') }}" style="display:inline-block; margin-bottom: 20px; color: #000; font-size: 24px; text-decoration: none; font-weight: bold;" title="Kembali ke Dashboard">&larr;</a>
        <br>
        <a href="{{ route('rapor.index') }}" style="display:block; margin-bottom: 10px; color: #333; text-decoration: none;">Cetak Rapor</a>
        <a href="{{ route('rapor.arsip') }}" style="display:block; color: #333; font-weight: bold; text-decoration: none;">Arsip Rapor</a>
    </div>
    
    <div class="main-content">
        <h1>Arsip Rapor PDF</h1>
        
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Generate</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Nilai Akhir Rata-rata</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rapors as $index => $rapor)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $rapor->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $rapor->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $rapor->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $rapor->nilai_akhir }}</td>
                        <td>
                            <a href="{{ route('rapor.download', $rapor->id_rapor) }}" class="btn btn-success" target="_blank">Download PDF</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align: center;">Belum ada arsip rapor.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
