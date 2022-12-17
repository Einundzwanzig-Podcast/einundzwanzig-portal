<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasManyThrough;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class City extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\City::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     * @var string
     */
    public static $title = 'name';
    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    public static function label()
    {
        return __('City');
    }

    public static function afterCreate(NovaRequest $request, Model $model)
    {
        \App\Models\User::find(1)
                        ->notify(new ModelCreatedNotification($model, str($request->getRequestUri())
                            ->after('/nova-api/')
                            ->before('?')
                            ->toString()));
    }

    public function subtitle()
    {
        return __('Land: :name', ['name' => $this->country->name]);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()
              ->sortable(),

            Text::make(__('Name'), 'name')
                ->rules('required', 'string'),

            Text::make(__('Slug'), 'slug')
                ->exceptOnForms(),

            Number::make(__('Latitude'), 'latitude')
                  ->rules('required', 'numeric')
                  ->step(0.000001)
                  ->help('<a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),

            Number::make(__('Longitude'), 'longitude')
                  ->rules('required', 'numeric')
                  ->step(0.000001)
                  ->help('<a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),

            BelongsTo::make(__('Country'), 'country', Country::class)
                     ->searchable()
                     ->withSubtitles(),

            HasMany::make(__('Venues'), 'venues', Venue::class),

            HasManyThrough::make(__('Course Events'), 'courseEvents', CourseEvent::class),

            HasMany::make(__('Meetups'), 'meetups', Meetup::class),

            BelongsTo::make(__('Created By'), 'createdBy', User::class)
                     ->canSee(function ($request) {
                         return $request->user()
                                        ->hasRole('super-admin');
                     })
                     ->searchable()
                     ->withSubtitles(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
