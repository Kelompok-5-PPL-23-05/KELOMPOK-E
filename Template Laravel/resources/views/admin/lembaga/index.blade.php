@extends('admin.layout')

@section('title', 'Data Lembaga')

@section('content')
<h1 class="page-title">Data Lembaga / PKBM</h1>
<p class="page-subtitle">Kelola data lembaga penyelenggara pendidikan non-formal</p>

{{-- Pesan Sukses / Error --}}
@if(session('success'))
    <div style="color: green; margin-bottom: 15px; font-weight: bold;">
        {{ session('success') }}
    </div>
@endif

<div class="table-wrapper" style="margin-bottom: 30px;">
    <div class="table-header">
        <div class="table-title">Upload Data Master Lembaga</div>
    </div>
    {{-- Form untuk Subtask 1 --}}
    <form method="POST" action="{{ route('admin.lembaga.import.preview') }}" enctype="multipart/form-data" style="padding: 20px;">
        @csrf
        <div class="form-group">
            <label>File CSV Lembaga <span class="required">*</span></label>
            <input type="file" name="file_master" class="form-control" accept=".csv" required>
            <small style="display:block; margin-top:5px; color:#666;">
                Pastikan urutan kolom CSV: <strong>Nama Lembaga, Alamat, Kontak</strong><br>
                Contoh baris: <em>PKBM Maju Bersama, Jl. Merdeka No 1, 08123456789</em>
            </small>
        </div>
        <button type="submit" class="btn btn-primary">Lanjut ke Preview</button>
    </form>
</div>

<div class="table-wrapper">
    <div class="table-header">
        <div class="table-title">Daftar Lembaga Tersimpan ({{ $lembaga->count() }})</div>
    </div>

    @if($lembaga->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lembaga</th>
                <th>Alamat</th>
                <th>Kontak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lembaga as $i => $l)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $l->nama_lembaga }}</td>
                <td>{{ $l->alamat ?? '-' }}</td>
                <td>{{ $l->kontak ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state" style="padding: 20px; text-align: center;">
        <p>Belum ada data lembaga di dalam sistem.</p>
    </div>
    @endif
</div>
@endsection