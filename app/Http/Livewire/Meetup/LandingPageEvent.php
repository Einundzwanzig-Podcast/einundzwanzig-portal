<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Country;
use App\Models\Meetup;
use App\Models\MeetupEvent;
use App\Rules\UniqueAttendeeName;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LandingPageEvent extends Component
{
    public MeetupEvent $meetupEvent;

    public Country $country;

    public ?Meetup $meetup = null;

    public bool $willShowUp = false;

    public bool $perhapsShowUp = false;

    public string $name = '';

    public function rules()
    {
        return [
            'name' => [
                'required',
                new UniqueAttendeeName($this->meetupEvent),
            ],
        ];
    }

    public function mount()
    {
        $this->meetupEvent->load('meetup.users');
        $this->meetup = $this->meetupEvent->meetup;
        $this->checkShowUp();
    }

    public function checkShowUp()
    {
        $attendees = collect($this->meetupEvent->attendees);
        $mightAttendees = collect($this->meetupEvent->might_attendees);

        if (auth()->check() && $attendees->contains(fn ($value) => str($value)->contains('id_'.auth()->id()))) {
            $this->name = str($attendees->filter(fn ($value) => str($value)->contains('id_'.auth()->id()))
                                        ->first())
                ->after('|')
                ->toString();
            $this->willShowUp = true;
        }

        if (! auth()->check() && $attendees->contains(fn ($value) => str($value)->contains('anon_'.session()->getId()))) {
            $this->name = str($attendees->filter(fn ($value) => str($value)->contains('anon_'.session()->getId()))
                                        ->first())
                ->after('|')
                ->toString();
            $this->willShowUp = true;
        }

        if (auth()->check() && $mightAttendees->contains(fn ($value) => str($value)->contains('id_'.auth()->id()))) {
            $this->name = str($mightAttendees->filter(fn ($value) => str($value)->contains('id_'.auth()->id()))
                                             ->first())
                ->after('|')
                ->toString();
            $this->perhapsShowUp = true;
        }

        if (! auth()->check() && $mightAttendees->contains(fn ($value
            ) => str($value)->contains('anon_'.session()->getId()))) {
            $this->name = str($mightAttendees->filter(fn ($value) => str($value)->contains('anon_'.session()->getId()))
                                             ->first())
                ->after('|')
                ->toString();
            $this->perhapsShowUp = true;
        }
    }

    public function cannotCome()
    {
        $attendees = collect($this->meetupEvent->attendees);
        $mightAttendees = collect($this->meetupEvent->might_attendees);

        if (auth()->check() && $attendees->contains(fn ($value) => str($value)->contains('id_'.auth()->id()))) {
            $attendees = $attendees->filter(fn ($value) => ! str($value)->contains('id_'.auth()->id()));
            $this->willShowUp = false;
        }

        if (! auth()->check() && $attendees->contains(fn ($value) => str($value)->contains('anon_'.session()->getId()))) {
            $attendees = $attendees->filter(fn ($value) => ! str($value)->contains('anon_'.session()->getId()));
            $this->willShowUp = false;
        }

        if (auth()->check() && $mightAttendees->contains(fn ($value) => str($value)->contains('id_'.auth()->id()))) {
            $mightAttendees = $mightAttendees->filter(fn ($value) => ! str($value)->contains('id_'.auth()->id()));
            $this->perhapsShowUp = false;
        }

        if (! auth()->check() && $mightAttendees->contains(fn ($value
            ) => str($value)->contains('anon_'.session()->getId()))) {
            $mightAttendees = $mightAttendees->filter(fn ($value) => ! str($value)->contains('anon_'.session()->getId()));
            $this->perhapsShowUp = false;
        }

        $this->meetupEvent->update([
            'attendees' => $attendees->toArray(),
            'might_attendees' => $mightAttendees->toArray(),
        ]);
    }

    public function attend()
    {
        $this->validate();
        $attendees = collect($this->meetupEvent->attendees);

        if (auth()->check() && ! $attendees->contains('id_'.auth()->id().'|'.$this->name)) {
            $attendees->push('id_'.auth()->id().'|'.$this->name);
            $this->willShowUp = true;
        }

        if (! auth()->check() && ! $attendees->contains('anon_'.session()->getId().'|'.$this->name)) {
            $attendees->push('anon_'.session()->getId().'|'.$this->name);
            $this->willShowUp = true;
        }

        $this->meetupEvent->update([
            'attendees' => $attendees->toArray(),
        ]);
    }

    public function mightAttend()
    {
        $this->validate();
        $mightAttendees = collect($this->meetupEvent->might_attendees);

        if (auth()->check() && ! $mightAttendees->contains('id_'.auth()->id().'|'.$this->name)) {
            $mightAttendees->push('id_'.auth()->id().'|'.$this->name);
            $this->perhapsShowUp = true;
        }

        if (! auth()->check() && ! $mightAttendees->contains('anon_'.session()->getId().'|'.$this->name)) {
            $mightAttendees->push('anon_'.session()->getId().'|'.$this->name);
            $this->perhapsShowUp = true;
        }

        $this->meetupEvent->update([
            'might_attendees' => $mightAttendees->toArray(),
        ]);
    }

    public function render()
    {
        return view('livewire.meetup.landing-page-event')->layout('layouts.guest', [
            'SEOData' => new SEOData(
                title: $this->meetupEvent->start->asDateTime().' - '.$this->meetup->name,
                description: __('Here you can confirm your participation and find more information about the Meetup.').' - '.$this->meetupEvent->description,
                image: $this->meetup->getFirstMediaUrl('logo'),
            ),
        ]);
    }
}
