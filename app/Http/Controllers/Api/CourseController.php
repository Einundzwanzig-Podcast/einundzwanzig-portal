<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
     */
    public function store(Request $request)
    {
        //
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
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
