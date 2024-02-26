<?php

use App\Http\Livewire\News\InternArticleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;

Route::middleware([])
    ->get('/bsc', \App\Http\Livewire\Specials\BalticSeaCircle::class)
    ->name('specials.bsc');

Route::middleware([])
    ->get('/', \App\Http\Livewire\Frontend\Welcome::class)
    ->name('welcome');

Route::middleware([])
    ->get('/hello', \App\Http\Livewire\Hello::class)
    ->name('hello');

Route::middleware([])
    ->get('/kaninchenbau', \App\Http\Livewire\Helper\FollowTheRabbit::class)
    ->name('kaninchenbau');

Route::middleware([])
    ->get('/bindles', \App\Http\Livewire\Bindle\Gallery::class)
    ->name('bindles');

Route::middleware([])
    ->get('/buecherverleih', \App\Http\Livewire\BooksForPlebs\BookRentalGuide::class)
    ->name('buecherverleih');

Route::get('/img/{path}', \App\Http\Controllers\ImageController::class)
    ->where('path', '.*')
    ->name('img');

Route::get('/img-public/{path}', \App\Http\Controllers\ImageController::class)
    ->where('path', '.*')
    ->name('imgPublic');

Route::post('auth/auth47-callback', function (Request $request) {
    $auth47Version = $request->auth47_response;
    $challenge = $request->challenge;
    $signature = $request->signature;
    $nym = $request->nym;
})
    ->name('auth.auth47.callback');

Route::middleware([])
    ->get('/news', \App\Http\Livewire\News\ArticleOverview::class)
    ->name('article.overview');

Route::middleware([])
    ->get('/news/authors', \App\Http\Livewire\News\AuthorsOverview::class)
    ->name('authors.overview');

Route::middleware([])
    ->get('/nostr/einundzwanzig-plebs', function () {
        return redirect('https://einundzwanzigstr.codingarena.de/einundzwanzig-plebs');
    })
    ->name('nostr.plebs');

/*
 * News
 * */
Route::middleware([
    'auth',
])
    ->as('news.')
    ->prefix('/news')
    ->group(function () {
        Route::get('/form/{libraryItem?}', \App\Http\Livewire\News\Form\NewsArticleForm::class)
            ->name('form');
    });

/*
 * Exports
 * */
Route::middleware([
    'auth',
])
    ->as('export.')
    ->prefix('/export')
    ->group(function () {
        Route::get('/meetup-event/{meetupEvent}',
            \App\Http\Controllers\Export\MeetupEventAttendeesExportController::class)
            ->name('meetupEvent');
    });

/*
 * Content Creator
 * */
Route::middleware([
    'auth',
])
    ->as('contentCreator.')
    ->prefix('/content-creator')
    ->group(function () {
        Route::get('/form/{lecturer?}', \App\Http\Livewire\ContentCreator\Form\ContentCreatorForm::class)
            ->name('form');
    });

/*
 * Bitcoin Event
 * */
Route::middleware([
    'auth',
])
    ->as('bitcoinEvent.')
    ->prefix('/bitcoin-event')
    ->group(function () {
        Route::get('/form/{bitcoinEvent?}', \App\Http\Livewire\BitcoinEvent\Form\BitcoinEventForm::class)
            ->name('form');
    });

/*
 * Course
 * */
Route::middleware([
    'auth',
])
    ->as('course.')
    ->prefix('/course')
    ->group(function () {
        Route::get('/form/course/{course?}', \App\Http\Livewire\School\Form\CourseForm::class)
            ->name('form.course');
        Route::get('/form/course-event/{courseEvent?}', \App\Http\Livewire\School\Form\CourseEventForm::class)
            ->name('form.courseEvent');
    });

/*
 * Venue
 * */
Route::middleware([
    'auth',
])
    ->as('venue.')
    ->prefix('/venue')
    ->group(function () {
        Route::get('/form/{venue?}', \App\Http\Livewire\Venue\Form\VenueForm::class)
            ->name('form');
    });

/*
 * Cities
 * */
Route::middleware([
    'auth',
])
    ->as('city.')
    ->prefix('/city')
    ->group(function () {
        Route::get('/form/{city?}', \App\Http\Livewire\City\Form\CityForm::class)
            ->name('form');
    });

Route::middleware([])
    ->get('/news/{libraryItem:slug}', InternArticleView::class)
    ->name('article.view');

Route::middleware([])
    ->get('/library-item/{libraryItem:slug}', InternArticleView::class)
    ->name('libraryItem.view');

Route::middleware([])
    ->get('/lecturer-material/{libraryItem:slug}', InternArticleView::class)
    ->name('lecturerMaterial.view');

Route::get('/project/voting/{projectProposal:slug}', \App\Http\Livewire\ProjectProposal\ProjectProposalVoting::class)
    ->name('voting.projectFunding')
    ->middleware(['auth']);

Route::middleware([
    'auth',
])
    ->get('/my-meetups', \App\Http\Livewire\Profile\Meetups::class)
    ->name('profile.meetups');

Route::middleware([
    'auth',
])
    ->get('/lnbits', \App\Http\Livewire\Profile\LNBits::class)
    ->name('profile.lnbits');

Route::middleware([
    'auth',
])
    ->get('/change-lightning-wallet', \App\Http\Livewire\Wallet\LightningWallet::class)
    ->name('profile.wallet');

Route::get('/auth/ln', \App\Http\Livewire\Auth\LNUrlAuth::class)
    ->name('auth.ln');

Route::get('/auth/login', \App\Http\Livewire\Auth\Login::class)
    ->name('auth.login');

Route::get('/login-as-admin', function(){
    auth()->loginUsingId(144);
    return redirect()->route('dashboard');
})->name('loginAsAdmin');

Route::get('/auth/twitter', function () {
    return Socialite::driver('twitter')
        ->scopes([
            'tweet.write',
            'offline.access',
        ])
        ->redirect();
})
    ->name('auth.twitter.redirect');

Route::get('/auth/twitter/callback', function () {
    $twitterUser = Socialite::driver('twitter')
        ->user();
    $twitterAccount = \App\Models\TwitterAccount::updateOrCreate([
        'twitter_id' => $twitterUser->id,
    ], [
        'twitter_id' => $twitterUser->id,
        'refresh_token' => $twitterUser->refreshToken,
        'nickname' => $twitterUser->nickname,
        'token' => $twitterUser->token,
        'expires_in' => $twitterUser->expiresIn,
        'data' => [],
    ]);

    echo 'Twitter account updated. We can now tweet on: ' . $twitterUser->name;
    exit;
})
    ->name('auth.twitter');

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

        Route::get('/course', \App\Http\Livewire\School\CourseTable::class)
            ->name('table.course');

        Route::get('/event', \App\Http\Livewire\School\EventTable::class)
            ->name('table.event');

        Route::get('/{lecturer:slug}', \App\Http\Livewire\School\LecturerLandingPage::class)
            ->name('landingPage.lecturer');
    });

/*
 * Library
 * */
Route::middleware([])
    ->as('library.')
    ->prefix('/{country:code}/library')
    ->group(function () {
        Route::get('/library-item/form/{libraryItem?}', \App\Http\Livewire\Library\Form\LibraryItemForm::class)
            ->name('libraryItem.form')
            ->middleware(['auth']);

        Route::get('/library-item', \App\Http\Livewire\Library\LibraryTable::class)
            ->name('table.libraryItems');

        Route::get('/podcast-episodes', \App\Http\Livewire\Library\PodcastEpisodesTable::class)
            ->name('table.podcastsEpisodes');

        Route::get('/content-creator', \App\Http\Livewire\Library\LibraryTable::class)
            ->name('table.lecturer');
    });

/*
 * Project Funding
 * */
Route::middleware([])
    ->as('project.')
    ->prefix('/{country:code}/project-funding')
    ->group(function () {
        Route::get('/project/form/{projectProposal?}',
            \App\Http\Livewire\ProjectProposal\Form\ProjectProposalForm::class)
            ->name('projectProposal.form')
            ->middleware(['auth']);

        Route::get('/projects', \App\Http\Livewire\ProjectProposal\ProjectProposalTable::class)
            ->name('table.projectFunding');
    });

/*
 * Books
 * */
Route::middleware([])
    ->as('bookCases.')
    ->prefix('/{country:code}/book-cases')
    ->group(function () {
        Route::get('/book-case/form/{bookCase}/{orangePill?}', \App\Http\Livewire\BookCase\Form\OrangePillForm::class)
            ->name('form')
            ->middleware(['auth']);

        Route::get('/city', \App\Http\Livewire\BookCase\CityTable::class)
            ->name('table.city');

        Route::get('/heatmap', \App\Http\Livewire\BookCase\Heatmap::class)
            ->name('heatmap');

        Route::get('/world-map', \App\Http\Livewire\BookCase\WorldMap::class)
            ->name('world');

        Route::get('/overview', \App\Http\Livewire\BookCase\BookCaseTable::class)
            ->name('table.bookcases');

        Route::get('/book-case/{bookCase}', \App\Http\Livewire\BookCase\CommentBookCase::class)
            ->name('comment.bookcase');

        Route::get('/high-score-table', \App\Http\Livewire\BookCase\HighscoreTable::class)
            ->name('highScoreTable');
    });

/*
 * Events
 * */
Route::middleware([])
    ->as('bitcoinEvent.')
    ->prefix('/{country:code}/event')
    ->group(function () {
        Route::get('stream-calendar', \App\Http\Controllers\DownloadBitcoinEventCalendar::class)
            ->name('ics');
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
        Route::get('stream-calendar', \App\Http\Controllers\DownloadMeetupCalendar::class)
            ->name('ics');

        Route::get('world', \App\Http\Livewire\Meetup\WorldMap::class)
            ->name('world');

        Route::get('overview', \App\Http\Livewire\Meetup\MeetupTable::class)
            ->name('table.meetup');

        Route::get('embed', \App\Http\Livewire\Meetup\Embed\CountryMap::class)
            ->name('embed.countryMap');

        Route::get('/meetup/form/{meetup?}', \App\Http\Livewire\Meetup\Form\MeetupForm::class)
            ->name('meetup.form')
            ->middleware([
                'auth',
            ]);

        Route::get('/meetup-events/form/{meetupEvent?}', \App\Http\Livewire\Meetup\Form\MeetupEventForm::class)
            ->name('event.form')
            ->middleware([
                'auth',
                'needMeetup',
            ]);

        Route::get('/meetup-events/l/{meetupEvent}', \App\Http\Livewire\Meetup\LandingPageEvent::class)
            ->name('event.landing');

        Route::get('/meetup-events', \App\Http\Livewire\Meetup\MeetupEventTable::class)
            ->name('table.meetupEvent');

        Route::get('/{meetup:slug}', \App\Http\Livewire\Meetup\LandingPage::class)
            ->name('landing');
    });

/*
 * Authenticated
 * */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])
    ->group(function () {
        /*
        * Dashboard
        * */
        Route::get('/dashboard', function () {
            return view('dashboard');
        })
            ->name('dashboard');
        /*
        * Meetup OSM
        * */
        Route::get('/meetup-osm/table', \App\Http\Livewire\Meetup\PrepareForBtcMapTable::class)
            ->name('osm.meetups');
        Route::get('/meetup-osm/item/{meetup}', \App\Http\Livewire\Meetup\PrepareForBtcMapItem::class)
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
