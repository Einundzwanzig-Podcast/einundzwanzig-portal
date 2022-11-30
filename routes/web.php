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
    return to_route('search.city', ['country' => 'de']);
})
     ->name('welcome');

Route::get('/{country:code}/suche/stadt', \App\Http\Livewire\Frontend\SearchCity::class)
     ->name('search.city');

Route::get('/{country:code}/suche/dozent', \App\Http\Livewire\Frontend\SearchLecturer::class)
     ->name('search.lecturer');

Route::get('/{country:code}/suche/ort', \App\Http\Livewire\Frontend\SearchVenue::class)
     ->name('search.venue');

Route::get('/{country:code}/suche/kurs', \App\Http\Livewire\Frontend\SearchCity::class)
     ->name('search.course');

Route::get('/{country:code}/suche/termin', \App\Http\Livewire\Frontend\SearchCity::class)
     ->name('search.event');

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
