<?php

namespace App\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

class LaravelEcho extends Component
{
    use Actions;

    protected $listeners = ['echo:plebchannel,.App\Events\PlebLoggedInEvent' => 'plebLoggedIn'];

    public function plebLoggedIn($data)
    {
        if (auth()->check()) {
            $this->notification()
                 ->confirm([
                     'img' => $data['img'],
                     'title' => 'Pleb alert!',
                     'description' => $data['name'].' logged in',
                     'icon' => 'bell',
                     'acceptLabel' => '',
                     'rejectLabel' => '',
                     'iconColor' => 'primary',
                     'timeout' => 60000,
                 ]);
        }
    }
}
