@extends('admin.layout')

@section('title', 'Preview Data Upload Siswa')

@section('content')
<h1 class="page-title">Preview Data Master Siswa</h1>
<p class="page-subtitle">Pastikan data di bawah ini sudah benar sebelum disimpan permanen ke dalam sistem.</p>

<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa (Dari File)</th>
                <th>Nama Kelas (Dari File)</th>
                <th>Status Validasi Sistem</th>
            </tr>
        </thead>
        <tbody>
            @foreach($previewData as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row['nama_siswa'] }}</td>
                <td>{{ $row['nama_kelas'] }}</td>
                <td>
                    @if($row['status'] == 'Valid')
                        <span style="color: green; font-weight: bold;">✔ Valid (Siap Simpan)</span>
                    @else
                        <span style="color: red; font-weight: bold;">❌ {{ $row['status'] }} (Akan dilewati)</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; display: flex; gap: 10px;">
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-cancel">Batal</a>
        
        <form action="{{ route('admin.siswa.import.save') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Konfirmasi & Simpan Data Valid</button>
        </form>
    </div>
</div>
@endsection