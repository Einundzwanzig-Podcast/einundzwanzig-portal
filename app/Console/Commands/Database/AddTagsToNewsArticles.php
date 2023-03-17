<?php

namespace App\Console\Commands\Database;

use App\Models\LibraryItem;
use Illuminate\Console\Command;

class AddTagsToNewsArticles extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'news:tags';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        LibraryItem::query()
                                   ->where('news', true)
                                   ->get()
                                   ->each(fn(LibraryItem $libraryItem) => $libraryItem->syncTagsWithType(['News'],
                                       'library_item'));
    }
}
