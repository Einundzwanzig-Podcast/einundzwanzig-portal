<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Course;
use App\Models\Event;
use App\Models\Lecturer;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\Team;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'              => 'Admin',
            'email'             => 'admin@einundzwanzig.space',
            'email_verified_at' => now(),
            'password'          => bcrypt('1234'),
            'remember_token'    => Str::random(10),
        ]);
        Team::create([
            'name'          => 'Admin Team',
            'user_id'       => $user->id,
            'personal_team' => true,
        ]);
        Country::create([
            'name' => 'Deutschland',
            'code' => 'de',
        ]);
        City::create([
            'country_id' => 1,
            'name'       => 'Füssen',
        ]);
        Venue::create([
            'city_id' => 1,
            'name'    => 'The Blue Studio Coworking',
            'slug'    => str('The Blue Studio Coworking')->slug('-', 'de'),
            'street'  => 'Teststraße 12',
        ]);
        Lecturer::create([
            'team_id' => 1,
            'name'    => 'Markus Turm',
            'slug'    => str('Markus Turm')->slug('-', 'de'),
            'active'  => true,
        ]);
        $category = Category::create([
            'name' => 'Präsenzunterricht',
            'slug' => str('Präsenzunterricht')->slug('-', 'de'),
        ]);
        Category::create([
            'name' => 'Online-Kurs',
            'slug' => str('Online-Kurs')->slug('-', 'de'),
        ]);
        $course = Course::create([
            'lecturer_id' => 1,
            'name'        => 'Hands on Bitcoin',
        ]);
        $course->categories()
               ->attach($category);
        Participant::create([
            'first_name' => 'Roman',
            'last_name'  => 'Reher',
        ]);
        Event::create([
            'course_id' => 1,
            'venue_id'  => 1,
            'from'      => now()->addDays(10),
            'to'        => now()
                ->addDays(10)
                ->addHour(),
        ]);
        Registration::create([
            'event_id'       => 1,
            'participant_id' => 1,
        ]);
    }
}
