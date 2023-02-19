<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Country::query()
                   ->select('id', 'name', 'code')
                   ->orderBy('name')
                   ->when(
                       $request->search,
                       fn (Builder $query) => $query
                           ->where('name', 'ilike', "%{$request->search}%")
                           ->orWhere('code', 'ilike', "%{$request->search}%")
                   )
                   ->when(
                       $request->exists('selected'),
                       fn (Builder $query) => $query->whereIn('code', $request->input('selected', [])),
                       fn (Builder $query) => $query->limit(10)
                   )
                   ->get()
                   ->map(function (Country $country) {
                       $country->flag = asset('vendor/blade-country-flags/4x3-'.$country->code.'.svg');

                       return $country;
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
    public function show(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
    }
}
