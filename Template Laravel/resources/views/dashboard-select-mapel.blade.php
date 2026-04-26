<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Mata Pelajaran — E-Rapor PKBM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fb;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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
            flex: 1;
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .card h2 {
            font-size: 24px;
            color: #1a1a2e;
            margin-bottom: 8px;
        }

        .card p {
            color: #4a5568;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 24px;
        }

        .form-group label {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 14px;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 12px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #4a6fa5;
        }

        .checkbox-item label {
            margin: 0;
            cursor: pointer;
            font-weight: 500;
            color: #1a1a2e;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #4a6fa5;
            color: #fff;
        }

        .btn-primary:hover {
            background: #3a5a90;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #1a1a2e;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
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
    </style>
</head>
<body>
    <div class="navbar">
        <h1>E-Rapor PKBM — Pilih Mata Pelajaran</h1>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="container">
        <div class="card">
            <h2>Pilih Mata Pelajaran yang Anda Ampu</h2>
            <p>Pilih satu atau lebih mata pelajaran untuk mengelola data siswa dan nilai.</p>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('dashboard.store-mapel') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Mata Pelajaran</label>
                    <div class="checkbox-group">
                        @forelse ($semuaMataPelajaran as $mapel)
                            <div class="checkbox-item">
                                <input 
                                    type="checkbox" 
                                    id="mapel_{{ $mapel->id_mapel }}"
                                    name="mata_pelajaran_ids[]" 
                                    value="{{ $mapel->id_mapel }}"
                                    {{ in_array($mapel->id_mapel, $mataPelajaranDiampu) ? 'checked' : '' }}
                                >
                                <label for="mapel_{{ $mapel->id_mapel }}">
                                    {{ $mapel->nama_mapel }}
                                </label>
                            </div>
                        @empty
                            <p style="color: #718096;">Tidak ada mata pelajaran tersedia.</p>
                        @endforelse
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Simpan Pilihan</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="text-decoration: none; display: inline-flex; align-items: center;">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
