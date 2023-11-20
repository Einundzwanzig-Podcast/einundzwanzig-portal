<?php

use Illuminate\Support\Facades\Response;

Route::get('/', \App\Livewire\Nostr\Start::class)
    ->name('start');

Route::middleware([])
    ->get('/kaninchenbau', \App\Livewire\Helper\FollowTheRabbit::class)
    ->name('kaninchenbau');

Route::middleware([])
    ->get('/bindles', \App\Livewire\Bindle\Gallery::class)
    ->name('bindles');

Route::middleware([])
    ->get('/buecherverleih', \App\Livewire\BooksForPlebs\BookRentalGuide::class)
    ->name('buecherverleih');

Route::get('/img/{path}', \App\Http\Controllers\ImageController::class)
    ->where('path', '.*')
    ->name('img');

Route::get('/img-public/{path}', \App\Http\Controllers\ImageController::class)
    ->where('path', '.*')
    ->name('imgPublic');

Route::middleware([])
    ->get('/nostr/einundzwanzig-plebs', function () {
        return redirect('https://einundzwanzigstr.codingarena.de/einundzwanzig-plebs');
    })
    ->name('nostr.plebs');

/*
 * Authenticated
 * */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])
    ->group(function () {
        /*
        * Meetup OSM
        * */
        Route::get('/meetup-osm/table', \App\Livewire\Meetup\PrepareForBtcMapTable::class)
            ->name('osm.meetups');
        Route::get('/meetup-osm/item/{meetup}', \App\Livewire\Meetup\PrepareForBtcMapItem::class)
            ->name('osm.meetups.item');
    });

Route::feeds();

Route::get('/download', function () {

    // Get the file path from the public folder
    $filePath = public_path("buecherverleih.zip");

    $filename = "buecherverleih.zip";

    // Check if the file exists
    if (!file_exists($filePath)) {
        abort(404);
    }

    // Generate a response with the file for download
    return Response::download($filePath, $filename);
});

Route::get('/download-flyer', function () {

    // Get the file path from the public folder
    $filePath = public_path("flyer.zip");

    $filename = "flyer.zip";

    // Check if the file exists
    if (!file_exists($filePath)) {
        abort(404);
    }

    // Generate a response with the file for download
    return Response::download($filePath, $filename);
});

Route::get('/download-etiketten', function () {

    // Get the file path from the public folder
    $filePath = public_path("etiketten.zip");

    $filename = "etiketten.zip";

    // Check if the file exists
    if (!file_exists($filePath)) {
        abort(404);
    }

    // Generate a response with the file for download
    return Response::download($filePath, $filename);
});
