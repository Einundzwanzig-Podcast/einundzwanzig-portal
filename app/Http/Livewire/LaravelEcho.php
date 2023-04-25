<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\File;
use Livewire\Component;
use WireUi\Traits\Actions;

class LaravelEcho extends Component
{
    use Actions;

    public $audioSrc = '';

    protected $listeners = [
        'echo:plebchannel,.App\Events\PlebLoggedInEvent'             => 'plebLoggedIn',
        'echo:plebchannel,.App\Events\AudioTextToSpeechChangedEvent' => 'audioTextToSpeechChanged',
        'echo:plebchannel,.App\Events\PaidMessageEvent'              => 'paidMessage',
    ];

    public function rules()
    {
        return [
            'audioSrc' => 'required',
        ];
    }

    public function paidMessage($data)
    {
        $text = sprintf("
            %s
            %s.
            ",
            'Nachricht aus dem Publikum.',
            str($data['message'])
                ->stripTags()
                ->toString()
        );
        File::put(storage_path('app/public/tts/'.$data['checkid'].'.txt'), $text);
        dispatch(new \App\Jobs\CodeIsSpeech($data['checkid']))->delay(now()->addSecond());
    }

    public function audioTextToSpeechChanged($data)
    {
        $this->audioSrc = $data['src'];
    }

    public function plebLoggedIn($data)
    {
        if (auth()->check()) {
            $text = sprintf("
            %s hat sich gerade eingeloggt. Markus Turm ist begeistert.
            ", $data['name']);
            File::put(storage_path('app/public/tts/userLoggedIn.txt'), $text);
            dispatch(new \App\Jobs\CodeIsSpeech('userLoggedIn'))->delay(now()->addSecond());

            $this->notification()
                 ->confirm([
                     'img'         => $data['img'],
                     'title'       => 'Pleb alert!',
                     'description' => $data['name'].' logged in',
                     'icon'        => 'bell',
                     'acceptLabel' => '',
                     'rejectLabel' => '',
                     'iconColor'   => 'primary',
                     'timeout'     => 60000,
                 ]);
        }
    }
}
