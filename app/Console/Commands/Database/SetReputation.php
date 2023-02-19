<?php

namespace App\Console\Commands\Database;

use App\Gamify\Points\BookCaseOrangePilled;
use App\Models\User;
use Illuminate\Console\Command;

class SetReputation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reputation:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach (User::query()
                     ->with(['orangePills'])
                     ->get() as $item) {
            foreach ($item->orangePills as $orangePill) {
                $orangePill->user->givePoint(new BookCaseOrangePilled($orangePill));
            }
        }

        return Command::SUCCESS;
    }
}
