<?php

use App\Models\LoginKey;
use App\Models\User;
use eza\lnurl;
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

Route::get('/auth/ln', \App\Http\Livewire\Auth\LNUrlAuth::class)
     ->name('auth.ln');

Route::get('/lnurl-auth-callback', function (\Illuminate\Http\Request $request) {
    if (lnurl\auth($request->k1, $request->signature, $request->wallet_public_key)) {
        // find User by $wallet_public_key
        $user = User::where('public_key', $request->key)
                    ->first();
        if (!$user) {
            // create User
            $user = User::create([
                'public_key'  => $request->wallet_public_key,
                'is_lecturer' => true,
            ]);
        }
        // check if $k1 is in the database, if not, add it
        $loginKey = LoginKey::where('k1', $request->k1)
                            ->first();
        if (!$loginKey) {
            LoginKey::create([
                'k1'      => $request->k1,
                'user_id' => $user->id,
            ]);
        }

        return response()->json(['status' => 'OK']);
    }

    return response()->json(['status' => 'ERROR', 'reason' => 'Signature was NOT VERIFIED']);
})
     ->name('auth.ln.callback');

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
