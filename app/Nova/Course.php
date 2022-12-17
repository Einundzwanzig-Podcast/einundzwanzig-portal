<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Database\Eloquent\Model;
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

    public static function label()
    {
        return __('Course');
    }

    public static function singularLabel()
    {
        return __('Course');
    }

    public static function relatableLecturers(NovaRequest $request, $query, Field $field)
    {
        if ($field instanceof BelongsTo) {
            $query->where('team_id', $request->user()->current_team_id);
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

            Images::make(__('Main picture'), 'logo')
                  ->conversionOnIndexView('thumb'),

            // todo: english
            Images::make(__('Images'), 'images')
                  ->conversionOnIndexView('thumb')
                  ->help(__('Lade hier Bilder hoch, um sie eventuell später in der Markdown Description einzufügen. Du musst vorher aber Speichern.')),

            Tags::make(__('Tags'))
                ->type('course')
                ->withLinkToTagResource(Tag::class),

            Text::make(__('Name'), 'name')
                ->rules('required', 'string'),

            Markdown::make(__('Description'), 'description')
                    ->alwaysShow()
                    ->help(__('Markdown ist erlaubt. Du kannst Bilder aus dem Feld "Images" hier einfügen. Benutze das Link Symbol der Bilder für die Urls, nach dem du auf "Aktualisieren und Weiterarbeiten" geklickt hast.')),

            BelongsTo::make(__('Lecturer'), 'lecturer', Lecturer::class)
                     ->searchable()
                     ->help(__('Wähle hier den Dozenten aus, der den Kurs hält. Wenn der Dozent nicht in der Liste ist, dann erstelle ihn zuerst unter "Dozenten".'))->withSubtitles(),

            SelectPlus::make(__('Categories'), 'categories', Category::class)
                      ->usingIndexLabel('name'),

            BelongsToMany::make(__('Categories'), 'categories', Category::class)
                         ->onlyOnDetail(),

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
