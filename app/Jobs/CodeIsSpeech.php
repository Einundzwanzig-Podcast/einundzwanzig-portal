<?php

namespace App\Jobs;

use App\Events\AudioTextToSpeechChangedEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class CodeIsSpeech implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $id, public bool $encode = true)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->encode) {
            $response = Http::get('http://host.docker.internal:5002/api/tts', [
                'text'        => File::get(storage_path('app/public/tts/'.$this->id.'.txt')),
                'speaker_id'  => null,
                'style_wav'   => null,
                'language_id' => null,
            ]);

            File::put(storage_path('app/public/tts/'.$this->id.'.wav'), $response->body());
        } elseif (!File::exists(storage_path('app/public/tts/'.$this->id.'.wav'))) {
            $response = Http::get('http://host.docker.internal:5002/api/tts', [
                'text'        => File::get(storage_path('app/public/tts/'.$this->id.'.txt')),
                'speaker_id'  => null,
                'style_wav'   => null,
                'language_id' => null,
            ]);

            File::put(storage_path('app/public/tts/'.$this->id.'.wav'), $response->body());
        }

        event(new AudioTextToSpeechChangedEvent(url('storage/tts/'.$this->id.'.wav')));
    }
}
