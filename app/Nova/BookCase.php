<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;

class BookCase extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\BookCase::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Text::make('Title')
                ->rules('required', 'string'),

            Number::make('Lat')
                ->rules('required', 'numeric'),

            Code::make('Lon')
                ->rules('required', 'json')
                ->json(),

            Text::make('Address')
                ->rules('required', 'string'),

            Text::make('Type')
                ->rules('required', 'string'),

            Text::make('Open')
                ->rules('required', 'string'),

            Text::make('Comment')
                ->rules('required', 'string'),

            Text::make('Contact')
                ->rules('required', 'string'),

            Text::make('Bcz')
                ->rules('required', 'string'),

            Boolean::make('Digital')
                ->rules('required'),

            Text::make('Icontype')
                ->rules('required', 'string'),

            Boolean::make('Deactivated')
                ->rules('required'),

            Text::make('Deactreason')
                ->rules('required', 'string'),

            Text::make('Entrytype')
                ->rules('required', 'string'),

            Text::make('Homepage')
                ->rules('required', 'string'),


        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
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
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
