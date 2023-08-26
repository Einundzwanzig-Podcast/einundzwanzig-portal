<?php

namespace App\Console\Commands\Feed;

use App\Models\Episode;
use App\Models\Podcast;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ReadAndSyncPodcastFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:sync';

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
        $client = new \PodcastIndex\Client([
            'app' => 'Einundzwanzig School',
            'key' => config('feeds.services.podcastindex-org.key'),
            'secret' => config('feeds.services.podcastindex-org.secret'),
        ]);
        $feedIds = [
            185230, // Einundzwanzig, der Bitcoin Podcast
            4627128, // Nodesignal - Deine Bitcoin-Frequenz
            4426306, // Pleb's Taverne
            4409506, // Sound Money Bitcoin Podcast
            620690, // Mises Karma
            4409505, // Münzweg - der Bitcoin-Podcast
            4645280, // Dezentralschweiz Podcast 🇨🇭
            185578, // Blocktrainer Bitcoin Podcast
            4909387, // Was Bitcoin bringt - mit Niko Jilch
            1000839, // Bitcoin Audible
            5603181, // Bitcoin Audible.DE - Die besten Bitcoin-Artikel, vorgelesen in deutscher Sprache!
            1769616, // Einemillionsatoshi - der Bitcoin Podcast für Frauen
            5784083, // Der Bitcoin Effekt - Dein Business Podcast
            5932490, // Satoshis Coffeeshop
            5872859, // Zeitsprung Bitcoin
            5285606, // Die Bitcoin Lesestunde
            5910857, // SOS - Shield Of Satoshi - Ein Bitcoin Podcast
            5045045, // Bitcoin Bibliothek
            4138995, // Orange Relationship
            // 5326181, // Powering Bitcoin - Bitcoin & Energy
            5783120, // Bitcoin´s Energie und Zeit
            558916, // Bitcoin verstehen
            5248065, // Bitcoin Sozial – Lesestunde
            6413036, // Gassi Dialoge
        ];

        foreach ($feedIds as $feedId) {
            $podcast = $client->podcasts->byFeedId($feedId)
                ->json();
            if (is_array($podcast->feed)) {
                dd($podcast->feed);
                Log::error('Error importing feed: ' . $feedId);
            }
            $this->info('Importing: ' . $podcast->feed->title);
            $importPodcast = Podcast::query()
                ->updateOrCreate(['guid' => $podcast->feed->podcastGuid], [
                    'title' => $podcast->feed->title,
                    'link' => $podcast->feed->link,
                    'language_code' => $podcast->feed->language,
                    'data' => $podcast->feed,
                    'created_by' => 1,
                ]);
            $episodes = $client->episodes->withParameters(['max' => 10000])
                ->byFeedId($feedId)
                ->json();
            foreach ($episodes->items as $item) {
                Episode::query()
                    ->updateOrCreate(['guid' => $item->guid], [
                        'podcast_id' => $importPodcast->id,
                        'data' => $item,
                        'created_by' => 1,
                        'created_at' => Carbon::parse($item->datePublished),
                    ]);
            }
            if (app()->environment('local')) {
                break;
            }
        }

        return Command::SUCCESS;
    }
}
