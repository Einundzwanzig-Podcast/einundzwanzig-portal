<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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

        Nova::withBreadcrumbs();

        // disable theme switcher
        Nova::withoutThemeSwitcher();

        // login with user id 1, if we are in local environment
        if (app()->environment('local')) {
            auth()->loginUsingId(1);
        }

        Nova::footer(function ($request) {
            // return MIT license and date
            return sprintf("%s %s - %s", date('Y'), config('app.name'), __('MIT License'));
        });
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     * @return array
     */
    public function tools()
    {
        return [];
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
            return in_array($user->email, [
                //
            ]);
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
