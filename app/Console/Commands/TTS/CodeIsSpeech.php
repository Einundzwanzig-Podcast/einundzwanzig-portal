<?php

namespace App\Console\Commands\TTS;

use App\Events\AudioTextToSpeechChangedEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class CodeIsSpeech extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'tts:encode {--text=}';

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
        $response = Http::get('http://host.docker.internal:5002/api/tts', [
            'text'        => File::get(storage_path('app/public/tts/'.$this->option('text').'.txt')),
            'speaker_id'  => null,
            'style_wav'   => null,
            'language_id' => null,
        ]);

        File::put(storage_path('app/public/tts/'.$this->option('text').'.wav'), $response->body());

        event(new AudioTextToSpeechChangedEvent(url('storage/tts/'.$this->option('text').'.wav')));
    }
}
