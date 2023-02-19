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
     *
     * @var string
     */
    public static $model = \App\Models\Course::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
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
        return __('Created by: :name', ['name' => $this->createdBy->name]);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()
              ->sortable(),

            Images::make(__('Main picture'), 'logo')
                  ->showStatistics()
                  ->conversionOnIndexView('thumb')
                  ->setFileName(fn ($originalFilename, $extension, $model) => md5($originalFilename).'.'.$extension),

            // todo: english
            Images::make(__('Images'), 'images')
                  ->showStatistics()
                  ->conversionOnIndexView('thumb')
                  ->help(__('Upload images here to insert them later in the Markdown Description. But you have to save before.'))
                  ->setFileName(fn ($originalFilename, $extension, $model) => md5($originalFilename).'.'.$extension),

            Tags::make(__('Tags'))
                ->type('course')
                ->withLinkToTagResource(Tag::class),

            Text::make(__('Name'), 'name')
                ->rules('required', 'string'),

            Markdown::make(__('Description'), 'description')
                    ->alwaysShow()
                    ->help(__('Markdown is allowed. You can paste images from the "Images" field here. Use the link icon of the images for the urls after clicking "Update and continue".')),

            BelongsTo::make(__('Lecturer'), 'lecturer', Lecturer::class)
                     ->searchable()
                     ->help(__('Select here the lecturer who holds the course. If the lecturer is not in the list, create it first under "Lecturers".'))->withSubtitles(),

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
     * @return array
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request): array
    {
        return [];
    }
}
