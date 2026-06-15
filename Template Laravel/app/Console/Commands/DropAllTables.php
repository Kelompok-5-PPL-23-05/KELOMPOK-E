<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DropAllTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:drop-all';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Drop semua tables dari database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $this->info('✓ Foreign key checks disabled');

            // Get all tables
            $tables = DB::select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ?", [
                env('DB_DATABASE')
            ]);

            foreach ($tables as $table) {
                DB::statement('DROP TABLE IF EXISTS ' . $table->TABLE_NAME);
                $this->info('  ✓ Dropped table: ' . $table->TABLE_NAME);
            }

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->info('✓ Foreign key checks re-enabled');
            $this->info('✓ Semua tables berhasil dihapus');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return self::FAILURE;
        }
    }
}
