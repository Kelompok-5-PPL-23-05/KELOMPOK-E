<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateWithoutFK extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:refresh-noFK';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Migrate refresh dengan menonaktifkan foreign key checks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $this->info('✓ Foreign key checks disabled');

            // Run refresh and seed
            $this->call('migrate:refresh', ['--seed' => true]);

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $this->info('✓ Foreign key checks re-enabled');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return self::FAILURE;
        }
    }
}
