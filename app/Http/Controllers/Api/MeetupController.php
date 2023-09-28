<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\meetup;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MeetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $myMeetupIds = User::query()->find($request->input('user_id'))->meetups->pluck('id');

        return Meetup::query()
            ->select('id', 'name', 'city_id', 'slug')
            ->with([
                'city.country',
            ])
            ->whereIn('id', $myMeetupIds->toArray())
            ->orderBy('name')
            ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
                    ->orWhereHas('city',
                        fn(Builder $query) => $query->where('cities.name', 'ilike', "%{$request->search}%"))
            )
            ->when(
                $request->exists('selected'),
                fn(Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn(Builder $query) => $query->limit(10)
            )
            ->get()
            ->map(function (Meetup $meetup) {
                $meetup->profile_image = $meetup->getFirstMediaUrl('logo', 'thumb');

                return $meetup;
            });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(meetup $meetup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, meetup $meetup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(meetup $meetup)
    {
        //
    }
}
