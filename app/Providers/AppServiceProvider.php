<?php

namespace App\Providers;

use App\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Spatie\Translatable\Facades\Translatable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Date::use(
            Carbon::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(app()->environment('local'));

        Stringable::macro('initials', function () {
            $words = preg_split("/\s+/", $this);
            $initials = '';

            foreach ($words as $w) {
                $initials .= $w[0];
            }

            return new static($initials);
        });
        Str::macro('initials', function (string $string) {
            return (string) (new Stringable($string))->initials();
        });

        Translatable::fallback(
            fallbackAny: true,
        );
    }
}
