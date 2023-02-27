<?php

namespace App\Http\Livewire\School\Form;

use App\Models\Course;
use App\Models\Tag;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class CourseForm extends Component
{
    use WithFileUploads;
    use Actions;

    public ?Course $course = null;

    public ?string $fromUrl = '';

    public $image;

    public array $selectedTags = [];

    protected $queryString = [
        'fromUrl' => [
            'except' => null,
        ],
    ];

    public function rules()
    {
        return [
            'image' => [Rule::requiredIf(!$this->course->id), 'nullable', 'mimes:jpeg,png,jpg,gif', 'max:10240'],

            'course.lecturer_id' => 'required',
            'course.name'        => [
                'required',
                Rule::unique('courses', 'name')
                    ->ignore($this->course),
            ],
            'course.description' => 'string|nullable',
        ];
    }

    public function mount()
    {
        if (!$this->course) {
            $this->course = new Course([
                'description' => '',
            ]);
        } elseif (
            !auth()
                ->user()
                ->can('update', $this->course)
        ) {
            abort(403);
        } else {
            $this->selectedTags = $this->course->tags()
                                                    ->where('type', 'course')
                                                    ->get()
                                                    ->map(fn($tag) => $tag->name)
                                                    ->toArray();
        }
        if (!$this->fromUrl) {
            $this->fromUrl = url()->previous();
        }
    }

    public function submit()
    {
        $this->validate();
        $this->course->save();

        $this->course->syncTagsWithType(
            $this->selectedTags,
            'course'
        );

        if ($this->image) {
            $this->course->addMedia($this->image)
                         ->usingFileName(md5($this->image->getClientOriginalName()).'.'.$this->image->getClientOriginalExtension())
                         ->toMediaCollection('logo');
        }

        return redirect($this->fromUrl);
    }

    public function selectTag($name)
    {
        $selectedTags = collect($this->selectedTags);
        if ($selectedTags->contains($name)) {
            $selectedTags = $selectedTags->filter(fn($tag) => $tag !== $name);
        } else {
            $selectedTags->push($name);
        }
        $this->selectedTags = $selectedTags->values()
                                           ->toArray();
    }

    public function render()
    {
        return view('livewire.school.form.course-form', [
            'tags' => Tag::query()
                         ->where('type', 'course')
                         ->get(),
        ]);
    }
}
