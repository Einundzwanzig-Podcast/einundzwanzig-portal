<?php

namespace App\Providers;

use App\Nova\Category;
use App\Nova\City;
use App\Nova\Country;
use App\Nova\Course;
use App\Nova\Dashboards\Main;
use App\Nova\Episode;
use App\Nova\Event;
use App\Nova\Lecturer;
use App\Nova\Library;
use App\Nova\LibraryItem;
use App\Nova\Participant;
use App\Nova\Podcast;
use App\Nova\Registration;
use App\Nova\Tag;
use App\Nova\Team;
use App\Nova\User;
use App\Nova\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Itsmejoshua\Novaspatiepermissions\Novaspatiepermissions;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)
                           ->icon('lightning-bolt'),

                MenuSection::make('Schule', [
                    MenuItem::resource(City::class),
                    MenuItem::resource(Venue::class),
                    MenuItem::resource(Lecturer::class),
                    MenuItem::resource(Course::class),
                    MenuItem::resource(Event::class),
                    MenuItem::resource(Participant::class),
                    MenuItem::resource(Registration::class),
                ])
                           ->icon('academic-cap')
                           ->collapsable(),

                MenuSection::make('Bibliothek', [
                    MenuItem::resource(Library::class),
                    MenuItem::resource(LibraryItem::class),
                ])
                           ->icon('library')
                           ->collapsable(),

                MenuSection::make('Podcasts', [
                    MenuItem::resource(Podcast::class),
                    MenuItem::resource(Episode::class),
                ])
                           ->icon('microphone')
                           ->collapsable(),

                MenuSection::make('Admin', [
                    MenuItem::resource(Category::class),
                    MenuItem::resource(Country::class),
                    MenuItem::resource(Team::class),
                    MenuItem::resource(User::class),
                    MenuItem::resource(Tag::class),
                ])
                           ->icon('key')
                           ->collapsable(),

                MenuSection::make(__('nova-spatie-permissions::lang.sidebar_label'), [
                    MenuItem::link(__('nova-spatie-permissions::lang.sidebar_label_roles'), 'resources/roles'),
                    MenuItem::link(__('nova-spatie-permissions::lang.sidebar_label_permissions'),
                        'resources/permissions'),
                ])
                           ->icon('key')
                           ->collapsable(),
            ];
        });

        Nova::withBreadcrumbs();

        // disable theme switcher
        Nova::withoutThemeSwitcher();

        // login with user id 1, if we are in local environment
//        if (app()->environment('local')) {
//            auth()->loginUsingId(1);
//        }

        Nova::footer(function ($request) {
            // return MIT license and date
            return sprintf("%s %s - %s", date('Y'), config('app.name'), __('MIT License'));
        });

        Nova::userTimezone(function (Request $request) {
            return $request->user()->timezone;
        });
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     * @return array
     */
    public function tools()
    {
        return [
            Novaspatiepermissions::make(),
        ];
    }

    /**
     * Register the Nova routes.
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register the Nova gate.
     * This gate determines who can access Nova in non-local environments.
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->is_lecturer;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }
}
