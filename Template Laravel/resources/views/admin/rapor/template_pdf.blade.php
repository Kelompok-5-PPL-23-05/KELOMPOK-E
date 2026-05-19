<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor {{ $siswa->nama_siswa }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .page-break { page-break-after: always; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        
        /* Cover Styles */
        .cover-title { font-size: 18px; font-weight: bold; margin: 40px 0; text-align: center;}
        .cover-box { border: 2px solid #000; padding: 10px; text-align: center; font-weight: bold; font-size: 14px; margin: 0 auto; width: 60%; }
        .cover-label { font-weight: bold; margin-top: 30px; text-align: center;}
        
        /* Tables */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; vertical-align: top; }
        .no-border, .no-border th, .no-border td { border: none; padding: 4px; }
        .w-10 { width: 10%; }
        .w-30 { width: 30%; }
        .w-60 { width: 60%; }
        
        /* Layout */
        .header-info { margin-bottom: 20px; }
        .header-info td { border: none; padding: 2px; }
        
        .signature-table td { border: none; text-align: center; padding-top: 50px; }
    </style>
</head>
<body>

    <!-- PAGE 1: COVER -->
    <div class="center" style="margin-top: 50px;">
        <!-- Logo Tut Wuri Handayani (Pastikan gambar ada di public/images/tutwuri.png) -->
        @if(file_exists(public_path('images/tutwuri.png')))
            <img src="{{ public_path('images/tutwuri.png') }}" alt="Tut Wuri Handayani" style="width: 150px; margin-bottom: 20px;">
        @else
            <div style="border:1px dashed #000; width:150px; height:150px; line-height:150px; margin: 0 auto 20px;">[Logo Tut Wuri]</div>
        @endif

        <h1 class="cover-title">LAPORAN HASIL BELAJAR PESERTA DIDIK<br>PROGRAM {{ strtoupper($siswa->kelas->nama_kelas) }} SETARA SMP</h1>
        
        <br><br>

        <!-- Logo PKBM Almeera (Pastikan gambar ada di public/images/almeera.png) -->
        @if(file_exists(public_path('images/almeera.png')))
            <img src="{{ public_path('images/almeera.png') }}" alt="Logo PKBM Almeera" style="width: 150px; margin-bottom: 20px;">
        @else
            <div style="border:1px dashed #000; width:150px; height:150px; line-height:150px; margin: 0 auto 20px;">[Logo PKBM Almeera]</div>
        @endif
        
        <div class="cover-label">NAMA PESERTA DIDIK</div>
        <div class="cover-box">{{ strtoupper($siswa->nama_siswa) }}</div>
        
        <div class="cover-label">NISN/NIS</div>
        <div class="cover-box">3082604940 / 0</div>
        
        <br><br><br><br><br><br>
        
        <h2>PKBM ALMEERA</h2>
        <p>Alamat: Jalan H.Kimah Rangkapan Jaya Baru<br>
        Email : pkbmalmeera@gmail.com, Kode Pos 16434</p>
    </div>

    <div class="page-break"></div>

    <!-- PAGE 2: IDENTITAS SEKOLAH -->
    <div class="center">
        <h2>IDENTITAS SEKOLAH</h2>
    </div>
    <br><br>
    <table class="no-border" style="width: 80%; margin: 0 auto;">
        <tr><td class="w-30">Nama Satuan Pendidikan</td><td>: PKBM ALMEERA</td></tr>
        <tr><td>NPSN</td><td>: P2970672</td></tr>
        <tr><td>Alamat</td><td>: Jl. H.Kimah Rangkapan Jaya Baru</td></tr>
        <tr><td>Kode Pos</td><td>: 16434</td></tr>
        <tr><td>Website</td><td>: -</td></tr>
        <tr><td>Email</td><td>: pkbmalmeera@gmail.com</td></tr>
        <tr><td>Telepon</td><td>: 085385252606</td></tr>
    </table>

    <div class="page-break"></div>

    <!-- PAGE 3: NILAI -->
    <table class="no-border header-info">
        <tr>
            <td class="w-30">Nama Satuan Pendidikan</td><td>: PKBM ALMEERA</td>
            <td class="w-10">Fase</td><td>: B</td>
        </tr>
        <tr>
            <td>Alamat</td><td>: Jl. H.Kimah Rangkapan Jaya Baru</td>
            <td>Kelas</td><td>: {{ explode(' ', $siswa->kelas->nama_kelas)[2] ?? '7' }}</td>
        </tr>
        <tr>
            <td>Nama Peserta Didik</td><td>: <b>{{ strtoupper($siswa->nama_siswa) }}</b></td>
            <td>Semester</td><td>: {{ $semester }}</td>
        </tr>
        <tr>
            <td>NISN</td><td>: 3082604940</td>
            <td>Tahun Pelajaran</td><td>: {{ $tahun_pelajaran }}</td>
        </tr>
        <tr>
            <td>NIS</td><td>: 0</td>
            <td></td><td></td>
        </tr>
    </table>

    <p class="bold">A. Lembar Isi Mata Pelajaran</p>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 30%; text-align: center;">Mata Pelajaran/Muatan Pemberdayaan dan Keterampilan</th>
                <th style="width: 10%; text-align: center;">Nilai Akhir</th>
                <th style="width: 55%; text-align: center;">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4" class="bold">Kelompok Mata Pelajaran Umum</td>
            </tr>
            @foreach($nilaiList as $index => $nilai)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $nilai->mataPelajaran->nama_mapel ?? 'Mata Pelajaran' }}</td>
                <td class="center">{{ $nilai->nilai_angka }}</td>
                <td>Murid menunjukkan pemahaman dalam materi ini. {{ $nilai->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="page-break"></div>

    <p class="bold">Muatan Pemberdayaan dan Keterampilan Berbasis Profil Pelajar Pancasila</p>
    <table>
        <tr>
            <td class="center w-10">1</td>
            <td class="w-30">Pemberdayaan</td>
            <td class="center w-10">80</td>
            <td>Murid menunjukkan pemahaman dalam memahami identitas diri secara rasional.</td>
        </tr>
        <tr>
            <td class="center w-10">2</td>
            <td>Keterampilan</td>
            <td class="center w-10">80</td>
            <td>Murid menunjukkan pemahaman dalam menerapkan pembuatan dan editing sederhana.</td>
        </tr>
    </table>

    <br>
    <table>
        <thead>
            <tr>
                <th class="w-10 center">No</th>
                <th class="w-30 center">Kegiatan Ekstrakurikuler</th>
                <th class="w-10 center">Predikat</th>
                <th class="w-50 center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr><td class="center">1</td><td>BTQ</td><td class="center">84</td><td></td></tr>
            <tr><td class="center">2</td><td></td><td class="center"></td><td></td></tr>
        </tbody>
    </table>

    <br>
    <div style="width: 50%;">
        <table>
            <tr><th colspan="3" class="center">Ketidakhadiran</th></tr>
            <tr><td class="w-30">Izin</td><td class="w-10 center">:</td><td>{{ $absensi->izin ?? 0 }} hari</td></tr>
            <tr><td>Sakit</td><td class="center">:</td><td>{{ $absensi->sakit ?? 0 }} hari</td></tr>
            <tr><td>Alpa</td><td class="center">:</td><td>{{ $absensi->alpa ?? 0 }} hari</td></tr>
        </table>
    </div>

    <br><br>
    <table class="signature-table">
        <tr>
            <td style="width: 50%;">
                Orang Tua Peserta Didik/Wali
                <br><br><br><br><br>
                ..................................................
            </td>
            <td style="width: 50%;">
                Depok, {{ date('d F Y') }}<br>
                Wali Kelas
                <br><br><br><br><br>
                <b>Ahmad Zidan, S. Pd., Gr.</b>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 30px;">
                Mengetahui<br>
                Kepala PKBM ALMEERA
                <br><br><br><br><br>
                <b><u>SUHYANA, M.Pd</u></b><br>
                NIP.
            </td>
        </tr>
    </table>

</body>
</html>
