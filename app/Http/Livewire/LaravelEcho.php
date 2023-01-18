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
             ->success(title: 'Pleb alert!', description: $data['name'].' logged in');
    }

    public function render()
    {
        return view('livewire.laravel-echo');
    }
}
