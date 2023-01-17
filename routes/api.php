<?php

use App\Models\LoginKey;
use App\Models\Team;
use App\Models\User;
use eza\lnurl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')
     ->get('/user', function (Request $request) {
         return $request->user();
     });

Route::middleware([])
     ->as('api.')
     ->group(function () {
         Route::resource('countries', \App\Http\Controllers\Api\CountryController::class);
     });

Route::middleware([])
     ->as('api.')
     ->group(function () {
         Route::resource('languages', \App\Http\Controllers\Api\LanguageController::class);
         Route::get('meetups', function () {
             return \App\Models\Meetup::with([
                 'city',
             ])
                                      ->get()
                                      ->map(fn($meetup) => [
                                          'name'             => $meetup->name,
                                          'url'              => $meetup->telegram_link ?? $meetup->webpage,
                                          'top'              => $meetup->github_data['top'] ?? null,
                                          'left'             => $meetup->github_data['top'] ?? null,
                                          'country'          => str($meetup->city->country->code)->upper(),
                                          'state'            => $meetup->github_data['state'] ?? null,
                                          'city'             => $meetup->city->name,
                                          'longitude'        => $meetup->city->longitude,
                                          'latitude'         => $meetup->city->latitude,
                                          'twitter_username' => $meetup->twitter_username,
                                          'website'          => $meetup->webpage,
                                      ]);
         });
     });

Route::get('/lnurl-auth-callback', function (\Illuminate\Http\Request $request) {
    if (lnurl\auth($request->k1, $request->sig, $request->key)) {
        // find User by $wallet_public_key
        $user = User::where('public_key', $request->key)
                    ->first();
        if (!$user) {
            // create User
            $user = User::create([
                'public_key'  => $request->key,
                'is_lecturer' => true,
                'name'        => $request->key,
                'email'       => str($request->key)->substr(-12).'@portal.einundzwanzig.space'
            ]);
            $user->ownedTeams()
                 ->save(Team::forceCreate([
                     'user_id'       => $user->id,
                     'name'          => $request->key."'s Team",
                     'personal_team' => true,
                 ]));
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
