<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Meetup extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\Meetup::class;

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
        'city.name',
    ];

    public static $with = [
        'city',
        'createdBy',
    ];

    public static function afterCreate(NovaRequest $request, Model $model)
    {
        auth()
            ->user()
            ->meetups()
            ->attach($model);
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

            Images::make(__('Logo'), 'logo')
                  ->conversionOnIndexView('thumb')
                  ->showStatistics(),

            Text::make('Name')
                ->rules('required', 'string')
                ->creationRules('unique:meetups,name')
                ->updateRules('unique:meetups,name,{{resourceId}}'),

            Text::make(__('Telegram-Link'), 'telegram_link')
                ->rules('url', 'nullable')->hideFromIndex(),

            Text::make(__('Website'), 'webpage')
                ->rules('url', 'nullable')->hideFromIndex(),

            Text::make(__('Matrix Group'), 'matrix_group')
                ->rules('url', 'nullable')->hideFromIndex(),

            Text::make(__('Twitter Username'), 'twitter_username')
                ->help(__('Without @'))
                ->rules('string', 'nullable')->hideFromIndex(),

            BelongsTo::make(__('City'), 'city', City::class)
                     ->searchable()
                     ->withSubtitles()
                     ->help(__('If your city is not listed, please create it first.')),

            Markdown::make(__('Intro'), 'intro')
                    ->help(__('This is the introduction text that is shown on the landing page.')),

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
