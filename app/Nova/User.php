<?php

namespace App\Nova;

use App\Notifications\ModelCreatedNotification;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

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
        'id', 'name',
    ];

    public static function label()
    {
        return __('Users');
    }

    public static function afterCreate(NovaRequest $request, Model $model)
    {
        \App\Models\User::find(1)
                        ->notify(new ModelCreatedNotification($model, str($request->getRequestUri())
                            ->after('/nova-api/')
                            ->before('?')
                            ->toString()));
    }

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()
              ->sortable(),

            Gravatar::make()
                    ->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('Public Key'), 'public_key')
                ->rules('nullable', 'string')->hideFromIndex(),

            Text::make(__('Email'), 'email')
                ->rules('nullable', 'string')->hideFromIndex(),

            Text::make(__('Lightning Address'), 'lightning_address')
                ->help(__('for example xy@getalby.com'))
                ->rules('nullable', 'string'),

            Text::make(__('LNURL'), 'lnurl')
                ->help(__('starts with: lnurl1dp68gurn8gh....'))
                ->rules('nullable', 'string'),

            Text::make(__('Node Id'), 'node_id')
                ->rules('nullable', 'string'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            //            Password::make('Password')
            //                    ->onlyOnForms()
            //                    ->creationRules('required', Rules\Password::defaults())
            //                    ->updateRules('nullable', Rules\Password::defaults()),

            MorphToMany::make('Roles', 'roles', \Itsmejoshua\Novaspatiepermissions\Role::class),

            MorphToMany::make('Permissions', 'permissions', \Itsmejoshua\Novaspatiepermissions\Permission::class),

        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
