<?php

namespace App\Models;

use Akuechler\Geoly;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class City extends Model
{
    use HasFactory;
    use HasSlug;
    use Geoly;

    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'country_id' => 'integer',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom(['country.code', 'name'])
                          ->saveSlugsTo('slug')
                          ->usingLanguage('de');
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function venues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Venue::class);
    }

    function courseEvents()
    {
        return $this->hasManyThrough(CourseEvent::class, Venue::class);
    }
}
