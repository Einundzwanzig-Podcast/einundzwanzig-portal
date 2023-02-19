<?php

namespace App\Console\Commands\Database;

use App\Models\Meetup;
use Illuminate\Console\Command;

class MigrateMeetupSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meetups:slugs';

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
        foreach (Meetup::all() as $item) {
            $item->slug = str($item->name)->slug('-', 'de');
            $item->save();
        }

        return Command::SUCCESS;
    }
}
