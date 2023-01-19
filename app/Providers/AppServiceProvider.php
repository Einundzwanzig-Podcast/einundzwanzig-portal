<?php

namespace App\Providers;

use App\Models\Episode;
use App\Observers\EpisodeObserver;
use App\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        Date::use(
            Carbon::class
        );
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        //Model::preventLazyLoading();

        Stringable::macro('initials', function () {
            $words = preg_split("/\s+/", $this);
            $initials = "";

            foreach ($words as $w) {
                $initials .= $w[0];
            }

            return new static($initials);
        });
        Str::macro('initials', function (string $string) {
            return (string) (new Stringable($string))->initials();
        });
    }
}
