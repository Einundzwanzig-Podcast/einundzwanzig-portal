<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class BookCase extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\BookCase::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'id',
        'title',
    ];

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

            Text::make('Title')
                ->rules('required', 'string'),

            Number::make('Latitude')
                  ->rules('required', 'numeric')
                  ->step(0.000001)
                  ->hideFromIndex(),

            Number::make('Longitude')
                ->rules('required', 'numeric')
                ->step(0.000001)
                ->hideFromIndex(),

            Text::make('Address')
                ->rules('required', 'string'),

            Text::make('Type')
                ->rules('required', 'string'),

            Text::make('Open')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make('Comment')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make('Contact')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make('Bcz')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Boolean::make('Digital')
                   ->rules('required')
                   ->hideFromIndex(),

            Text::make('Icontype')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Boolean::make('Deactivated')
                   ->rules('required'),

            Text::make('Deactreason')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make('Entrytype')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make('Homepage')
                ->rules('required', 'string')
                ->hideFromIndex(),

            HasMany::make('OrangePills'),

            MorphMany::make('Comments'),

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
