<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;
use ZiffMedia\NovaSelectPlus\SelectPlus;

class Course extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\Course::class;

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

    public static function relatableLecturers(NovaRequest $request, $query, Field $field)
    {
        if ($field instanceof BelongsTo) {
            $query->where('team_id', $request->user()->current_team_id);
        }

        return $query;
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

            Images::make('Main picture', 'logo')
                  ->conversionOnIndexView('thumb'),

            Images::make('Images', 'images')
                  ->conversionOnIndexView('thumb')
                  ->help('Lade hier Bilder hoch, um sie eventuell später in der Markdown Description einzufügen. Du musst vorher aber Speichern.'),

            Tags::make('Tags')->type('search')->withLinkToTagResource(Tag::class),

            Text::make('Name')
                ->rules('required', 'string'),

            Markdown::make('Description')
                    ->alwaysShow()
                    ->help('Markdown ist erlaubt. Du kannst Bilder aus dem Feld "Images" hier einfügen. Benutze das Link Symbol der Bilder für die Urls, nach dem du auf "Aktualisieren und Weiterarbeiten" geklickt hast.'),

            BelongsTo::make('Lecturer'),

            SelectPlus::make('Categories', 'categories', Category::class)
                      ->usingIndexLabel('name'),

            BelongsToMany::make('Categories')->onlyOnDetail(),

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
