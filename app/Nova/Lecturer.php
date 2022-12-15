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

    public static function label()
    {
        return __('Lecturer/Content Creator');
    }

    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    public static function relatableTeams(NovaRequest $request, $query, Field $field)
    {
        if ($field instanceof BelongsTo && !$request->user()->hasRole('super-admin')) {
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
                  ->help('Lade hier Bilder hoch, um sie eventuell später in der Markdown Description einzufügen. Du musst vorher aber Speichern.'),

            Text::make('Name')
                ->rules('required', 'string'),

            Text::make('Slug')
                ->rules('required', 'string', 'unique:lecturers,slug')
                ->exceptOnForms(),

            Boolean::make('Active')
                   ->rules('required')
                   ->default(true),

            Markdown::make('Description')
                    ->alwaysShow()
                    ->help('Markdown ist erlaubt. Du kannst Bilder aus dem Feld "Images" hier einfügen. Benutze das Link Symbol der Bilder für die Urls, nach dem du auf "Aktualisieren und Weiterarbeiten" geklickt hast.'),

            BelongsTo::make('Team'),

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
