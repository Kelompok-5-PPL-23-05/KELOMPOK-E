<form action="/nilai/store" method="POST">
@csrf

<select name="kelas">
<option>Paket A Kelas 3</option>
</select>

<select name="mata_pelajaran">
<option>Bahasa Indonesia</option>
</select>

@for($i=1;$i<=3;$i++)
<h3>Nama Siswa {{$i}}</h3>

<input type="hidden" name="nama_siswa[]" value="Nama Siswa {{$i}}">

<input type="number" name="nilai[]" min="1" max="100" placeholder="1-100">

<input type="text" name="catatan[]" placeholder="Catatan siswa">

@endfor

<button type="submit">Submit</button>
</form>