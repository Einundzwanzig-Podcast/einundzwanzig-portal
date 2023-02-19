<?php

namespace App\Console\Commands\Database;

use App\Models\Tag;
use Illuminate\Console\Command;

class CreateTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tags:create';

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
        $tags = config('tags.tags.course');
        foreach ($tags as $tag) {
            $t = Tag::findOrCreate($tag['de'], 'course');
            $t->icon = $tag['icon'];
            $t->setTranslation('name', 'en', $tag['en']);
            $t->save();
        }
        $tags = config('tags.tags.library_item');
        foreach ($tags as $tag) {
            $t = Tag::findOrCreate($tag['de'], 'library_item');
            $t->icon = $tag['icon'];
            $t->setTranslation('name', 'en', $tag['en']);
            $t->save();
        }

        return Command::SUCCESS;
    }
}
