<?php

namespace App\Http\Livewire\School;

use App\Models\Country;
use App\Traits\HasTextToSpeech;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class CourseTable extends Component
{
    use HasTextToSpeech;

    public Country $country;

    public function render()
    {
        return view('livewire.school.course-table')->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Courses'),
                description: __('Choose your city, search for courses in the surrounding area and select a topic that suits you.'),
                image: asset('img/screenshot.png')
            ),
        ]);
    }
}
