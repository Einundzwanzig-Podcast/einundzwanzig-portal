<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Livewire\Frontend\Welcome::class)
     ->name('welcome');

Route::get('/auth/ln', \App\Http\Livewire\Auth\LNUrlAuth::class)
     ->name('auth.ln')
     ->middleware('guest');

/*
 * School
 * */
Route::middleware([])
     ->as('school.')
     ->prefix('/{country:code}/school')
     ->group(function () {
         Route::get('/city', \App\Http\Livewire\School\CityTable::class)
              ->name('table.city');

         Route::get('/lecturer', \App\Http\Livewire\School\LecturerTable::class)
              ->name('table.lecturer');

         Route::get('/venue', \App\Http\Livewire\School\VenueTable::class)
              ->name('table.venue');

         Route::get('/course', \App\Http\Livewire\School\CouseTable::class)
              ->name('table.course');

         Route::get('/event', \App\Http\Livewire\School\EventTable::class)
              ->name('table.event');
     });

/*
 * Library
 * */
Route::middleware([])
     ->as('library.')
     ->prefix('/{country:code}/library')
     ->group(function () {
         Route::get('/library-item', \App\Http\Livewire\Library\LibraryTable::class)
              ->name('table.libraryItems');

         Route::get('/content-creator', \App\Http\Livewire\Library\LibraryTable::class)
              ->name('table.lecturer');
     });

/*
 * Books
 * */
Route::middleware([])
     ->as('bookCases.')
     ->prefix('/{country:code}/book-cases')
     ->group(function () {
         Route::get('/city', \App\Http\Livewire\BookCase\CityTable::class)
              ->name('table.city');

         Route::get('/overview', \App\Http\Livewire\BookCase\BookCaseTable::class)
              ->name('table.bookcases');

         Route::get('/book-case/{bookCase}', \App\Http\Livewire\BookCase\CommentBookCase::class)
              ->name('comment.bookcase');
     });

/*
 * Events
 * */
Route::middleware([])
     ->as('bitcoinEvent.')
     ->prefix('/{country:code}/event')
     ->group(function () {
         Route::get('overview', \App\Http\Livewire\BitcoinEvent\BitcoinEventTable::class)
              ->name('table.bitcoinEvent');
     });


/*
 * Meetups
 * */
Route::middleware([])
     ->as('meetup.')
     ->prefix('/{country:code}/meetup')
     ->group(function () {
         Route::get('world', \App\Http\Livewire\Meetup\WorldMap::class)
              ->name('world');
         Route::get('overview', \App\Http\Livewire\Meetup\MeetupTable::class)
              ->name('table.meetup');
         Route::get('/meetup-events', \App\Http\Livewire\Meetup\MeetupEventTable::class)
              ->name('table.meetupEvent');
     });

/*
 * Authenticated
 * */
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
