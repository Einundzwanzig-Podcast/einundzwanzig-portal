<?php

namespace App\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class LibraryItemWithout extends BooleanFilter
{
    public function name()
    {
        return __('Filter');
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  mixed  $value
     */
    public function apply(NovaRequest $request, Builder $query, $value): Builder
    {
        return $query
            ->when($value['libraries'], fn ($query) => $query->whereDoesntHave('libraries'))
            ->when($value['tags'], fn ($query) => $query->whereDoesntHave('tags'));
    }

    /**
     * Get the filter's available options.
     */
    public function options(NovaRequest $request): array
    {
        return [
            __('Library items without libraries') => 'libraries',
            __('Library items without tags') => 'tags',
        ];
    }
}
