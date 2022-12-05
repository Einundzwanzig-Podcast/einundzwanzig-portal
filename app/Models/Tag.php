<?php

namespace App\Models;

class Tag extends \Spatie\Tags\Tag
{
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'taggable');
    }

    public function libraryItems()
    {
        return $this->morphedByMany(LibraryItem::class, 'taggable');
    }
}
