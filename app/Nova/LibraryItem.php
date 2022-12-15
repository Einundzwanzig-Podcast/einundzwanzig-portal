<?php

namespace App\Nova;

use App\Enums\LibraryItemType;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Spatie\LaravelOptions\Options;
use Spatie\TagsField\Tags;

class LibraryItem extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\LibraryItem::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     * @var string
     */
    public static $title = 'name';

    public static function label()
    {
        return __('Library Item');
    }

    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

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

            Images::make(__('Main picture'), 'main')
                  ->conversionOnIndexView('thumb'),

            Images::make(__('Images'), 'images')
                  ->conversionOnIndexView('thumb')
                  ->help('Lade hier Bilder hoch, um sie eventuell später in der Markdown Description einzufügen. Du musst vorher aber Speichern.'),

            Files::make(__('Downloadable File'), 'single_file')
                 ->help('Für neue Datei-Typen bitte bei den Admins melden. (Derzeit: PDF)'),

            Select::make(__('Language Code'), 'language_code')
                  ->options(
                      config('languages.languages')
                  )
                  ->rules('required', 'string'),

            Tags::make('Tags')
                ->type('library_item')
                ->withLinkToTagResource(Tag::class),

            Text::make('Name')
                ->rules('required', 'string'),

            Select::make(__('Type'))
                  ->options(
                      Options::forEnum(LibraryItemType::class)->toArray()
                  )
                  ->rules('required', 'string'),

            Code::make(__('Value'))
                ->rules('nullable', 'string')
                ->help('Hier bitte die URL zum Video einfügen, oder den Link zum Blog-Artikel, oder den Link zum Buch, oder das Markdown selbst einfügen.'),

            BelongsTo::make(__('Lecturer/Content Creator'), 'lecturer', Lecturer::class),

            BelongsTo::make(__('Episode'), 'episode', Episode::class)->nullable(),

            BelongsToMany::make(__('Library'), 'libraries', Library::class),

            BelongsTo::make(__('Created By'), 'createdBy', User::class),

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
