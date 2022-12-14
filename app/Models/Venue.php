<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Venue extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasRelationships;
    use InteractsWithMedia;

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
        'id'      => 'integer',
        'city_id' => 'integer',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
        $this->addMediaConversion('thumb')
             ->fit(Manipulations::FIT_CROP, 130, 130)
             ->width(130)
             ->height(130);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
             ->useFallbackUrl(asset('img/einundzwanzig-cover-lesestunde.png'));
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom(['city.slug', 'name',])
                          ->saveSlugsTo('slug')
                          ->usingLanguage('de');
    }

    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function lecturers()
    {
        return $this->hasManyDeepFromRelations($this->courses(), (new Course())->lecturer());
    }

    public function courses()
    {
        return $this->hasManyDeepFromRelations($this->events(), (new CourseEvent())->course());
    }

    public function courseEvents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseEvent::class);
    }
}
