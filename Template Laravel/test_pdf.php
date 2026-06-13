<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$siswa = \App\Models\Siswa::first();
if (!$siswa) {
    echo "Tidak ada data siswa.\n";
    exit;
}

$controller = new \App\Http\Controllers\RaporController();
$response = $controller->cetakPdf($siswa->id_siswa);

file_put_contents('test_rapor.pdf', $response->getContent());
echo "Berhasil render PDF, ukuran: " . filesize('test_rapor.pdf') . " bytes.\n";
