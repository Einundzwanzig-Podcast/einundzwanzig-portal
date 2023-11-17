<?php

namespace App\Nova;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class EmailCampaign extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\EmailCampaign::class;

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
        'language',
    ];

    public static function afterCreate(NovaRequest $request, Model $model)
    {
        //
    }

    public function subtitle()
    {
        return __('Email Campaign');
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(Request $request): array
    {
        return [
            ID::make()
                ->sortable(),

            Text::make(__('Name'), 'name')
                ->rules('required', 'string'),

            Text::make(__('List file name'), 'list_file_name')
                ->rules('required', 'string'),

            Markdown::make(__('Subject text'), 'subject_prompt')
                ->rules('required', 'string')->alwaysShow(),

            Markdown::make(__('Text prompt'), 'text_prompt')
                ->rules('required', 'string')->alwaysShow(),

            HasMany::make(__('Email texts'), 'emailTexts', EmailText::class),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(Request $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(Request $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(Request $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(Request $request): array
    {
        return [];
    }
}
