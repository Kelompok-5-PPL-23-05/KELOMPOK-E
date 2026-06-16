@extends('admin.layout')

@section('title', 'Preview Import Mata Pelajaran')

@section('content')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span>›</span>
    <a href="{{ route('admin.mapel.index') }}">Mata Pelajaran</a>
    <span>›</span>
    <span>Preview Import</span>
</div>

<h1 class="page-title">Preview Import Mata Pelajaran</h1>
<p class="page-subtitle">Periksa data di bawah ini sebelum menyimpan ke sistem.</p>

<div class="card">
    <div class="table-wrapper" style="margin-top: 0; box-shadow: none;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mata Pelajaran</th>
                    <th>Status Validasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($previewData as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row['nama_mapel'] }}</td>
                    <td>
                        @if($row['status'] === 'Valid')
                            <span class="badge badge-success">Valid</span>
                        @else
                            <span class="badge badge-danger">{{ $row['status'] }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px; display: flex; gap: 12px; justify-content: flex-end;">
        <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">Batal</a>
        <form action="{{ route('admin.mapel.import.save') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Simpan Data Valid</button>
        </form>
    </div>
</div>
@endsection
