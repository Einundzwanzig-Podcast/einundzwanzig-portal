<?php

namespace App\Console\Commands\Database;

use App\Models\City;
use App\Models\Country;
use App\Models\Meetup;
use Illuminate\Console\Command;

class ImportGithubMeetups extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'import:meetups';

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
        $meetups = json_decode(file_get_contents(config_path('meetups/github.json')), true, 512, JSON_THROW_ON_ERROR);

        foreach ($meetups as $meetup) {
            $city = City::firstOrCreate([
                'name' => $meetup['city'],
            ], [
                'country_id' => Country::firstOrCreate([
                    'code' => str($meetup['country'])
                        ->lower()
                        ->toString()
                ], ['name' => $meetup['country']])->id,
                'longitude'  => $meetup['longitude'],
                'latitude'   => $meetup['latitude'],
                'created_by' => 1,
            ]);
            $meetup = Meetup::updateOrCreate(
                ['name' => $meetup['name']],
                [
                    'city_id'    => $city->id,
                    'webpage'       => $meetup['url'],
                    'created_by' => 1,
                ]);
        }

        return Command::SUCCESS;
    }
}
