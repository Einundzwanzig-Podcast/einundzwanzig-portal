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
use JoeDixon\Translation\Console\Commands\SynchroniseMissingTranslationKeys;
use Spatie\Permission\Models\Permission;
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
        Permission::create([
            'name'       => 'translate',
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
        $user->givePermissionTo('translate');
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
        Country::create([
            'name'           => 'Serbia',
            'code'           => 'rs',
            'language_codes' => ['rs'],
            'longitude'      => 21,
            'latitude'       => 44,
        ]);
        City::create([
            'country_id' => 1,
            'name'       => 'Füssen',
            'latitude'   => 47.57143,
            'longitude'  => 10.70171,
            'created_by' => 1,
        ]);
        City::create([
            'country_id' => 1,
            'name'       => 'Kempten',
            'latitude'   => 47.728569,
            'longitude'  => 10.315784,
            'created_by' => 1,
        ]);
        City::create([
            'country_id' => 1,
            'name'       => 'Pfronten',
            'latitude'   => 47.582359,
            'longitude'  => 10.5598,
            'created_by' => 1,
        ]);
        City::create([
            'country_id' => 2,
            'name'       => 'Wien',
            'latitude'   => 48.20835,
            'longitude'  => 16.37250,
            'created_by' => 1,
        ]);
        City::create([
            'country_id' => 3,
            'name'       => 'Zürich',
            'latitude'   => 47.41330,
            'longitude'  => 8.65639,
            'created_by' => 1,
        ]);
        Venue::create([
            'city_id'    => 1,
            'name'       => 'The Blue Studio Coworking (Füssen)',
            'street'     => 'Teststraße 1',
            'created_by' => 1,
        ]);
        Venue::create([
            'city_id'    => 2,
            'name'       => 'The Blue Studio Coworking (Kempten)',
            'street'     => 'Teststraße 2',
            'created_by' => 1,
        ]);
        Venue::create([
            'city_id'    => 3,
            'name'       => 'The Blue Studio Coworking (Pfronten)',
            'street'     => 'Teststraße 3',
            'created_by' => 1,
        ]);
        Venue::create([
            'city_id'    => 4,
            'name'       => 'Innsbruck',
            'street'     => 'Innsbrucker Straße 1',
            'created_by' => 1,
        ]);
        Lecturer::create([
            'team_id'    => 1,
            'name'       => 'Markus Turm',
            'active'     => true,
            'created_by' => 1,
        ]);
        Lecturer::create([
            'team_id'    => 1,
            'name'       => 'Beppo',
            'active'     => true,
            'created_by' => 1,
        ]);
        Lecturer::create([
            'team_id'    => 1,
            'name'       => 'Helper',
            'active'     => true,
            'created_by' => 1,
        ]);
        Lecturer::create([
            'team_id'    => 1,
            'name'       => 'Gigi',
            'active'     => true,
            'created_by' => 1,
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
            'description' => '
Klimakiller Bitcoin! Bitcoin hat keinen Nutzen! Bitcoin wird nur von Kriminellen genutzt!

Diese oder ähnliche Aussprüche kennen Sie bestimmt? Dann lassen Sie uns Bitcoin doch einmal genauer anschauen! In meinem Kurs nehme ich Sie mit auf einen Weg der bei der Geschichte unseres Geldes beginnt. Lassen Sie uns schauen wie unser Geld entsteht und welche Aufgaben dabei Geschäftsbanken und Zentralbanken haben. Welche Rolle spielt eigentlich das Jahr 1971 und welche Auswirkungen hatte dies auf unser Geld wie wir es heute verwenden. Was hat die Banken- und Finanzkrise 2008/ 2009 mit Bitcoin und Neuseeland mit unserer Inflation zu tun?

Was ist eigentlich dieses Bitcoin? Wer hat es erfunden und warum? Lassen Sie uns schauen, was eine Blockchain überhaupt ist und wie sie funktioniert- warum ist es wichtig, dass hierfür Energie eingesetzt wird. Was ist eigentlich dieses Proof of Work von dem immer geschrieben wird und warum ist er so wichtig? Und ist Bitcoin vielleicht sogar ein Treiber im Ausbau der erneuerbaren Energien bei? Sie haben schonmal von Minern gehört und vielleicht sogar von Nodes? Doch welche Rolle spielen Sie und wie sehen diese eigentlich aus- auch das können Sie in diesem Kurs herausfinden.

Bitcoin wird nur von Kriminellen genutzt? Lassen Sie uns gemeinsam schauen wie eine Bitcoin Transaktion funktioniert und was eine sog. „Wallet“ ist. Welche Unterschiede gibt es beim Verwahren von Bitcoin und wie können diese sicher vererbt werden. Dabei werden wir auch Begriffe wie PrivateKey, PublicKey und Seed kennenlernen und wie diese zusammenspielen. Und nein- sie müssen für diesen Kurs kein Informatikstudium besitzen!

Bitcoin ist interdisziplinär! Und wer anfängt sich damit zu beschäftigen wird schnell feststellen, dass es mehrere hundert Stunden benötigt, um Bitcoin zu verstehen.

Deshalb werden Sie von mir in diesem Kurs leicht verständlich an das Thema herangeführt. Sie erhalten dabei Kenntnis von den Grundbegriffen, der Funktion und der Verwendung von Bitcoin.
',
        ]);
        $course->syncTagsWithType(['Hardware Wallet'], 'course');
        $course->categories()
               ->attach($category);
        $course = Course::create([
            'lecturer_id' => 1,
            'name'        => 'Bitcoin <> Crypto',
            'created_by'  => 1,
            'description' => '
Klimakiller Bitcoin! Bitcoin hat keinen Nutzen! Bitcoin wird nur von Kriminellen genutzt!

Diese oder ähnliche Aussprüche kennen Sie bestimmt? Dann lassen Sie uns Bitcoin doch einmal genauer anschauen! In meinem Kurs nehme ich Sie mit auf einen Weg der bei der Geschichte unseres Geldes beginnt. Lassen Sie uns schauen wie unser Geld entsteht und welche Aufgaben dabei Geschäftsbanken und Zentralbanken haben. Welche Rolle spielt eigentlich das Jahr 1971 und welche Auswirkungen hatte dies auf unser Geld wie wir es heute verwenden. Was hat die Banken- und Finanzkrise 2008/ 2009 mit Bitcoin und Neuseeland mit unserer Inflation zu tun?

Was ist eigentlich dieses Bitcoin? Wer hat es erfunden und warum? Lassen Sie uns schauen, was eine Blockchain überhaupt ist und wie sie funktioniert- warum ist es wichtig, dass hierfür Energie eingesetzt wird. Was ist eigentlich dieses Proof of Work von dem immer geschrieben wird und warum ist er so wichtig? Und ist Bitcoin vielleicht sogar ein Treiber im Ausbau der erneuerbaren Energien bei? Sie haben schonmal von Minern gehört und vielleicht sogar von Nodes? Doch welche Rolle spielen Sie und wie sehen diese eigentlich aus- auch das können Sie in diesem Kurs herausfinden.

Bitcoin wird nur von Kriminellen genutzt? Lassen Sie uns gemeinsam schauen wie eine Bitcoin Transaktion funktioniert und was eine sog. „Wallet“ ist. Welche Unterschiede gibt es beim Verwahren von Bitcoin und wie können diese sicher vererbt werden. Dabei werden wir auch Begriffe wie PrivateKey, PublicKey und Seed kennenlernen und wie diese zusammenspielen. Und nein- sie müssen für diesen Kurs kein Informatikstudium besitzen!

Bitcoin ist interdisziplinär! Und wer anfängt sich damit zu beschäftigen wird schnell feststellen, dass es mehrere hundert Stunden benötigt, um Bitcoin zu verstehen.

Deshalb werden Sie von mir in diesem Kurs leicht verständlich an das Thema herangeführt. Sie erhalten dabei Kenntnis von den Grundbegriffen, der Funktion und der Verwendung von Bitcoin.
',
        ]);
        $course->syncTagsWithType(['Lightning'], 'course');
        $course->categories()
               ->attach($categoryOnline);
        $course = Course::create([
            'lecturer_id' => 2,
            'name'        => 'Bitcoin Lightning Network',
            'created_by'  => 1,
            'description' => '
Klimakiller Bitcoin! Bitcoin hat keinen Nutzen! Bitcoin wird nur von Kriminellen genutzt!

Diese oder ähnliche Aussprüche kennen Sie bestimmt? Dann lassen Sie uns Bitcoin doch einmal genauer anschauen! In meinem Kurs nehme ich Sie mit auf einen Weg der bei der Geschichte unseres Geldes beginnt. Lassen Sie uns schauen wie unser Geld entsteht und welche Aufgaben dabei Geschäftsbanken und Zentralbanken haben. Welche Rolle spielt eigentlich das Jahr 1971 und welche Auswirkungen hatte dies auf unser Geld wie wir es heute verwenden. Was hat die Banken- und Finanzkrise 2008/ 2009 mit Bitcoin und Neuseeland mit unserer Inflation zu tun?

Was ist eigentlich dieses Bitcoin? Wer hat es erfunden und warum? Lassen Sie uns schauen, was eine Blockchain überhaupt ist und wie sie funktioniert- warum ist es wichtig, dass hierfür Energie eingesetzt wird. Was ist eigentlich dieses Proof of Work von dem immer geschrieben wird und warum ist er so wichtig? Und ist Bitcoin vielleicht sogar ein Treiber im Ausbau der erneuerbaren Energien bei? Sie haben schonmal von Minern gehört und vielleicht sogar von Nodes? Doch welche Rolle spielen Sie und wie sehen diese eigentlich aus- auch das können Sie in diesem Kurs herausfinden.

Bitcoin wird nur von Kriminellen genutzt? Lassen Sie uns gemeinsam schauen wie eine Bitcoin Transaktion funktioniert und was eine sog. „Wallet“ ist. Welche Unterschiede gibt es beim Verwahren von Bitcoin und wie können diese sicher vererbt werden. Dabei werden wir auch Begriffe wie PrivateKey, PublicKey und Seed kennenlernen und wie diese zusammenspielen. Und nein- sie müssen für diesen Kurs kein Informatikstudium besitzen!

Bitcoin ist interdisziplinär! Und wer anfängt sich damit zu beschäftigen wird schnell feststellen, dass es mehrere hundert Stunden benötigt, um Bitcoin zu verstehen.

Deshalb werden Sie von mir in diesem Kurs leicht verständlich an das Thema herangeführt. Sie erhalten dabei Kenntnis von den Grundbegriffen, der Funktion und der Verwendung von Bitcoin.
',
        ]);
        $course->syncTagsWithType(['Für Unternehmen'], 'course');
        $course->categories()
               ->attach($categoryOnline);
        Participant::create([
            'first_name' => 'Roman',
            'last_name'  => 'Reher',
        ]);
        CourseEvent::create([
            'course_id'  => 2,
            'venue_id'   => 1,
            'link'       => 'https://einundzwanzig.space',
            'from'       => now()
                ->addDays(14)
                ->startOfDay(),
            'to'         => now()
                ->addDays(14)
                ->startOfDay()
                ->addHour(),
            'created_by' => 1,
        ]);
        CourseEvent::create([
            'course_id'  => 1,
            'venue_id'   => 2,
            'link'       => 'https://einundzwanzig.space',
            'from'       => now()
                ->addDays(3)
                ->startOfDay(),
            'to'         => now()
                ->addDays(3)
                ->startOfDay()
                ->addHour(),
            'created_by' => 1,
        ]);
        CourseEvent::create([
            'course_id'  => 1,
            'venue_id'   => 3,
            'link'       => 'https://einundzwanzig.space',
            'from'       => now()
                ->addDays(4)
                ->startOfDay(),
            'to'         => now()
                ->addDays(4)
                ->startOfDay()
                ->addHour(),
            'created_by' => 1,
        ]);
        CourseEvent::create([
            'course_id'  => 3,
            'venue_id'   => 3,
            'link'       => 'https://einundzwanzig.space',
            'from'       => now()
                ->addDays(4)
                ->startOfDay(),
            'to'         => now()
                ->addDays(4)
                ->startOfDay()
                ->addHour(),
            'created_by' => 1,
        ]);
        Registration::create([
            'course_event_id' => 1,
            'participant_id'  => 1,
        ]);
        $library = Library::create([
            'name'           => 'Einundzwanzig',
            'language_codes' => ['de'],
            'created_by'     => 1,
        ]);
        $libraryItem = LibraryItem::create([
            'lecturer_id'   => 3,
            'name'          => 'BITCOIN - Eine Reise in den Kaninchenbau🐇🕳️',
            'type'          => 'youtube_video',
            'language_code' => 'de',
            'value'         => 'https://www.youtube.com/watch?v=Oztd2Sja4k0',
            'created_by'    => 1,
        ]);
        $libraryItem->setStatus('published');
        $libraryItem->syncTagsWithType(['Bitcoin'], 'library_item');
        $library->libraryItems()
                ->attach($libraryItem);
        $library = Library::create([
            'name'           => 'Apricot',
            'language_codes' => ['de', 'en'],
            'created_by'     => 1,
        ]);
        $libraryItem = LibraryItem::create([
            'lecturer_id'   => 4,
            'name'          => 'Liebe Krypto- und Fiat-Bros️',
            'type'          => 'blog_article',
            'language_code' => 'de',
            'value'         => 'https://aprycot.media/blog/liebe-krypto-und-fiat-bros/',
            'created_by'    => 1,
        ]);
        $libraryItem->setStatus('published');
        $libraryItem->syncTagsWithType(['Bitcoin'], 'library_item');
        $library->libraryItems()
                ->attach($libraryItem);
        $library = Library::create([
            'name'           => 'Gigi',
            'language_codes' => ['de', 'en'],
            'created_by'     => 1,
        ]);
        $libraryItem = LibraryItem::create([
            'lecturer_id'   => 4,
            'name'          => 'Cryptography is Not Enough - Gigi @ Baltic Honeybadger 2022 ',
            'type'          => 'youtube_video',
            'language_code' => 'de',
            'value'         => 'https://www.youtube.com/watch?v=C7ynm0Zkwfk',
            'created_by'    => 1,
        ]);
        $libraryItem->setStatus('published');
        $libraryItem->syncTagsWithType(['Proof of Work'], 'library_item');
        $library->libraryItems()
                ->attach($libraryItem);
        $nonPublicLibrary = Library::create([
            'name'           => 'Einundzwanzig Dozenten',
            'is_public'      => false,
            'language_codes' => ['de', 'en'],
            'created_by'     => 1,
        ]);
        $libraryItem = LibraryItem::create([
            'lecturer_id'   => 4,
            'name'          => 'Präsentation: Bitcoin VHS Kurs 2022',
            'type'          => 'downloadable_file',
            'language_code' => 'de',
            'value'         => null,
            'created_by'    => 1,
        ]);
        $libraryItem->setStatus('published');
        $libraryItem->syncTagsWithType(['Präsentationen'], 'library_item');
        $nonPublicLibrary->libraryItems()
                         ->attach($libraryItem);
        Artisan::call(ReadAndSyncEinundzwanzigPodcastFeed::class);
        Artisan::call(SyncOpenBooks::class);
        Meetup::create([
            'city_id'    => 1,
            'name'       => 'Einundzwanzig ' . str()->random(5),
            'telegram_link'       => 'https://t.me/EinundzwanzigKempten',
            'created_by' => 1,
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
        MeetupEvent::create([
            'meetup_id'   => 1,
            'start'       => now()
                ->subDays(2)
                ->startOfDay()
                ->addHours(20),
            'location'    => 'Einundzwanzig Kempten',
            'description' => fake()->text(),
            'link'        => 'https://t.me/EinundzwanzigKempten',
            'created_by'  => 1,
        ]);
        Meetup::create([
            'city_id'    => 2,
            'name'       => 'Einundzwanzig ' . str()->random(5),
            'telegram_link'       => 'https://t.me/EinundzwanzigKempten',
            'created_by' => 1,
        ]);
        Meetup::create([
            'city_id'    => 3,
            'name'       => 'Einundzwanzig ' . str()->random(5),
            'telegram_link'       => 'https://t.me/EinundzwanzigKempten',
            'created_by' => 1,
        ]);
        Meetup::create([
            'city_id'    => 1,
            'name'       => 'Einundzwanzig ' . str()->random(5),
            'telegram_link'       => 'https://t.me/EinundzwanzigKempten',
            'created_by' => 1,
        ]);
        Meetup::create([
            'city_id'    => 1,
            'name'       => 'Einundzwanzig ' . str()->random(5),
            'telegram_link'       => 'https://t.me/EinundzwanzigKempten',
            'created_by' => 1,
        ]);
        Meetup::create([
            'city_id'    => 1,
            'name'       => 'Einundzwanzig ' . str()->random(5),
            'telegram_link'       => 'https://t.me/EinundzwanzigKempten',
            'created_by' => 1,
        ]);
        Meetup::create([
            'city_id'    => 1,
            'name'       => 'Einundzwanzig ' . str()->random(5),
            'telegram_link'       => 'https://t.me/EinundzwanzigKempten',
            'created_by' => 1,
        ]);
        Meetup::create([
            'city_id'    => 1,
            'name'       => 'Einundzwanzig ' . str()->random(5),
            'telegram_link'       => 'https://t.me/EinundzwanzigKempten',
            'created_by' => 1,
        ]);
        Meetup::create([
            'city_id'    => 1,
            'name'       => 'Einundzwanzig ' . str()->random(5),
            'telegram_link'       => 'https://t.me/EinundzwanzigKempten',
            'created_by' => 1,
        ]);
        Meetup::create([
            'city_id'    => 1,
            'name'       => 'Einundzwanzig ' . str()->random(5),
            'telegram_link'       => 'https://t.me/EinundzwanzigKempten',
            'created_by' => 1,
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
        Artisan::call(SynchroniseMissingTranslationKeys::class);
    }
}
