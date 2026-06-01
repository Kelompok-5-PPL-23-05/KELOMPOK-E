<form action="/nilai/store" method="POST">
@csrf

<select name="kelas">
<option>Paket A Kelas 3</option>
</select>

<select name="mata_pelajaran">
<option>Bahasa Indonesia</option>
</select>

@for($i=1;$i<=35;$i++)
<h3>Nama Siswa {{$i}}</h3>

<input type="hidden" name="nama_siswa[]" value="Nama Siswa {{$i}}">

<input 
type="number"
name="nilai[]"
min="1"
max="100"
step="1"
placeholder="1-100"
oninput="batasNilai(this)"
>

<input type="text" name="catatan[]" placeholder="Catatan siswa">

@endfor

<button type="submit">Submit</button>
</form>

<form action="/nilai/store" method="POST">
....
</form>

<script>
function batasNilai(input) {
    let nilai = parseInt(input.value);

    if (nilai > 100) {
        input.value = 100;
    }

    if (nilai < 1 && input.value !== "") {
        input.value = 1;
    }
}
</script>