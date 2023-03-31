<?php

namespace App\Console\Commands\MempoolSpace;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use OpenAI;

class CacheRecommendedFees extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'mempool:recommended-fees';

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
        $apiKey = config('services.open-ai.apiKey');
        $client = OpenAI::client($apiKey);

        $result = Http::get('https://mempool.space/api/v1/fees/recommended');
        $result = $result->json();

        $result = $client->completions()
                         ->create([
                             'model'       => 'text-davinci-003',
                             'prompt'      => sprintf('Erstelle einen Wetterbericht für den Bitcoin Mempool mit folgenden Gebühren: fastestFee: %s sat/vB, halfHourFee: %s sat/vB, hourFee: %s sat/vB, economyFee: %s sat/vB, minimumFee: %s sat/vB. Fasse mit maximal 400 Zeichen zusammen und schreibe im Stile eines Wetterberichtes aus dem Fernsehen um. Schreibe nichts von schnellen Gebühren, sondern interpretiere die Gebühren anders. Schreibe auch nichts von schnellen Gebühren.',
                                 $result['fastestFee'],
                                 $result['halfHourFee'],
                                 $result['hourFee'],
                                 $result['economyFee'],
                                 $result['minimumFee']
                             ),
                             'max_tokens'  => 400,
                             'temperature' => 1
                         ]);

        cache()->put('mempool-weather', $result['choices'][0]['text'], now()->addMinutes(62));
        cache()->put('mempool-weather-changed', now()->toDateTimeString(), now()->addMinutes(62));
    }
}
