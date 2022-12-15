<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Console\Commands\Database\CreateTags;
use App\Console\Commands\Feed\ReadAndSyncEinundzwanzigPodcastFeed;
use App\Console\Commands\OpenBooks\SyncOpenBooks;
use App\Models\BitcoinEvent;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\Lecturer;
use App\Models\Library;
use App\Models\LibraryItem;
use App\Models\Meetup;
use App\Models\MeetupEvent;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\Team;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        Artisan::call(CreateTags::class);
        Role::create([
            'name'       => 'super-admin',
            'guard_name' => 'web',
        ]);
        $user = User::create([
            'name'              => 'Admin',
            'email'             => 'admin@einundzwanzig.space',
            'email_verified_at' => now(),
            'password'          => bcrypt('1234'),
            'remember_token'    => Str::random(10),
            'is_lecturer'       => true,
        ]);
        $team = Team::create([
            'name'          => 'Admin Team',
            'user_id'       => $user->id,
            'personal_team' => true,
        ]);
        $user->current_team_id = $team->id;
        $user->save();
        Country::create([
            'name'           => 'Deutschland',
            'code'           => 'de',
            'language_codes' => ['de'],
        ]);
        Country::create([
            'name'           => 'Österreich',
            'code'           => 'at',
            'language_codes' => ['de'],
        ]);
        Country::create([
            'name'           => 'Schweiz',
            'code'           => 'ch',
            'language_codes' => ['de'],
        ]);
        Country::create([
            'name'           => 'France',
            'code'           => 'fr',
            'language_codes' => ['fr'],
        ]);
        City::create([
            'country_id' => 1,
            'name'       => 'Füssen',
            'latitude'   => 47.57143,
            'longitude'  => 10.70171,
            'created_by'  => 1,
        ]);
        City::create([
            'country_id' => 1,
            'name'       => 'Kempten',
            'latitude'   => 47.728569,
            'longitude'  => 10.315784,
            'created_by'  => 1,
        ]);
        City::create([
            'country_id' => 1,
            'name'       => 'Pfronten',
            'latitude'   => 47.582359,
            'longitude'  => 10.5598,
            'created_by'  => 1,
        ]);
        City::create([
            'country_id' => 2,
            'name'       => 'Wien',
            'latitude'   => 48.20835,
            'longitude'  => 16.37250,
            'created_by'  => 1,
        ]);
        City::create([
            'country_id' => 3,
            'name'       => 'Zürich',
            'latitude'   => 47.41330,
            'longitude'  => 8.65639,
            'created_by'  => 1,
        ]);
        Venue::create([
            'city_id' => 1,
            'name'    => 'The Blue Studio Coworking (Füssen)',
            'street'  => 'Teststraße 1',
            'created_by'  => 1,
        ]);
        Venue::create([
            'city_id' => 2,
            'name'    => 'The Blue Studio Coworking (Kempten)',
            'street'  => 'Teststraße 2',
            'created_by'  => 1,
        ]);
        Venue::create([
            'city_id' => 3,
            'name'    => 'The Blue Studio Coworking (Pfronten)',
            'street'  => 'Teststraße 3',
            'created_by'  => 1,
        ]);
        Venue::create([
            'city_id' => 4,
            'name'    => 'Innsbruck',
            'street'  => 'Innsbrucker Straße 1',
            'created_by'  => 1,
        ]);
        Lecturer::create([
            'team_id' => 1,
            'name'    => 'Markus Turm',
            'active'  => true,
            'created_by'  => 1,
        ]);
        Lecturer::create([
            'team_id' => 1,
            'name'    => 'Beppo',
            'active'  => true,
            'created_by'  => 1,
        ]);
        Lecturer::create([
            'team_id' => 1,
            'name'    => 'Helper',
            'active'  => true,
            'created_by'  => 1,
        ]);
        Lecturer::create([
            'team_id' => 1,
            'name'    => 'Gigi',
            'active'  => true,
            'created_by'  => 1,
        ]);
        $category = Category::create([
            'name' => 'Präsenzunterricht',
            'slug' => str('Präsenzunterricht')->slug('-', 'de'),
        ]);
        $categoryOnline = Category::create([
            'name' => 'Online-Kurs',
            'slug' => str('Online-Kurs')->slug('-', 'de'),
        ]);
        $course = Course::create([
            'lecturer_id' => 1,
            'name'        => 'Hands on Bitcoin',
            'created_by'  => 1,
        ]);
        $course->syncTagsWithType(['Hardware Wallet'], 'course');
        $course->categories()
               ->attach($category);
        $course = Course::create([
            'lecturer_id' => 1,
            'name'        => 'Bitcoin <> Crypto',
            'created_by'  => 1,
        ]);
        $course->syncTagsWithType(['Lightning'], 'course');
        $course->categories()
               ->attach($categoryOnline);
        $course = Course::create([
            'lecturer_id' => 2,
            'name'        => 'Bitcoin Lightning Network',
            'created_by'  => 1,
        ]);
        $course->syncTagsWithType(['Für Unternehmen'], 'course');
        $course->categories()
               ->attach($categoryOnline);
        Participant::create([
            'first_name' => 'Roman',
            'last_name'  => 'Reher',
        ]);
        CourseEvent::create([
            'course_id' => 2,
            'venue_id'  => 1,
            'link'      => 'https://einundzwanzig.space',
            'from'      => now()
                ->addDays(14)
                ->startOfDay(),
            'to'        => now()
                ->addDays(14)
                ->startOfDay()
                ->addHour(),
            'created_by'  => 1,
        ]);
        CourseEvent::create([
            'course_id' => 1,
            'venue_id'  => 2,
            'link'      => 'https://einundzwanzig.space',
            'from'      => now()
                ->addDays(3)
                ->startOfDay(),
            'to'        => now()
                ->addDays(3)
                ->startOfDay()
                ->addHour(),
            'created_by'  => 1,
        ]);
        CourseEvent::create([
            'course_id' => 1,
            'venue_id'  => 3,
            'link'      => 'https://einundzwanzig.space',
            'from'      => now()
                ->addDays(4)
                ->startOfDay(),
            'to'        => now()
                ->addDays(4)
                ->startOfDay()
                ->addHour(),
            'created_by'  => 1,
        ]);
        CourseEvent::create([
            'course_id' => 3,
            'venue_id'  => 3,
            'link'      => 'https://einundzwanzig.space',
            'from'      => now()
                ->addDays(4)
                ->startOfDay(),
            'to'        => now()
                ->addDays(4)
                ->startOfDay()
                ->addHour(),
            'created_by'  => 1,
        ]);
        Registration::create([
            'course_event_id' => 1,
            'participant_id'  => 1,
        ]);
        $library = Library::create([
            'name'           => 'Einundzwanzig',
            'language_codes' => ['de'],
            'created_by'  => 1,
        ]);
        $libraryItem = LibraryItem::create([
            'lecturer_id'   => 3,
            'name'          => 'BITCOIN - Eine Reise in den Kaninchenbau🐇🕳️',
            'type'          => 'youtube_video',
            'language_code' => 'de',
            'value'         => 'https://www.youtube.com/watch?v=Oztd2Sja4k0',
            'created_by'  => 1,
        ]);
        $libraryItem->syncTagsWithType(['Bitcoin'], 'library_item');
        $library->libraryItems()
                ->attach($libraryItem);
        $library = Library::create([
            'name'           => 'Apricot',
            'language_codes' => ['de', 'en'],
            'created_by'  => 1,
        ]);
        $libraryItem = LibraryItem::create([
            'lecturer_id'   => 4,
            'name'          => 'Liebe Krypto- und Fiat-Bros️',
            'type'          => 'blog_article',
            'language_code' => 'de',
            'value'         => 'https://aprycot.media/blog/liebe-krypto-und-fiat-bros/',
            'created_by'  => 1,
        ]);
        $libraryItem->syncTagsWithType(['Bitcoin'], 'library_item');
        $library->libraryItems()
                ->attach($libraryItem);
        $library = Library::create([
            'name'           => 'Gigi',
            'language_codes' => ['de', 'en'],
            'created_by'  => 1,
        ]);
        $libraryItem = LibraryItem::create([
            'lecturer_id'   => 4,
            'name'          => 'Cryptography is Not Enough - Gigi @ Baltic Honeybadger 2022 ',
            'type'          => 'youtube_video',
            'language_code' => 'de',
            'value'         => 'https://www.youtube.com/watch?v=C7ynm0Zkwfk',
            'created_by'  => 1,
        ]);
        $libraryItem->syncTagsWithType(['Proof of Work'], 'library_item');
        $library->libraryItems()
                ->attach($libraryItem);
        $nonPublicLibrary = Library::create([
            'name'           => 'Einundzwanzig Dozenten',
            'is_public'      => false,
            'language_codes' => ['de', 'en'],
            'created_by'  => 1,
        ]);
        $libraryItem = LibraryItem::create([
            'lecturer_id'   => 4,
            'name'          => 'Präsentation: Bitcoin VHS Kurs 2022',
            'type'          => 'downloadable_file',
            'language_code' => 'de',
            'value'         => null,
            'created_by'  => 1,
        ]);
        $libraryItem->syncTagsWithType(['Präsentationen'], 'library_item');
        $nonPublicLibrary->libraryItems()
                         ->attach($libraryItem);
        Artisan::call(ReadAndSyncEinundzwanzigPodcastFeed::class);
        Artisan::call(SyncOpenBooks::class);
        Meetup::create([
            'city_id' => 1,
            'name'    => 'Einundzwanzig Kempten',
            'link'    => 'https://t.me/EinundzwanzigKempten',
            'created_by'  => 1,
        ]);
        MeetupEvent::create([
            'meetup_id'   => 1,
            'start'       => now()
                ->addDays(2)
                ->startOfDay()
                ->addHours(20),
            'location'    => 'Einundzwanzig Kempten',
            'description' => fake()->text(),
            'link'        => 'https://t.me/EinundzwanzigKempten',
            'created_by'  => 1,
        ]);
        BitcoinEvent::create([
            'venue_id'    => 4,
            'from'        => Carbon::parse('2023-09-12')
                                   ->startOfDay()
                                   ->addHours(8),
            'to'          => Carbon::parse('2023-09-16')
                                   ->startOfDay()
                                   ->addHours(18),
            'title'       => 'BTC23',
            'description' => 'The largest Bitcoin conference in German is entering the second round: The BTC23 will be even better, more diverse and quite controversial. We are open - for Bitcoiners, interested parties and skeptics from all directions. Three days with bitcoiners, thought leaders and entrepreneurs from space - full of relevant lectures, debates and conversations. And of course parties! The following applies: The BTC23 is there for everyone, no matter what level of knowledge you have on the subject. #bitcoinonly

Advance ticket sales begin on December 21, 2022 at 9:21 p.m. with time-limited early bird tickets.

Ticket presale begins on December 21, 2022 at 9:21 p.m. Be quick - there are a limited amount of early bird tickets again.
',
            'link'        => 'https://bconf.de/en/',
            'created_by'  => 1,
        ]);
    }
}
