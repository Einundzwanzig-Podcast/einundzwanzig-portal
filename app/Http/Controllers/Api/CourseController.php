<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Course::query()
                       ->select('id', 'name', )
                       ->orderBy('name')
                       ->when($request->has('user_id'),
                           fn(Builder $query) => $query->where('created_by', $request->user_id))
                       ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'ilike', "%{$request->search}%")
            )
                       ->when(
                           $request->exists('selected'),
                           fn (Builder $query) => $query->whereIn('id',
                               $request->input('selected', [])),
                           fn (Builder $query) => $query->limit(10)
                       )
                       ->get()
                       ->map(function (Course $course) {
                           $course->image = $course->getFirstMediaUrl('logo',
                               'thumb');

                           return $course;
                       });
    }

    /**
     * Store a newly created resource in storage.
     *
     * Allows a lecturer to create a course programmatically (e.g. to sync
     * courses from an external system). Mirrors the validation of the
     * Livewire CourseForm. Authorized via CoursePolicy@create (is_lecturer).
     */
    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validate([
            'lecturer_id' => ['required', 'integer', 'exists:lecturers,id'],
            'name'        => ['required', 'string', Rule::unique('courses', 'name')],
            'description' => ['nullable', 'string'],
            'tags'        => ['sometimes', 'array'],
            'tags.*'      => ['string'],
        ]);

        $course = Course::create([
            'lecturer_id' => $validated['lecturer_id'],
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? '',
        ]);

        if (! empty($validated['tags'])) {
            $course->syncTagsWithType($validated['tags'], 'course');
        }

        return response()->json($course->fresh(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * Authorized via CoursePolicy@update (owner of the course).
     */
    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'lecturer_id' => ['sometimes', 'required', 'integer', 'exists:lecturers,id'],
            'name'        => ['sometimes', 'required', 'string', Rule::unique('courses', 'name')->ignore($course)],
            'description' => ['sometimes', 'nullable', 'string'],
            'tags'        => ['sometimes', 'array'],
            'tags.*'      => ['string'],
        ]);

        $course->update(collect($validated)->except('tags')->toArray());

        if ($request->has('tags')) {
            $course->syncTagsWithType($validated['tags'] ?? [], 'course');
        }

        return response()->json($course->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
