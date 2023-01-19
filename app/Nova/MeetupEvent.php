<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class MeetupEvent extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\MeetupEvent::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     * @var string
     */
    public static $title = 'id';
    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'id',
        'meetup.name',
    ];

    public static $with = [
        'meetup',
        'createdBy',
    ];

    public static function label()
    {
        return __('Meetup Event');
    }

    public static function afterCreate(NovaRequest $request, Model $model)
    {
        \App\Models\User::find(1)
                        ->notify(new ModelCreatedNotification($model, str($request->getRequestUri())
                            ->after('/nova-api/')
                            ->before('?')
                            ->toString()));
    }

    public static function relatableMeetups(NovaRequest $request, $query, Field $field)
    {
        if ($field instanceof BelongsTo) {
            $query->whereIn('meetups.id', $request->user()
                                                  ->meetups()
                                                  ->pluck('id')
                                                  ->toArray());
        }

        return $query;
    }

    public function subtitle()
    {
        return __('Created by: :name', ['name' => $this->createdBy->name]);
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

            DateTime::make(__('Start'), 'start')
                    ->step(CarbonInterval::minutes(15))
                    ->displayUsing(fn($value) => $value->asDateTime()),

            Text::make(__('Location'), 'location'),

            Text::make(__('Description'), 'description')
                ->rules('required', 'string')
                ->hideFromIndex(),

            Text::make('Link')
                ->rules('required', 'string'),

            BelongsTo::make('Meetup')
                     ->searchable()
                     ->withSubtitles(),

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
