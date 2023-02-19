<?php

namespace App\Console\Commands\Map;

use App\Models\Meetup;
use Illuminate\Console\Command;

class CreateGeoJsonPolygon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'map:polygon';

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
        $meetups = Meetup::query()
                         ->with([
                             'city',
                         ])
                         ->get();

        foreach ($meetups as $meetup) {
            dd($meetup->city->name);
        }

        return Command::SUCCESS;
    }
}
