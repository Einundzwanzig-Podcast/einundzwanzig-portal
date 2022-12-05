<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('search.city', ['country' => 'de']);
})
     ->name('welcome');

Route::get('/auth/ln', \App\Http\Livewire\Auth\LNUrlAuth::class)
     ->name('auth.ln')
     ->middleware('guest');

Route::get('/{country:code}/suche/stadt', \App\Http\Livewire\Frontend\SearchCity::class)
     ->name('search.city')
     ->where(
         'country',
         '(.*)'
     );

Route::get('/{country:code}/suche/dozent', \App\Http\Livewire\Frontend\SearchLecturer::class)
     ->name('search.lecturer');

Route::get('/{country:code}/suche/ort', \App\Http\Livewire\Frontend\SearchVenue::class)
     ->name('search.venue');

Route::get('/{country:code}/suche/kurs', \App\Http\Livewire\Frontend\SearchCourse::class)
     ->name('search.course');

Route::get('/{country:code}/suche/termin', \App\Http\Livewire\Frontend\SearchEvent::class)
     ->name('search.event');

Route::get('/{country:code}/bibliothek', \App\Http\Livewire\Frontend\Library::class)
     ->name('library');

Route::get('/{country:code}/dozenten/bibliothek', \App\Http\Livewire\Frontend\Library::class)
     ->name('library.lecturer');

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
