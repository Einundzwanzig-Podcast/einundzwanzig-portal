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
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class CourseEvent extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\CourseEvent::class;
    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'id',
        'course.name',
    ];

    public function title()
    {
        return $this->from.' - '.$this->venue->name.' - '.$this->course->name;
    }

    public static function label()
    {
        return __('Course Event');
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

            URL::make('Link')
               ->rules('required', 'url'),

            DateTime::make(__('From'), 'from')
                    ->step(CarbonInterval::minutes(15))
                    ->rules('required')
                    ->displayUsing(fn($value) => $value->asDateTime()),

            DateTime::make(__('To'), 'to')
                    ->step(CarbonInterval::minutes(15))
                    ->rules('required')
                    ->displayUsing(fn($value) => $value->asDateTime()),

            BelongsTo::make(__('Course'), 'course', Course::class)
                     ->searchable()->showCreateRelationButton()->withSubtitles(),

            BelongsTo::make(__('Venue'), 'venue', Venue::class)
                     ->searchable()->showCreateRelationButton()->withSubtitles(),

            BelongsTo::make(__('Created By'), 'createdBy', User::class)
                     ->canSee(function ($request) {
                         return $request->user()
                                        ->hasRole('super-admin');
                     })
                     ->searchable()->withSubtitles(),

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
