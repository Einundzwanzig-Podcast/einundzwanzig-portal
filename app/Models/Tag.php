<?php

namespace App\Models;

class Tag extends \Spatie\Tags\Tag
{
    public function courses()
    {
        return $this->morphedByMany(Course::class, 'taggable');
    }
}
