<?php

namespace App\Console\Commands\Database;

use App\Models\Meetup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncGithubMeetups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meetups:github-sync';

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
        $response = Http::get('https://raw.githubusercontent.com/Einundzwanzig-Podcast/einundzwanzig.space/master/content/meetups.json');

        $meetups = $response->json();

        foreach ($meetups as $meetup) {
            $dbMeetup = Meetup::where('name', $meetup['name'])
                              ->first();
            if ($dbMeetup) {
                //$this->info('Update: '.$meetup['name']);
                $dbMeetup->update([
                    'github_data' => $meetup,
                ]);
            } else {
                $this->info('Missing: '.$meetup['name'].' Url: '.$meetup['url']);
                if (app()->environment('local')) {
                    Meetup::create([
                        'name' => $meetup['name'],
                        'city_id' => 1,
                        'created_by' => 1,
                        'github_data' => $meetup,
                    ]);
                }
            }
        }

        return Command::SUCCESS;
    }
}
