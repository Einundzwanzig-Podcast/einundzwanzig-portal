<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Carbon\CarbonInterval;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class BitcoinEvent extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\BitcoinEvent::class;

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

    public static function afterCreate(NovaRequest $request, Model $model)
    {
        \App\Models\User::find(1)
                        ->notify(new ModelCreatedNotification($model, str($request->getRequestUri())
                            ->after('/nova-api/')
                            ->before('?')
                            ->toString()));
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

            Images::make(__('Logo'), 'logo')
                  ->conversionOnIndexView('thumb'),

            Boolean::make(__('Show worldwide'), 'show_worldwide')
                   ->help(__('If checked, the event will be shown everywhere.')),

            DateTime::make(__('From'), 'from')
                    ->step(CarbonInterval::minutes(15))
                    ->displayUsing(fn($value) => $value->asDateTime())
                    ->rules('required'),

            DateTime::make(__('To'), 'to')
                    ->step(CarbonInterval::minutes(15))
                    ->displayUsing(fn($value) => $value->asDateTime())
                    ->rules('required'),

            Text::make(__('Title'), 'title')
                ->rules('required', 'string'),

            Text::make(__('Description'), 'description')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make('Link')
                ->rules('required', 'string'),

            BelongsTo::make(__('Venue'), 'venue', Venue::class)
                     ->searchable(),

            BelongsTo::make(__('Created By'), 'createdBy', User::class)
                     ->exceptOnForms(),

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
