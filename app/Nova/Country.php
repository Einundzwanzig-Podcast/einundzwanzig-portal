<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Country extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Country::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'english_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'english_name',
        'code',
    ];

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
        return __('Code: :code', ['code' => $this->code]);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()
              ->sortable(),

            Text::make(__('Name'), 'name')
                ->rules('required', 'string'),

            Text::make(__('English name'), 'english_name')
                ->rules('required', 'string'),

            MultiSelect::make(__('Languages'), 'language_codes')
                       ->options(
                           config('languages.languages'),
                       ),

            Text::make(__('Code'), 'code')
                ->rules('required', 'string'),

            Number::make(__('Latitude'), 'latitude')
                  ->rules('required', 'numeric')
                  ->step(0.000001)
                  ->help('<a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),

            Number::make(__('Longitude'), 'longitude')
                  ->rules('required', 'numeric')
                  ->step(0.000001)
                  ->help('<a target="_blank" href="https://www.latlong.net/">https://www.latlong.net/</a>'),

            HasMany::make(__('Cities'), 'cities', City::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request): array
    {
        return [];
    }
}
