<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

class Tag extends Resource
{
    public static $model = \App\Models\Tag::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

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
                      'search' => 'search',
                  ]),

        ];
    }
}
