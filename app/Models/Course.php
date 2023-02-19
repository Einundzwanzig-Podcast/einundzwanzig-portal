<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Course extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTags;

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
        'lecturer_id' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->created_by) {
                $model->created_by = auth()->id();
            }
        });
    }

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
        $this->addMediaCollection('logo')
             ->singleFile()
             ->useFallbackUrl(asset('img/einundzwanzig.png'));
        $this->addMediaCollection('images')
             ->useFallbackUrl(asset('img/einundzwanzig.png'));
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function courseEvents(): HasMany
    {
        return $this->hasMany(CourseEvent::class);
    }
}
