<?php

namespace App\Nova;

use App\Enums\LibraryItemType;
use App\Notifications\ModelCreatedNotification;
use App\Nova\Actions\SetStatusAction;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\LaravelOptions\Options;
use Spatie\TagsField\Tags;
use WesselPerik\StatusField\StatusField;

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
        return __('Library Item');
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
        return __('Erstellt von: :name', ['name' => $this->createdBy->name]);
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

            StatusField::make('Status',)
                       ->icons([
                           'clock'        => $this->status === '' || $this->status === 'draft',
                           'check-circle' => $this->status === 'published',
                       ])
                       ->tooltip([
                           'clock'        => 'Pending publication',
                           'check-circle' => 'Published'
                       ])
                       ->info([
                           'clock'        => 'Pending publication.',
                           'check-circle' => 'Published.'
                       ])
                       ->color([
                           'clock'        => 'blue-500',
                           'check-circle' => 'green-500'
                       ])
                       ->exceptOnForms(),

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
                  ->rules('required', 'string')->searchable(),

            Tags::make('Tags')
                ->type('library_item')
                ->withLinkToTagResource(Tag::class),

            Text::make('Name')
                ->rules('required', 'string'),

            Select::make(__('Type'), 'type')
                  ->options(
                      Options::forEnum(LibraryItemType::class)
                             ->toArray()
                  )
                  ->rules('required', 'string'),

            Code::make(__('Value'), 'value')
                ->rules('nullable', 'string')
                ->help('Hier bitte die URL zum Video einfügen, oder den Link zum Blog-Artikel, oder den Link zum Buch, oder das Markdown selbst einfügen.'),

            BelongsTo::make(__('Lecturer/Content Creator'), 'lecturer', Lecturer::class)->searchable()->withSubtitles(),

            BelongsTo::make(__('Episode'), 'episode', Episode::class)
                     ->nullable()
                     ->exceptOnForms(),

            BelongsToMany::make(__('Library'), 'libraries', Library::class),

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
        return [
            new SetStatusAction(),
        ];
    }
}
