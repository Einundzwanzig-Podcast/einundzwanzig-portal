<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\TagsField\Tags;

class Episode extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\Episode::class;
    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'id',
    ];
    public static $orderBy = ['created_at' => 'desc'];

    public static function afterUpdate(NovaRequest $request, Model $model)
    {
        if ($request->tags) {
            $lecturer = \App\Models\Lecturer::updateOrCreate(['name' => $model->podcast->title], [
                'team_id' => 1,
                'active'  => true,
                'website' => $model->podcast->link,
            ]);
            $lecturer->addMediaFromUrl($model->podcast->data['image'])
                     ->toMediaCollection('avatar');
            $library = \App\Models\Library::updateOrCreate(
                [
                    'name' => $model->podcast->title
                ],
                [
                    'language_codes' => [$model->podcast->language_code],
                ]);
            $libraryItem = $model->libraryItem()
                                 ->firstOrCreate([
                                     'lecturer_id'   => $lecturer->id,
                                     'episode_id'    => $model->id,
                                     'name'          => $model->data['title'],
                                     'type'          => 'podcast_episode',
                                     'language_code' => $model->podcast->language_code,
                                     'value'         => null,
                                 ]);
            $libraryItem->syncTagsWithType(is_array($request->tags) ? $request->tags : str($request->tags)->explode('-----'),
                'library_item');
            $libraryItem->addMediaFromUrl($model->data['image'])
                        ->toMediaCollection('main');
            $library->libraryItems()
                    ->attach($libraryItem);
        }
    }

    public static function afterCreate(NovaRequest $request, Model $model)
    {
        \App\Models\User::find(1)
                        ->notify(new ModelCreatedNotification($model, str($request->getRequestUri())
                            ->after('/nova-api/')
                            ->before('?')
                            ->toString()));
    }

    protected static function applyOrderings($query, array $orderings)
    {
        if (empty($orderings) && property_exists(static::class, 'orderBy')) {
            $orderings = static::$orderBy;
        }

        return parent::applyOrderings($query, $orderings);
    }

    public function title()
    {
        return $this->data['title'];
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

            Avatar::make(__('Image'))
                  ->squared()
                  ->thumbnail(function () {
                      return $this->data['image'];
                  })
                  ->exceptOnForms(),

            Tags::make(__('Tags'))
                ->type('library_item')
                ->withLinkToTagResource(Tag::class),

            Text::make(__('Title'), 'data->title')
                ->readonly()
                ->rules('required', 'string'),

            Code::make(__('Data'), 'data')
                ->readonly()
                ->rules('required', 'json')
                ->json(),

            BelongsTo::make(__('Podcast'), 'podcast', Podcast::class)
                     ->readonly(),

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
