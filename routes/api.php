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
         Route::resource('meetup', \App\Http\Controllers\Api\MeetupController::class);
         Route::resource('lecturers', \App\Http\Controllers\Api\LecturerController::class);
         Route::resource('courses', \App\Http\Controllers\Api\CourseController::class);
         Route::resource('cities', \App\Http\Controllers\Api\CityController::class);
         Route::resource('venues', \App\Http\Controllers\Api\VenueController::class);
         Route::resource('languages', \App\Http\Controllers\Api\LanguageController::class);
         Route::get('meetups', function () {
             return \App\Models\Meetup::query()
                                      ->with([
                                          'city',
                                      ])
                                      ->get()
                                      ->map(fn($meetup) => [
                                          'name'             => $meetup->name,
                                          'url'              => $meetup->telegram_link ?? $meetup->webpage,
                                          'top'              => $meetup->github_data['top'] ?? null,
                                          'left'             => $meetup->github_data['left'] ?? null,
                                          'country'          => str($meetup->city->country->code)->upper(),
                                          'state'            => $meetup->github_data['state'] ?? null,
                                          'city'             => $meetup->city->name,
                                          'longitude'        => (float) $meetup->city->longitude,
                                          'latitude'         => (float) $meetup->city->latitude,
                                          'twitter_username' => $meetup->twitter_username,
                                          'website'          => $meetup->webpage,
                                      ]);
         });
         Route::get('btc-map-communities', function () {
             return response()->json(\App\Models\Meetup::query()
                                                       ->with([
                                                           'media',
                                                           'city.country',
                                                       ])
                                                       ->where('community', '=', 'einundzwanzig')
                                                       ->when(app()->environment('production'),
                                                           fn($query) => $query->whereHas('city',
                                                               fn($query) => $query
                                                                   ->whereNotNull('cities.simplified_geojson')
                                                                   ->whereNotNull('cities.population')
                                                                   ->whereNotNull('cities.population_date')
                                                           ))
                                                       ->get()
                                                       ->map(fn($meetup) => [
                                                           'id'   => $meetup->slug,
                                                           'tags' => [
                                                               'type'             => 'community',
                                                               'name'             => $meetup->name,
                                                               'continent'        => 'europe',
                                                               'icon:square'      => $meetup->logoSquare,
                                                               //'contact:email'          => null,
                                                               'contact:twitter'  => 'https://twitter.com/'.$meetup->twitter_username,
                                                               'contact:website'  => $meetup->webpage,
                                                               'contact:telegram' => $meetup->telegram_link,
                                                               'contact:nostr'    => $meetup->nostr,
                                                               //'tips:lightning_address' => null,
                                                               'organization'     => 'einundzwanzig',
                                                               'language'         => $meetup->city->country->language_codes[0] ?? 'de',
                                                               'geo_json'         => $meetup->city->simplified_geojson,
                                                               'population'       => $meetup->city->population,
                                                               'population:date'  => $meetup->city->population_date,
                                                           ],
                                                       ])
                                                       ->toArray(), 200,
                 ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_SLASHES);
         });
     });

Route::get('/lnurl-auth-callback', function (Request $request) {
    if (lnurl\auth($request->k1, $request->sig, $request->key)) {
        // find User by $wallet_public_key
        if ($user = User::query()
                        ->where('change', $request->k1)
                        ->where('change_time', '>', now()->subMinutes(5))
                        ->first()) {
            $user->public_key = $request->key;
            $user->change = null;
            $user->change_time = null;
            $user->save();
        } else {
            $user = User::query()
                        ->whereBlind('public_key', 'public_key_index', $request->key)
                        ->first();
        }
        if (!$user) {
            $fakeName = str()->random(10);
            // create User
            $user = User::create([
                'public_key'  => $request->key,
                'is_lecturer' => true,
                'name'        => $fakeName,
                'email'       => str($request->key)->substr(-12).'@portal.einundzwanzig.space',
                'lnbits'      => [
                    'api_key'   => null,
                    'url'       => null,
                    'wallet_id' => null,
                ],
            ]);
            $user->ownedTeams()
                 ->save(Team::forceCreate([
                     'user_id'       => $user->id,
                     'name'          => $fakeName."'s Team",
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
