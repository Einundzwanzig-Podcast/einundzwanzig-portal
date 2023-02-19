<?php

namespace App\Models;

use Akuechler\Geoly;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cookie;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class City extends Model
{
    use HasFactory;
    use HasSlug;
    use Geoly;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'country_id' => 'integer',
        'osm_relation' => 'json',
        'simplified_geojson' => 'json',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->created_by) {
                $model->created_by = auth()->id();
            }
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom(['country.code', 'name'])
                          ->saveSlugsTo('slug')
                          ->usingLanguage(Cookie::get('lang', config('app.locale')));
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function venues(): HasMany
    {
        return $this->hasMany(Venue::class);
    }

    public function courseEvents()
    {
        return $this->hasManyThrough(CourseEvent::class, Venue::class);
    }

    public function meetups()
    {
        return $this->hasMany(Meetup::class);
    }
}
