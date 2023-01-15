<?php

namespace App\Http\Livewire\School;

use App\Models\Country;
use App\Models\CourseEvent;
use App\Models\Lecturer;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LecturerLandingPage extends Component
{
    public Lecturer $lecturer;
    public Country $country;

    public ?int $year = null;
    public ?int $activeEvent = null;

    protected $queryString = ['year'];

    public function render()
    {
        return view('livewire.school.lecturer-landing-page', [
            'courseEvents' => CourseEvent::query()
                                         ->whereHas('course', function ($query) {
                                             $query->where('lecturer_id', $this->lecturer->id);
                                         })
                                         ->get(),
            'events'       => CourseEvent::query()
                                         ->whereHas('course', function ($query) {
                                             $query->where('lecturer_id', $this->lecturer->id);
                                         })
                                         ->get()
                                         ->map(fn($event) => [
                                             'id'          => $event->id,
                                             'startDate'   => $event->from,
                                             'endDate'     => $event->to,
                                             'location'    => $event->course->name,
                                             'description' => $event->venue->name,
                                         ]),
        ])
            ->layout('layouts.guest', [
                'SEOData' => new SEOData(
                    title: $this->lecturer->name,
                    description: $this->lecturer->intro ?? __('This lecturer has not yet written an introduction.'),
                    image: asset($this->lecturer->getFirstMediaUrl('avatar')),
                )
            ]);
    }

    public function showEvent($id)
    {
        $this->activeEvent = $id;
    }
}
