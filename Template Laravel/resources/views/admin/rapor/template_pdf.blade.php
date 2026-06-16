<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor {{ $siswa->nama_siswa }}</title>
    <style>
        @page { size: A4 portrait; margin: 15mm; }
        body { font-family: sans-serif; font-size: 12px; color: #000; }
        .page-break { page-break-after: always; }
        .center { text-align: center; }
        .bold { font-weight: bold; }

        /* Cover Styles */
        .cover-title { font-size: 18px; font-weight: bold; margin: 40px 0; text-align: center; }
        .cover-box { border: 2px solid #000; padding: 10px; text-align: center; font-weight: bold; font-size: 14px; margin: 0 auto; width: 60%; }
        .cover-label { font-weight: bold; margin-top: 30px; text-align: center; }

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

        /* Keterangan Diri Peserta Didik — semua teks hitam */
        .kd-table { width: 85%; margin: 0 auto; }
        .kd-table, .kd-table td { border: none; }
        .kd-table td { padding: 5px 4px; vertical-align: top; color: #000; }
        .kd-no  { width: 30px; text-align: right; padding-right: 8px; }
        .kd-label { width: 185px; }
        .kd-sep { width: 20px; text-align: center; }
        .kd-val { font-weight: bold; }
        .kd-sub { padding-left: 20px; }
    </style>
</head>
<body>

    <!-- PAGE 1: COVER -->
    <div class="center" style="margin-top: 50px;">
        @if(file_exists(public_path('images/tutwuri.png')))
            <img src="{{ public_path('images/tutwuri.png') }}" alt="Tut Wuri Handayani" style="width: 150px; margin-bottom: 20px;">
        @else
            <div style="border:1px dashed #000; width:150px; height:150px; line-height:150px; margin: 0 auto 20px;">[Logo Tut Wuri]</div>
        @endif

        <h1 class="cover-title">LAPORAN HASIL BELAJAR PESERTA DIDIK<br>PROGRAM {{ strtoupper($siswa->kelas->nama_kelas ?? '') }} SETARA SMP</h1>

        <br><br>

        @if(file_exists(public_path('images/almeera.png')))
            <img src="{{ public_path('images/almeera.png') }}" alt="Logo PKBM Almeera" style="width: 150px; margin-bottom: 20px;">
        @else
            <div style="border:1px dashed #000; width:150px; height:150px; line-height:150px; margin: 0 auto 20px;">[Logo PKBM Almeera]</div>
        @endif

        <div class="cover-label">NAMA PESERTA DIDIK</div>
        <div class="cover-box">{{ strtoupper($siswa->nama_siswa) }}</div>

        <div class="cover-label">NISN/NIS</div>
        <div class="cover-box">{{ $siswa->nisn ?? '-' }} / {{ $siswa->nis ?? '-' }}</div>

        <br><br><br><br><br><br>

        <h2>{{ strtoupper($lembaga->nama_lembaga ?? 'PKBM ALMEERA') }}</h2>
        <p style="color:#000;">Alamat: {{ $lembaga->alamat ?? 'Jalan H.Kimah Rangkapan Jaya Baru' }}<br>
        Email : {{ $lembaga->email ?? 'pkbmalmeera@gmail.com' }}, Telp: {{ $lembaga->no_telepon ?? '-' }}</p>
    </div>

    <div class="page-break"></div>

    <!-- PAGE 2: IDENTITAS SEKOLAH -->
    <div class="center">
        <h2>IDENTITAS SEKOLAH</h2>
    </div>
    <br><br>
    <table class="no-border" style="width: 80%; margin: 0 auto;">
        <tr><td class="w-30">Nama Satuan Pendidikan</td><td>: {{ strtoupper($lembaga->nama_lembaga ?? 'PKBM ALMEERA') }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $lembaga->alamat ?? '-' }}</td></tr>
        <tr><td>Website</td><td>: -</td></tr>
        <tr><td>Email</td><td>: {{ $lembaga->email ?? '-' }}</td></tr>
        <tr><td>Telepon</td><td>: {{ $lembaga->no_telepon ?? '-' }}</td></tr>
    </table>

    <div class="page-break"></div>

    <!-- PAGE 3: KETERANGAN DIRI PESERTA DIDIK -->
    <div class="center" style="margin-bottom: 20px;">
        <h2 style="color: #000;">KETERANGAN DIRI TENTANG PESERTA DIDIK</h2>
    </div>

    <table class="kd-table">
        <tr>
            <td class="kd-no">1</td>
            <td class="kd-label">Nama Peserta Didik</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ strtoupper($siswa->nama_siswa) }}</td>
        </tr>
        <tr>
            <td class="kd-no">2</td>
            <td class="kd-label">NISN/NIS</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->nisn ?? '-' }} / {{ $siswa->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no">3</td>
            <td class="kd-label">Tempat, Tanggal Lahir</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->tempat_lahir ? strtoupper($siswa->tempat_lahir) : '-' }}{{ $siswa->tanggal_lahir ? ', ' . $siswa->tanggal_lahir->format('d-m-Y') : '' }}</td>
        </tr>
        <tr>
            <td class="kd-no">4</td>
            <td class="kd-label">Jenis Kelamin</td>
            <td class="kd-sep"></td>
            <td class="kd-val">
                @if($siswa->jenis_kelamin === 'L') Laki-laki
                @elseif($siswa->jenis_kelamin === 'P') Perempuan
                @else -
                @endif
            </td>
        </tr>
        <tr>
            <td class="kd-no">5</td>
            <td class="kd-label">Agama</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->agama ? strtoupper($siswa->agama) : '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no">6</td>
            <td class="kd-label">Anak ke</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->anak_ke ?? '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no">7</td>
            <td class="kd-label">Telepon</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->telepon ?? '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no">8</td>
            <td class="kd-label">Alamat Peserta Didik</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->alamat ? strtoupper($siswa->alamat) : '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no">9</td>
            <td class="kd-label">Nomor Gawai</td>
            <td class="kd-sep"></td>
            <td class="kd-val">{{ $siswa->nomor_gawai ?? '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no">10</td>
            <td class="kd-label">Diterima di sekolah ini</td>
            <td class="kd-sep"></td>
            <td class="kd-val"></td>
        </tr>
        <tr>
            <td class="kd-no"></td>
            <td class="kd-sub">di Kelas</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->kelas_masuk ?? (explode(' ', $siswa->kelas->nama_kelas)[2] ?? '-') }}</td>
        </tr>
        <tr>
            <td class="kd-no"></td>
            <td class="kd-sub">pada tanggal</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->tanggal_masuk ? $siswa->tanggal_masuk->format('d-m-Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no"></td>
            <td class="kd-sub">sebagai</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->sebagai ?? '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no">11</td>
            <td class="kd-label">Nama Orang Tua</td>
            <td class="kd-sep"></td>
            <td class="kd-val"></td>
        </tr>
        <tr>
            <td class="kd-no"></td>
            <td class="kd-sub">a. Ayah</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->nama_ayah ? strtoupper($siswa->nama_ayah) : '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no"></td>
            <td class="kd-sub">b. Ibu</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->nama_ibu ? strtoupper($siswa->nama_ibu) : '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no">12</td>
            <td class="kd-label">Pekerjaan Orang Tua</td>
            <td class="kd-sep"></td>
            <td class="kd-val"></td>
        </tr>
        <tr>
            <td class="kd-no"></td>
            <td class="kd-sub">a. Ayah</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->pekerjaan_ayah ? strtoupper($siswa->pekerjaan_ayah) : '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no"></td>
            <td class="kd-sub">b. Ibu</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->pekerjaan_ibu ? strtoupper($siswa->pekerjaan_ibu) : '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no">13</td>
            <td class="kd-label">Nama Wali Peserta Didik</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->nama_wali ? strtoupper($siswa->nama_wali) : '-' }}</td>
        </tr>
        <tr>
            <td class="kd-no">14</td>
            <td class="kd-label">Pekerjaan Wali Peserta Didik</td>
            <td class="kd-sep">:</td>
            <td class="kd-val">{{ $siswa->pekerjaan_wali ? strtoupper($siswa->pekerjaan_wali) : '-' }}</td>
        </tr>
    </table>

    <!-- Foto & TTD sejajar -->
    <br><br>
    <table style="border: none; width: 85%; margin: 0 auto;">
        <tr>
            <td style="border: none; width: 200px; vertical-align: top;">
                <div style="border: 2px solid #000; width: 130px; height: 160px;"></div>
                <div style="font-size: 10px; color: #555; margin-top: 4px; width: 130px; text-align: center;">(Foto 3x4)</div>
            </td>
            <td style="border: none; vertical-align: top; padding-top: 0;">
                Depok, {{ date('d F Y') }}<br>
                Kepala {{ strtoupper($lembaga->nama_lembaga ?? 'PKBM ALMEERA') }}
                <br><br><br><br><br>
                <b>{{ strtoupper($lembaga->kepala_lembaga ?? 'SUHYANA, M.Pd.') }}</b><br>
                NIP.
            </td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- PAGE 4: NILAI -->
    <table class="no-border header-info">
        <tr>
            <td class="w-30">Nama Satuan Pendidikan</td><td>: {{ strtoupper($lembaga->nama_lembaga ?? 'PKBM ALMEERA') }}</td>
            <td class="w-10">Fase</td><td>: B</td>
        </tr>
        <tr>
            <td>Alamat</td><td>: {{ $lembaga->alamat ?? '-' }}</td>
            <td>Kelas</td><td>: {{ explode(' ', $siswa->kelas->nama_kelas)[2] ?? '7' }}</td>
        </tr>
        <tr>
            <td>Nama Peserta Didik</td><td>: <b>{{ strtoupper($siswa->nama_siswa) }}</b></td>
            <td>Semester</td><td>: {{ $semester }}</td>
        </tr>
        <tr>
            <td>NISN</td><td>: {{ $siswa->nisn ?? '-' }}</td>
            <td>Tahun Pelajaran</td><td>: {{ $tahun_pelajaran }}</td>
        </tr>
        <tr>
            <td>NIS</td><td>: {{ $siswa->nis ?? '-' }}</td>
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
                <td>{{ $nilai->nama_mapel }}</td>
                <td class="center">
                    {{ $nilai->nilai_akhir ?? '-' }}
                </td>
                <td>
                    Murid menunjukkan pemahaman dalam materi ini.
                    @if($nilai->deskripsi) {{ $nilai->deskripsi }} @endif
                </td>
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
            <tr><td>Alpa</td><td class="center">:</td><td>{{ $absensi->alfa ?? 0 }} hari</td></tr>
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
                Kepala {{ strtoupper($lembaga->nama_lembaga ?? 'PKBM ALMEERA') }}
                <br><br><br><br><br>
                <b><u>{{ strtoupper($lembaga->kepala_lembaga ?? 'SUHYANA, M.Pd') }}</u></b><br>
                NIP.
            </td>
        </tr>
    </table>

</body>
</html>
