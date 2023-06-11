<?php

namespace App\Console\Commands\Database;

use App\Models\Meetup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExtractLogos extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'logos';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $meetups = Meetup::query()
                         ->with([
                             'media',
                         ])
                         ->get();

        foreach ($meetups as $meetup) {
            $logo = $meetup->getFirstMedia('logo');
            if ($logo) {
                if (file_exists($logo->getPath())) {
                    Storage::disk('public')
                           ->put('00_logos/'.$meetup->name.'.'.$logo->extension, file_get_contents($logo->getPath()));
                }
            }
        }
    }
}
