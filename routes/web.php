<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return to_route('search.cities', ['country' => \App\Models\Country::first()->code]);
})
     ->name('welcome');

Route::get('/{country:code}/suche', \App\Http\Livewire\Frontend\SearchCities::class)
     ->name('search.cities');

Route::get('/dozenten', \App\Http\Livewire\Guest\Welcome::class)
     ->name('search.lecturers');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])
     ->group(function () {
         Route::get('/dashboard', function () {
             return view('dashboard');
         })
              ->name('dashboard');
     });
