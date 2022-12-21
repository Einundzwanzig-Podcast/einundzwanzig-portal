<?php

namespace App\Http\Livewire\School;

use App\Models\Country;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LecturerTable extends Component
{
    public Country $country;

    public function render()
    {
        return view('livewire.school.lecturer-table')->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('Lecturers'),
                description: __('Lecturers in the surrounding area.'),
                image: asset('img/screenshot.png')
            )
        ]);
    }
}
