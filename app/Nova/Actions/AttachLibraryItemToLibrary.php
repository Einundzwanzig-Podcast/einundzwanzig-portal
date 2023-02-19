<?php

namespace App\Nova\Actions;

use App\Models\Library;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class AttachLibraryItemToLibrary extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->libraries()
                  ->attach($fields->library);
        }
    }

    /**
     * Get the fields available on the action.
     */
    public function fields(NovaRequest $request): array
    {
        $libraries = Library::query()
                            ->pluck('name', 'id');

        return [
            Select::make('Library')
                  ->options($libraries),
        ];
    }
}
