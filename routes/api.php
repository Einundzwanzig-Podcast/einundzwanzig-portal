<?php

use App\Models\EmailCampaign;
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
        Route::get('email-list/{id}', function ($id) {
            $campaign = EmailCampaign::query()->find($id);
            return \Illuminate\Support\Facades\Storage::disk('lists')->download($campaign->list_file_name);
        });
        Route::get('email-campaigns', \App\Http\Controllers\Api\EmailCampaignController::class);
        Route::post('email-campaigns', \App\Http\Controllers\Api\EmailCampaignGeneratorController::class);

        Route::resource('countries', \App\Http\Controllers\Api\CountryController::class);
        Route::resource('meetup', \App\Http\Controllers\Api\MeetupController::class);
        Route::resource('lecturers', \App\Http\Controllers\Api\LecturerController::class);
        Route::resource('courses', \App\Http\Controllers\Api\CourseController::class);
        Route::resource('cities', \App\Http\Controllers\Api\CityController::class);
        Route::resource('venues', \App\Http\Controllers\Api\VenueController::class);
        Route::resource('languages', \App\Http\Controllers\Api\LanguageController::class);
        Route::get('nostrplebs', function () {
            return User::query()
                ->select([
                    'email',
                    'public_key',
                    'lightning_address',
                    'lnurl',
                    'node_id',
                    'paynym',
                    'lnbits',
                    'nostr',
                    'id',
                ])
                ->whereNotNull('nostr')
                ->where('nostr', 'like', 'npub1%')
                ->orderByDesc('id')
                ->get()
                ->unique('nostr')
                ->pluck('nostr');
        });
        Route::get('bindles', function () {
            return \App\Models\LibraryItem::query()
                ->where('type', 'bindle')
                ->with([
                    'media',
                ])
                ->orderByDesc('id')
                ->get()
                ->map(fn($item) => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'link' => strtok($item->value, "?"),
                    'image' => $item->getFirstMediaUrl('main'),
                ]);
        });
        Route::get('meetups', function (Request $request) {
            return \App\Models\Meetup::query()
                ->where('visible_on_map', true)
                ->with([
                    'meetupEvents',
                    'city.country',
                    'media',
                ])
                ->get()
                ->map(fn($meetup) => [
                    'name' => $meetup->name,
                    'portalLink' => url()->route('meetup.landing', ['country' => $meetup->city->country, 'meetup' => $meetup]),
                    'url' => $meetup->telegram_link ?? $meetup->webpage,
                    'top' => $meetup->github_data['top'] ?? null,
                    'left' => $meetup->github_data['left'] ?? null,
                    'country' => str($meetup->city->country->code)->upper(),
                    'state' => $meetup->github_data['state'] ?? null,
                    'city' => $meetup->city->name,
                    'longitude' => (float)$meetup->city->longitude,
                    'latitude' => (float)$meetup->city->latitude,
                    'twitter_username' => $meetup->twitter_username,
                    'website' => $meetup->webpage,
                    'simplex' => $meetup->simplex,
                    'nostr' => $meetup->nostr,
                    'next_event' => $meetup->nextEvent,
                    'intro' => $request->has('withIntro') ? $meetup->intro : null,
                    'logo' => $request->has('withLogos') ? $meetup->getFirstMediaUrl('logo') : null,
                ]);
        });
        Route::get('meetup-events/{date?}', function ($date = null) {
            if ($date) {
                $date = \Carbon\Carbon::parse($date);
            }
            $events = \App\Models\MeetupEvent::query()
                ->with([
                    'meetup.city.country'
                ])
                ->when($date, fn($query) => $query
                    ->where('start', '>=', $date)
                    ->where('start', '<=', $date->copy()->endOfMonth())
                )
                ->get();

            return $events->map(fn($event) => [
                'start' => $event->start->format('Y-m-d H:i'),
                'location' => $event->location,
                'description' => $event->description,
                'link' => $event->link,
                'meetup.name' => $event->meetup->name,
                'meetup.portalLink' => url()->route('meetup.landing', ['country' => $event->meetup->city->country, 'meetup' => $event->meetup]),
                'meetup.url' => $event->meetup->telegram_link ?? $event->meetup->webpage,
                'meetup.country' => str($event->meetup->city->country->code)->upper(),
                'meetup.city' => $event->meetup->city->name,
                'meetup.longitude' => (float)$event->meetup->city->longitude,
                'meetup.latitude' => (float)$event->meetup->city->latitude,
                'meetup.twitter_username' => $event->meetup->twitter_username,
                'meetup.website' => $event->meetup->webpage,
                'meetup.simplex' => $event->meetup->simplex,
                'meetup.nostr' => $event->meetup->nostr,
            ]
            );
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
                    'id' => $meetup->slug,
                    'tags' => [
                        'type' => 'community',
                        'name' => $meetup->name,
                        'continent' => 'europe',
                        'icon:square' => $meetup->logoSquare,
                        //'contact:email'          => null,
                        'contact:twitter' => $meetup->twitter_username ? 'https://twitter.com/' . $meetup->twitter_username : null,
                        'contact:website' => $meetup->webpage,
                        'contact:telegram' => $meetup->telegram_link,
                        'contact:nostr' => $meetup->nostr,
                        //'tips:lightning_address' => null,
                        'organization' => 'einundzwanzig',
                        'language' => $meetup->city->country->language_codes[0] ?? 'de',
                        'geo_json' => $meetup->city->simplified_geojson,
                        'population' => $meetup->city->population,
                        'population:date' => $meetup->city->population_date,
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
                'public_key' => $request->key,
                'is_lecturer' => true,
                'name' => $fakeName,
                'email' => str($request->key)->substr(-12) . '@portal.einundzwanzig.space',
                'lnbits' => [
                    'read_key' => null,
                    'url' => null,
                    'wallet_id' => null,
                ],
            ]);
            $user->ownedTeams()
                ->save(Team::forceCreate([
                    'user_id' => $user->id,
                    'name' => $fakeName . "'s Team",
                    'personal_team' => true,
                ]));
        }
        // check if $k1 is in the database, if not, add it
        $loginKey = LoginKey::where('k1', $request->k1)
            ->first();
        if (!$loginKey) {
            LoginKey::create([
                'k1' => $request->k1,
                'user_id' => $user->id,
            ]);
        }

        return response()->json(['status' => 'OK']);
    }

    return response()->json(['status' => 'ERROR', 'reason' => 'Signature was NOT VERIFIED']);
})
    ->name('auth.ln.callback');
