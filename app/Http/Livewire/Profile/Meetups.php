<?php

namespace App\Http\Livewire\Profile;

use App\Models\Meetup;
use Livewire\Component;
use WireUi\Traits\Actions;

class Meetups extends Component
{
    use Actions;

    public $search = '';
    public $meetups;
    public $myMeetups = [];
    public $myMeetupNames = [];
    public $hasMeetups = false;

    public function rules()
    {
        return [
            'search' => 'string',
        ];
    }

    public function mount()
    {
        if (!auth()->user()) {
            return to_route('auth.ln');
        }

        $this->meetups = Meetup::query()
                               ->with([
                                   'city',
                               ])
                               ->where('name', 'ilike', '%'.$this->search.'%')
                               ->orderBy('name')
                               ->limit(10)
                               ->get();
        $this->myMeetups = auth()
            ->user()
            ->meetups()
            ->pluck('meetup_id')
            ->toArray();
        $this->myMeetupNames = auth()
            ->user()
            ->meetups()
            ->pluck('meetups.name', 'meetups.id')
            ->toArray();
        if (count($this->myMeetups) > 0) {
            $this->hasMeetups = true;
        }
    }

    public function updatedSearch($value)
    {
        $this->meetups = Meetup::query()
                               ->where('name', 'ilike', '%'.$value.'%')
                               ->orderBy('name')
                               ->limit(10)
                               ->get();
    }

    public function render()
    {
        return view('livewire.profile.meetups');
    }

    public function signUpForMeetup($id)
    {
        $user = auth()->user();
        $user->meetups()
             ->toggle($id);
        $this->myMeetups = auth()
            ->user()
            ->meetups()
            ->pluck('meetup_id')
            ->toArray();
        if (count($this->myMeetups) > 0) {
            $this->hasMeetups = true;
        } else {
            $this->hasMeetups = false;
        }
        $this->myMeetupNames = auth()
            ->user()
            ->meetups()
            ->pluck('meetups.name', 'meetups.id')
            ->toArray();
        $this->notification()
             ->success(__('Saved.'));
    }
}
