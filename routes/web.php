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
     ->prefix('school')
     ->group(function () {
         Route::get('/{country:code}/table/city', \App\Http\Livewire\School\CityTable::class)
              ->name('table.city');

         Route::get('/{country:code}/table/lecturer', \App\Http\Livewire\School\LecturerTable::class)
              ->name('table.lecturer');

         Route::get('/{country:code}/table/venue', \App\Http\Livewire\School\VenueTable::class)
              ->name('table.venue');

         Route::get('/{country:code}/table/course', \App\Http\Livewire\School\CouseTable::class)
              ->name('table.course');

         Route::get('/{country:code}/table/event', \App\Http\Livewire\School\EventTable::class)
              ->name('table.event');
     });

/*
 * Library
 * */
Route::middleware([])
     ->as('library.')
     ->prefix('library')
     ->group(function () {
         Route::get('/{country:code}/table/library-item', \App\Http\Livewire\Library\LibraryTable::class)
              ->name('table.libraryItems');

         Route::get('/{country:code}/table/content-creator', \App\Http\Livewire\Library\LibraryTable::class)
              ->name('table.lecturer');
     });

/*
 * Books
 * */
Route::middleware([])
     ->as('bookCases.')
     ->prefix('book-cases')
     ->group(function () {
         Route::get('/{country:code}/table/city', \App\Http\Livewire\BookCase\CityTable::class)
              ->name('table.city');

         Route::get('/table/book-case', \App\Http\Livewire\BookCase\BookCaseTable::class)
              ->name('table.bookcases');

         Route::get('/book-case/{bookCase}', \App\Http\Livewire\BookCase\CommentBookCase::class)
              ->name('comment.bookcase');
     });

/*
 * Events
 * */
Route::middleware([])
     ->as('bitcoinEvent.')
     ->prefix('meetup')
     ->group(function () {
         Route::get('/{country:code}/table/event', \App\Http\Livewire\BitcoinEvent\BitcoinEventTable::class)
              ->name('table.bitcoinEvent');
     });


/*
 * Meetups
 * */
Route::middleware([])
     ->as('meetup.')
     ->prefix('meetup')
     ->group(function () {
         Route::get('/{country:code}/table/meetup', \App\Http\Livewire\Meetup\MeetupTable::class)
              ->name('table.meetup');
         Route::get('/{country:code}/table/meetup-events', \App\Http\Livewire\Meetup\MeetupEventTable::class)
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
