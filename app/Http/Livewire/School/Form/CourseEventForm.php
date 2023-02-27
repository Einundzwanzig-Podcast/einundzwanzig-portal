<?php

namespace App\Http\Livewire\School\Form;

use App\Models\Course;
use App\Models\CourseEvent;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class CourseEventForm extends Component
{
    use WithFileUploads;
    use Actions;

    public ?CourseEvent $courseEvent = null;

    public ?string $fromUrl = '';

    public $image;

    protected $queryString = [
        'fromUrl' => [
            'except' => null,
        ],
    ];

    public function rules()
    {
        return [
            'courseEvent.course_id' => 'required',
            'courseEvent.venue_id'  => 'required',
            'courseEvent.from'      => 'required',
            'courseEvent.to'        => 'required',
            'courseEvent.link'      => 'required',
        ];
    }

    public function mount()
    {
        if (!$this->courseEvent) {
            $this->courseEvent = new CourseEvent([]);
        } elseif (
            !auth()
                ->user()
                ->can('update', $this->courseEvent)
        ) {
            abort(403);
        }
        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
    }

    public function submit()
    {
        $this->validate();
        $this->courseEvent->save();

        return redirect($this->fromUrl);
    }

    public function render()
    {
        return view('livewire.school.form.course-event-form');
    }
}
