<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return City::query()
                   ->with(['country:id,name'])
                   ->select('id', 'name','country_id')
                   ->orderBy('name')
                   ->when(
                $request->search,
                fn(Builder $query) => $query
                    ->where('name', 'ilike', "%{$request->search}%")
            )
                   ->when(
                       $request->exists('selected'),
                       fn(Builder $query) => $query->whereIn('id',
                           $request->input('selected', [])),
                       fn(Builder $query) => $query->limit(10)
                   )
                   ->get();
    }

    /**
     * Store a newly created resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function show(Lecturer $lecturer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lecturer $lecturer)
    {
        //
    }
}
