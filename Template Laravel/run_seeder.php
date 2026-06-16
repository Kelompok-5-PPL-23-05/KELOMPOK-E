<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $seeder = new Database\Seeders\DatabaseSeeder();
    $seeder->run();
    echo "Seeder completed successfully.\n";
} catch (\Exception $e) {
    echo "Seeder failed: " . $e->getMessage() . "\n";
}
