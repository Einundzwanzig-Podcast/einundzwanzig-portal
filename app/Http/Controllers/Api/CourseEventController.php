<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseEvent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CourseEventController extends Controller
{
    /**
     * Display a listing of the course events created by the authenticated user.
     *
     * Useful for an external sync client to detect which events already exist
     * (idempotent syncing). Optionally filtered by course_id.
     */
    public function index(Request $request)
    {
        return CourseEvent::query()
            ->with(['course:id,name', 'venue:id,name'])
            ->where('created_by', $request->user()->id)
            ->when(
                $request->filled('course_id'),
                fn (Builder $query) => $query->where('course_id', $request->integer('course_id'))
            )
            ->orderByDesc('from')
            ->get();
    }

    /**
     * Store a newly created course event in storage.
     *
     * Mirrors the validation of the Livewire CourseEventForm.
     * Authorized via CourseEventPolicy@create (is_lecturer).
     */
    public function store(Request $request)
    {
        $this->authorize('create', CourseEvent::class);

        $validated = $request->validate([
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'venue_id'  => ['required', 'integer', 'exists:venues,id'],
            'from'      => ['required', 'date'],
            'to'        => ['required', 'date', 'after_or_equal:from'],
            'link'      => ['required', 'string', 'max:255'],
        ]);

        $courseEvent = CourseEvent::create($validated);

        return response()->json($courseEvent->fresh(), 201);
    }

    /**
     * Update the specified course event in storage.
     *
     * Authorized via CourseEventPolicy@update (owner of the event).
     */
    public function update(Request $request, CourseEvent $courseEvent)
    {
        $this->authorize('update', $courseEvent);

        $validated = $request->validate([
            'course_id' => ['sometimes', 'required', 'integer', 'exists:courses,id'],
            'venue_id'  => ['sometimes', 'required', 'integer', 'exists:venues,id'],
            'from'      => ['sometimes', 'required', 'date'],
            'to'        => ['sometimes', 'required', 'date'],
            'link'      => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        $courseEvent->update($validated);

        return response()->json($courseEvent->fresh());
    }
}
