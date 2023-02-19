<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupLoginKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loginkeys:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        DB::table('login_keys')
          ->where('created_at', '<', now()->subDays(1))
          ->delete();

        return Command::SUCCESS;
    }
}
