<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
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

    public static function label()
    {
        return __('Book Case');
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

            Text::make(__('Title'), 'title')
                ->rules('required', 'string'),

            Number::make(__('Latitude'), 'latitude')
                  ->rules('required', 'numeric')
                  ->step(0.000001)
                  ->hideFromIndex(),

            Number::make(__('Longitude'), 'longitude')
                  ->rules('required', 'numeric')
                  ->step(0.000001)
                  ->hideFromIndex(),

            Text::make(__('Address'), 'address')
                ->rules('required', 'string'),

            Text::make(__('Type'), 'type')
                ->rules('required', 'string'),

            Text::make(__('Open'), 'open')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make(__('Comment'), 'comment')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make(__('Contact'), 'contact')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make(__('Bcz'), 'bcz')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Boolean::make(__('Digital'), 'digital')
                   ->rules('required')
                   ->hideFromIndex(),

            Text::make(__('Icontype'), 'icontype')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Boolean::make(__('Deactivated'), 'deactivated')
                   ->rules('required'),

            Text::make(__('Deactreason'), 'deactreason')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make(__('Entrytype'), 'entrytype')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make(__('Homepage'), 'homepage')
                ->rules('required', 'string')
                ->hideFromIndex(),

            HasMany::make(__('OrangePills'), 'orangePills', OrangePill::class),

            MorphMany::make(__('Comments'), 'comments', Comment::class),

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
