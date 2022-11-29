<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(5)
            ->withPersonalTeam()
            ->create();

        $this->call([
            CountrySeeder::class,
            CitySeeder::class,
            LecturerSeeder::class,
        ]);
    }
}
