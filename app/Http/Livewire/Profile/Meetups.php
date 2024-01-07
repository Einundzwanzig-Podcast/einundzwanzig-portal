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

    public ?string $fromUrl = '';

    protected $queryString = ['fromUrl' => ['except' => '']];

    public function rules()
    {
        return [
            'search' => 'string',
        ];
    }

    public function mount()
    {
        if (!auth()->user()) {
            return to_route('auth.login');
        }

        $this->meetups = Meetup::query()
            ->with([
                'city',
            ])
            ->where('name', 'ilike', '%' . $this->search . '%')
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
            ->with([
                'city.country'
            ])
            ->select('meetups.id', 'meetups.city_id', 'meetups.name', 'meetups.slug')
            ->get()
            ->map(fn($meetup) => [
                'id' => $meetup->id,
                'name' => $meetup->name,
                'link' => route('meetup.landing', [
                    'country' => $meetup->city->country->code,
                    'meetup' => $meetup,
                ]),
                'ics' => route('meetup.ics', [
                    'country' => $meetup->city->country->code,
                    'meetup' => $meetup,
                ]),
            ])
            ->toArray();
        if (count($this->myMeetups) > 0) {
            $this->hasMeetups = true;
        }
        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
    }

    public function next()
    {
        return redirect($this->fromUrl);
    }

    public function updatedSearch($value)
    {
        $this->meetups = Meetup::query()
            ->with([
                'city',
            ])
            ->where('name', 'ilike', '%' . $value . '%')
            ->orderBy('name')
            ->limit(10)
            ->get();
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
            ->with([
                'city.country'
            ])
            ->select('meetups.id', 'meetups.city_id', 'meetups.name', 'meetups.slug')
            ->get()
            ->map(fn($meetup) => [
                'id' => $meetup->id,
                'name' => $meetup->name,
                'link' => route('meetup.landing', [
                    'country' => $meetup->city->country->code,
                    'meetup' => $meetup,
                ]),
                'ics' => route('meetup.ics', [
                    'country' => $meetup->city->country->code,
                    'meetup' => $meetup,
                ]),
            ])
            ->toArray();
        $this->notification()
            ->success(__('Saved.'));
    }

    public function render()
    {
        return view('livewire.profile.meetups');
    }
}
