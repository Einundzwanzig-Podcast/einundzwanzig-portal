<?php

namespace App\Nova\Filters;

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
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        return $query
            ->when($value['libraries'], fn ($query) => $query->whereDoesntHave('libraries'))
            ->when($value['tags'], fn ($query) => $query->whereDoesntHave('tags'));
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return [
            __('Library items without libraries') => 'libraries',
            __('Library items without tags') => 'tags',
        ];
    }
}
