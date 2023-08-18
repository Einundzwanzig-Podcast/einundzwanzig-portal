<?php

namespace App\Console\Commands\Nostr;

use App\Traits\NostrTrait;
use Illuminate\Console\Command;

class PublishUnpublishedItems extends Command
{
    use NostrTrait;

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'nostr:publish {--model=}';

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
        config(['app.user-timezone' => 'Europe/Berlin']);
        $modelName = $this->option('model');
        $className = '\\App\Models\\' . $modelName;
        $model = $className::query()
            ->whereNull('nostr_status')
            ->when($modelName === 'BitcoinEvent', fn($q) => $q->where('from', '>', now()))
            ->when($modelName === 'CourseEvent', fn($q) => $q->where('from', '>', now()))
            ->when($modelName === 'MeetupEvent', fn($q) => $q->where('start', '>', now()))
            ->when($modelName === 'LibraryItem', fn($q) => $q
                ->where('type', '<>', 'markdown_article')
                ->where('type', '<>', 'bindle')
            )
            ->orderByDesc('created_at')
            ->first();
        if ($model) {
            $this->publishOnNostr($model, $this->getText($model));
        }
    }
}
