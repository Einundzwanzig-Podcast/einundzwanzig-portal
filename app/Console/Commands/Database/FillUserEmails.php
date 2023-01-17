<?php

namespace App\Console\Commands\Database;

use App\Models\User;
use Illuminate\Console\Command;

class FillUserEmails extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'users:emails';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            // set email
            if (!$user->email) {
                $user->email = str($user->public_key)->substr(-12).'@portal.einundzwanzig.space';
                $user->save();
            }
        }

        return Command::SUCCESS;
    }
}
