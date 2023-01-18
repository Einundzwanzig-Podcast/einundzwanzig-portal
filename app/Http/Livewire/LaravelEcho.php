<?php

namespace App\Http\Livewire;

use Livewire\Component;
use WireUi\Traits\Actions;

class LaravelEcho extends Component
{
    use Actions;

    protected $listeners = ['echo:login,.App\Events\PlebLoggedInEvent' => 'plebLoggedIn'];

    public function plebLoggedIn($data)
    {
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

    public function render()
    {
        return view('livewire.laravel-echo');
    }
}
