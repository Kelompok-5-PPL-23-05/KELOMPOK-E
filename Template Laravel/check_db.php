<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DATA MATA PELAJARAN ===\n";
$mapel = \App\Models\MataPelajaran::all();
echo "Total: " . $mapel->count() . "\n";
foreach ($mapel as $m) {
    echo "  [{$m->id_mapel}] {$m->nama_mapel}\n";
}

echo "\n=== DATA GURU & MAPEL DIAMPU ===\n";
$gurus = \App\Models\Guru::with('mataPelajaran')->get();
foreach ($gurus as $g) {
    $list = $g->mataPelajaran->pluck('nama_mapel')->implode(', ');
    echo "  Guru: {$g->nama_guru} -> " . ($list ?: 'NONE') . "\n";
}
