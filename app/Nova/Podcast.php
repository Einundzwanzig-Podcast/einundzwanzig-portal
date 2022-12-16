<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Podcast extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\Podcast::class;

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
        $guid = $this->guid ?? Str::uuid();

        return [
            ID::make()
              ->sortable(),

            Avatar::make(__('Image'))
                  ->squared()
                  ->thumbnail(function () {
                      return $this?->data['image'] ?? '';
                  })
                  ->exceptOnForms(),

            Boolean::make(__('Locked'), 'locked', fn($value) => $value ?? false),

            Text::make('Guid', 'guid', function ($value) use ($guid) {
                if ($value) {
                    return $value;
                } else {
                    return $guid;
                }
            }),

            Text::make(__('Title'), 'title')
                ->rules('required', 'string'),

            Text::make(__('Language Code'), 'language_code')
                ->rules('required', 'string'),

            Text::make('Link')
                ->rules('required', 'string'),

            Code::make(__('Data'), 'data')
                ->rules('required', 'json')
                ->json(),

            HasMany::make(__('Episodes'), 'episodes', Episode::class),

            BelongsTo::make(__('Created By'), 'createdBy', User::class)
                     ->canSee(function ($request) {
                         return $request->user()
                                        ->hasRole('super-admin');
                     })
                     ->searchable(),

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
