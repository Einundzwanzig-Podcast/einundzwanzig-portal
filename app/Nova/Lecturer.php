<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Lecturer extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\Lecturer::class;

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
        return __('Lecturer/Content Creator');
    }

    public static function relatableTeams(NovaRequest $request, $query, Field $field)
    {
        if ($field instanceof BelongsTo && !$request->user()
                                                    ->hasRole('super-admin')) {
            $query->where('id', $request->user()->current_team_id);
        }

        return $query;
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

            Images::make('Avatar', 'avatar')
                  ->conversionOnIndexView('thumb'),

            Images::make(__('Images'), 'images')
                  ->conversionOnIndexView('thumb')
                  ->help('Upload images here to insert them later in the Markdown Description. But you have to save before.'),

            Text::make('Name')
                ->rules('required', 'string'),

            Text::make('Twitter username', 'twitter_username')
                ->help(__('Without @'))
                ->rules('nullable', 'string'),

            Text::make('Website', 'website')
                ->hideFromIndex()
                ->rules('nullable', 'url'),

            Markdown::make(__('Subtitle'), 'subtitle')
                    ->help(__('This is the subtitle on the landing page.')),

            Markdown::make(__('Intro'), 'intro')
                    ->help(__('This is the introduction text that is shown on the landing page.')),

            Text::make('Slug')
                ->hideFromIndex()
                ->rules('required', 'string', 'unique:lecturers,slug,{{resourceId}}'),

            Boolean::make('Active')
                   ->rules('required')
                   ->default(true),

            Markdown::make('Description')
                    ->alwaysShow()
                    ->help('Markdown is allowed. You can paste images from the "Images" field here. Use the link icon of the images for the urls after clicking "Update and continue".'),

            BelongsTo::make('Team')
                     ->onlyOnDetail(),

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
