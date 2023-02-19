<?php

namespace App\Nova;

use App\Enums\LibraryItemType;
use App\Notifications\ModelCreatedNotification;
use App\Nova\Actions\AttachLibraryItemToLibrary;
use App\Nova\Actions\SetStatusAction;
use App\Nova\Filters\LibraryItemWithout;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\LaravelOptions\Options;
use Spatie\TagsField\Tags;
use WesselPerik\StatusField\StatusField;

class LibraryItem extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\LibraryItem::class;

    public static $perPageViaRelationship = 50;

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
        'type',
    ];

    public static $with = [
        'lecturer',
        'tags',
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

            StatusField::make('Status', )
                       ->icons([
                           'clock' => $this->status === '' || $this->status === 'draft',
                           'check-circle' => $this->status === 'published',
                       ])
                       ->tooltip([
                           'clock' => 'Pending publication',
                           'check-circle' => 'Published',
                       ])
                       ->info([
                           'clock' => 'Pending publication.',
                           'check-circle' => 'Published.',
                       ])
                       ->color([
                           'clock' => 'blue-500',
                           'check-circle' => 'green-500',
                       ])
                       ->exceptOnForms(),

            Images::make(__('Main picture'), 'main')
                  ->conversionOnIndexView('thumb')
                  ->showStatistics()
                  ->setFileName(fn ($originalFilename, $extension, $model) => md5($originalFilename).'.'.$extension),

            Images::make(__('Images'), 'images')
                  ->conversionOnIndexView('thumb')
                  ->help('Upload images here to insert them later in the Markdown Description. But you have to save before.')
                  ->hideFromIndex()
                  ->showStatistics()
                  ->setFileName(fn ($originalFilename, $extension, $model) => md5($originalFilename).'.'.$extension),

            Files::make(__('Downloadable File'), 'single_file')
                 ->showStatistics()
                 ->help(__('Please contact the admins for new file types, otherwise pack the files in a ZIP! (Currently: PDF, ZIP)'))
                 ->setFileName(fn ($originalFilename, $extension, $model) => md5($originalFilename).'.'.$extension),

            Select::make(__('Language Code'), 'language_code')
                  ->options(
                      config('languages.languages')
                  )
                  ->rules('required', 'string')
                  ->searchable()
                  ->hideFromIndex(),

            Tags::make('Tags')
                ->type('library_item')
                ->withLinkToTagResource(Tag::class),

            Text::make('Name')
                ->rules('required', 'string'),

            Text::make(__('Subtitle'), 'subtitle')
                ->rules('nullable', 'string')
                ->hideFromIndex(),

            Textarea::make(__('Excerpt'), 'excerpt')
                    ->rules('nullable', 'string')
                    ->help(__('This is the excerpt that is shown in the overview.')),

            Text::make(__('Main image caption'), 'main_image_caption')
                ->rules('nullable', 'string')
                ->hideFromIndex(),

            Number::make(__('Time to read'), 'read_time')
                  ->rules('nullable', 'numeric')
                  ->help(__('How many minutes to read?'))
                  ->hideFromIndex(),

            Select::make(__('Type'), 'type')
                  ->options(
                      Options::forEnum(LibraryItemType::class)
                             ->toArray()
                  )
                  ->rules('required', 'string'),

            Boolean::make(__('News Article'), 'news')->help(__('Is this a news article?')),

            Boolean::make(__('Approve'), 'approved')->help(__('Article approved')),

            Code::make(__('Value'), 'value')
                ->rules('nullable', 'string')
                ->help('Please paste the URL to the video here, or the link to the blog article, or the link to the book, or the Markdown itself.'),

            BelongsTo::make(__('Lecturer/Content Creator'), 'lecturer', Lecturer::class)
                     ->searchable()
                     ->withSubtitles(),

            BelongsTo::make(__('Episode'), 'episode', Episode::class)
                     ->nullable()
                     ->exceptOnForms(),

            BelongsToMany::make(__('Library'), 'libraries', Library::class),

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
        return [
            new LibraryItemWithout(),
        ];
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
        return [
            new AttachLibraryItemToLibrary(),
            new SetStatusAction(),
        ];
    }
}
