@extends('admin.layout')

@section('content')
<h1>Preview Data Lembaga</h1>
<table class="data-table">
    <thead>
        <tr>
            <th>Nama Lembaga</th>
            <th>Alamat</th>
            <th>Kontak</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($previewData as $row)
        <tr>
            <td>{{ $row['nama_lembaga'] }}</td>
            <td>{{ $row['alamat'] }}</td>
            <td>{{ $row['kontak'] }}</td>
            <td>{{ $row['status'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<form action="{{ route('admin.lembaga.import.save') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success">Konfirmasi & Simpan Semua</button>
</form>
@endsection