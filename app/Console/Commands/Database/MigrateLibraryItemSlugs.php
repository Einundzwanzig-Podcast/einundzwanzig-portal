<?php

namespace App\Console\Commands\Database;

use App\Models\LibraryItem;
use Illuminate\Console\Command;

class MigrateLibraryItemSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'library_items:slugs';

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
        foreach (LibraryItem::all() as $item) {
            $item->slug = str($item->name)->slug('-', 'de');
            $item->save();
        }

        return Command::SUCCESS;
    }
}
