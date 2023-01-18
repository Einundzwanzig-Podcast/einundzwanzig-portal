<?php

namespace App\Console\Commands\Feed;

use App\Models\Episode;
use App\Models\Podcast;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ReadAndSyncEinundzwanzigPodcastFeed extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'feed:sync';

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
        $client = new \PodcastIndex\Client([
            'app'    => 'Einundzwanzig School',
            'key'    => config('feeds.services.podcastindex-org.key'),
            'secret' => config('feeds.services.podcastindex-org.secret'),
        ]);
        $podcast = $client->podcasts->byFeedUrl('https://einundzwanzig.space/feed.xml')
                                    ->json();
        $einundzwanzigPodcast = Podcast::query()
                                       ->updateOrCreate(['guid' => $podcast->feed->podcastGuid], [
                                           'title'         => $podcast->feed->title,
                                           'link'          => $podcast->feed->link,
                                           'language_code' => $podcast->feed->language,
                                           'data'          => $podcast->feed,
                                           'created_by'    => 1,
                                       ]);
        $episodes = $client->episodes->withParameters(['max' => 1000])
                                     ->byFeedId(185230)
                                     ->json();
        foreach ($episodes->items as $item) {
            Episode::query()
                   ->updateOrCreate(['guid' => $item->guid], [
                       'podcast_id' => $einundzwanzigPodcast->id,
                       'data'       => $item,
                       'created_by' => 1,
                       'created_at' => Carbon::parse($item->datePublished),
                   ]);
        }

        return Command::SUCCESS;
    }
}
