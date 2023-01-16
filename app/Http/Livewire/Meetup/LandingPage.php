<?php

namespace App\Http\Livewire\Meetup;

use App\Models\Country;
use App\Models\Meetup;
use App\Models\MeetupEvent;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LandingPage extends Component
{
    public Meetup $meetup;
    public Country $country;
    public ?int $activeEvent = null;

    public ?int $year = null;

    public function mount()
    {
        $this->meetup->load([
            'media',
        ]);
    }

    public function render()
    {
        return view('livewire.meetup.landing-page', [
            'meetupEvents' => MeetupEvent::query()
                                         ->with([
                                             'meetup.city.country',
                                         ])
                                         ->where('meetup_events.meetup_id', $this->meetup->id)
                                         ->where('meetup_events.start', '>=', now())
                                         ->get(),
            'events'       => MeetupEvent::query()
                                         ->with([
                                             'meetup.city.country',
                                         ])
                                         ->where('meetup_events.meetup_id', $this->meetup->id)
                                         ->where('meetup_events.start', '>=', now())
                                         ->get()
                                         ->map(fn($event) => [
                                             'id'          => $event->id,
                                             'startDate'   => $event->start,
                                             'endDate'     => $event->start->addHours(1),
                                             'location'    => $event->location,
                                             'description' => $event->description,
                                         ]),
        ])
            ->layout('layouts.guest', [
                'SEOData' => new SEOData(
                    title: $this->meetup->name,
                    description: __('Bitcoiner Meetups are a great way to meet other Bitcoiners in your area. You can learn from each other, share ideas, and have fun!'),
                    image: asset($this->meetup->getFirstMediaUrl('logo')),
                )
            ]);
    }

    public function showEvent($id)
    {
        $this->activeEvent = $id;
    }
}
