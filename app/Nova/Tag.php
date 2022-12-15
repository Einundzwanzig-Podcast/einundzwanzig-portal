<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Tag extends Resource
{
    public static $model = \App\Models\Tag::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public static function afterCreate(NovaRequest $request, Model $model)
    {
        \App\Models\User::find(1)
                        ->notify(new ModelCreatedNotification($model, str($request->getRequestUri())
                            ->after('/nova-api/')
                            ->before('?')
                            ->toString()));
    }

    public function fields(Request $request)
    {
        return [
            Text::make('Name')
                ->sortable(),

            Text::make('Icon')
                ->sortable()
                ->help('<a href="https://fontawesome.com/icons" target="_blank">https://fontawesome.com/icons</a>'),

            Select::make('Type')
                  ->options([
                      'course' => 'course',
                      'library_item' => 'library_item',
                  ]),

        ];
    }
}
