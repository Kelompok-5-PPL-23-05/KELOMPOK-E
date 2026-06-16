<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Nilai Siswa — E-Rapor PKBM</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Poppins', sans-serif; background-color: #a8b8cc; min-height: 100vh; display: flex; color: #000; }

    /* ════════ SIDEBAR ════════ */
    .sidebar { width: 250px; min-height: 100vh; background-color: #eef2f6; display: flex; flex-direction: column; flex-shrink: 0; border-right: 1px solid #d0d8e4; }
    .sidebar-header { display: flex; align-items: center; gap: 16px; padding: 40px 24px 20px; }
    .sidebar-brand { font-size: 20px; font-weight: 700; }
    .nav-menu { flex: 1; border-top: 1px solid #9fb3ce; }
    .nav-item-single { display: flex; align-items: center; padding: 12px 20px; font-size: 14px; font-weight: 400; text-decoration: none; color: #000; border-bottom: 1px solid #9fb3ce; }
    .nav-item-single.active { background-color: #ccd6e4; }
    .sidebar-footer { padding: 30px 20px; margin-top: auto; }
    .logout-btn { background: none; border: none; font-size: 14px; color: #000; cursor: pointer; font-family: 'Poppins', sans-serif; margin-left: 20px; }

    /* ════════ MAIN CONTENT ════════ */
    .main-content { flex: 1; padding: 50px 40px; overflow-y: auto; }

    .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; margin-bottom: 28px; }
    .breadcrumb a { color: #4a6fa5; text-decoration: none; font-weight: 500; }
    .breadcrumb a:hover { text-decoration: underline; }
    .breadcrumb-sep { color: #aaa; }

    .page-title { font-size: 22px; font-weight: 700; color: #1a2a3a; margin-bottom: 6px; }
    .page-subtitle { font-size: 13px; color: #666; margin-bottom: 32px; }

    .alert { border-radius: 8px; padding: 14px 20px; margin-bottom: 24px; font-size: 14px; font-weight: 500; }
    .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    /* [PPLE-58] Info card data nilai lama */
    .info-card { background: #fff; border-radius: 12px; padding: 20px 24px; margin-bottom: 28px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); border-left: 4px solid #4a6fa5; }
    .info-card-title { font-size: 12px; font-weight: 600; color: #4a6fa5; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px; }
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; }
    .info-item label { display: block; font-size: 11px; font-weight: 500; color: #888; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px; }
    .info-item .info-value { font-size: 14px; font-weight: 600; color: #1a2a3a; }
    .badge-nilai { display: inline-block; background: #4a6fa5; color: #fff; padding: 2px 12px; border-radius: 20px; font-size: 14px; font-weight: 700; }

    /* [PPLE-59] Form card */
    .form-card { background: #fff; border-radius: 12px; padding: 28px 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
    .form-card-title { font-size: 15px; font-weight: 700; color: #1a2a3a; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 1px solid #e8edf2; }
    .form-group { margin-bottom: 22px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #2c3e50; margin-bottom: 8px; }
    .form-group label .required { color: #e53e3e; margin-left: 2px; }
    .form-input { width: 100%; height: 46px; background-color: #f8fafc; border: 1.5px solid #d1dae4; border-radius: 8px; padding: 0 16px; font-size: 14px; font-family: 'Poppins', sans-serif; color: #1a2a3a; outline: none; transition: border-color 0.2s, box-shadow 0.2s; }
    .form-input:focus { border-color: #4a6fa5; box-shadow: 0 0 0 3px rgba(74,111,165,0.12); background-color: #fff; }

    /* [PPLE-60] Error state */
    .form-input.is-invalid { border-color: #e53e3e; box-shadow: 0 0 0 3px rgba(229,62,62,0.1); }
    .error-msg { margin-top: 6px; font-size: 12px; color: #e53e3e; font-weight: 500; }
    .nilai-hint { margin-top: 6px; font-size: 11px; color: #888; }
    textarea.form-input { height: 90px; padding: 12px 16px; resize: vertical; }

    .action-row { display: flex; justify-content: flex-end; gap: 12px; margin-top: 28px; padding-top: 20px; border-top: 1px solid #e8edf2; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 28px; border-radius: 8px; font-size: 14px; font-weight: 600; font-family: 'Poppins', sans-serif; cursor: pointer; transition: transform 0.1s; border: none; text-decoration: none; }
    .btn:active { transform: scale(0.98); }
    .btn-cancel { background-color: #eef2f6; color: #4a5568; border: 1.5px solid #d1dae4; }
    .btn-cancel:hover { background-color: #e2e8f0; }
    .btn-save { background-color: #4a6fa5; color: #fff; box-shadow: 0 4px 12px rgba(74,111,165,0.3); }
    .btn-save:hover { background-color: #3a5d91; }
  </style>
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-header">
    <span class="sidebar-brand">E-Rapor</span>
  </div>
  <div class="nav-menu">
    <a href="{{ route('dashboard') }}" class="nav-item-single active">Masukkan Nilai</a>
    <a href="{{ route('absensi.index') }}" class="nav-item-single">Absensi</a>
  </div>
  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="logout-btn">Keluar</button>
    </form>
  </div>
</aside>

<main class="main-content">

  <nav class="breadcrumb">
    <a href="{{ route('dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">›</span>
    <span>Edit Nilai Siswa</span>
  </nav>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-error">
      @foreach($errors->all() as $error){{ $error }}<br>@endforeach
    </div>
  @endif

  <h1 class="page-title">Edit Nilai Siswa</h1>
  <p class="page-subtitle">Perbaiki nilai siswa yang telah diinput sebelumnya.</p>

  {{-- [PPLE-58] Info card: tampilkan data nilai yang sudah ada --}}
  <div class="info-card">
    <div class="info-card-title">📋 Data Nilai Saat Ini</div>
    <div class="info-grid">
      <div class="info-item">
        <label>Nama Siswa</label>
        <div class="info-value">{{ $nilai->siswa->nama_siswa ?? '-' }}</div>
      </div>
      <div class="info-item">
        <label>Kelas</label>
        <div class="info-value">{{ $nilai->siswa->kelas->nama_kelas ?? '-' }}</div>
      </div>
      <div class="info-item">
        <label>Mata Pelajaran</label>
        <div class="info-value">{{ $nilai->mataPelajaran->nama_mapel ?? '-' }}</div>
      </div>
      <div class="info-item">
        <label>Nilai Sebelumnya</label>
        <div class="info-value">
          <span class="badge-nilai">{{ $nilai->nilai_angka }}</span>
        </div>
      </div>
    </div>
  </div>

  {{-- [PPLE-59] Form edit nilai --}}
  <div class="form-card">
    <div class="form-card-title">✏️ Ubah Nilai</div>

    {{-- [PPLE-61] Method PUT ke route nilai.update --}}
    <form id="form-edit-nilai" action="{{ route('nilai.update', $nilai->id_nilai) }}" method="POST" novalidate>
      @csrf
      @method('PUT')

      {{-- [PPLE-58] Pre-filled nilai lama (nilai_angka) --}}
      <div class="form-group">
        <label for="nilai_angka">Nilai Baru <span class="required">*</span></label>
        <input
          id="nilai_angka"
          type="number"
          name="nilai_angka"
          class="form-input {{ $errors->has('nilai_angka') ? 'is-invalid' : '' }}"
          value="{{ old('nilai_angka', $nilai->nilai_angka) }}"
          min="1" max="100" step="1"
          placeholder="Masukkan nilai (1 – 100)"
          oninput="batasNilai(this)"
          required
        >
        {{-- [PPLE-60] Tampilkan error validasi --}}
        @error('nilai_angka')
          <div class="error-msg">⚠ {{ $message }}</div>
        @enderror
        <div class="nilai-hint">Nilai harus berupa bilangan bulat antara 1 dan 100.</div>
      </div>

      {{-- [PPLE-58] Pre-filled deskripsi/catatan lama --}}
      <div class="form-group">
        <label for="deskripsi">Deskripsi / Catatan</label>
        <textarea
          id="deskripsi"
          name="deskripsi"
          class="form-input {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
          placeholder="Deskripsi tambahan (opsional)"
        >{{ old('deskripsi', $nilai->deskripsi) }}</textarea>
        @error('deskripsi')
          <div class="error-msg">⚠ {{ $message }}</div>
        @enderror
      </div>

      <div class="action-row">
        <a href="{{ route('dashboard') }}" class="btn btn-cancel">✕ Batal</a>
        {{-- [PPLE-61] Tombol simpan --}}
        <button type="submit" id="btn-simpan" class="btn btn-save">✓ Simpan Perubahan</button>
      </div>
    </form>
  </div>

</main>

<script>
  // [PPLE-60] Batasi input 1–100
  function batasNilai(input) {
    if (input.value > 100) input.value = 100;
    if (input.value < 1 && input.value !== '') input.value = 1;
  }

  // [PPLE-60] Validasi client-side sebelum submit
  document.getElementById('form-edit-nilai').addEventListener('submit', function(e) {
    const nilaiInput = document.getElementById('nilai_angka');
    const val = parseInt(nilaiInput.value);
    if (!nilaiInput.value || isNaN(val) || val < 1 || val > 100) {
      e.preventDefault();
      nilaiInput.classList.add('is-invalid');
      nilaiInput.focus();
      if (!nilaiInput.parentElement.querySelector('.error-msg')) {
        const err = document.createElement('div');
        err.className = 'error-msg';
        err.textContent = '⚠ Nilai wajib diisi dan harus berupa angka antara 1 dan 100.';
        nilaiInput.insertAdjacentElement('afterend', err);
      }
    } else {
      nilaiInput.classList.remove('is-invalid');
    }
  });
</script>

</body>
</html>
