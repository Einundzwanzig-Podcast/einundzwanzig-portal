<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Tags\HasTags;

class LibraryItem extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTags;
    use SortableTrait;
    use HasStatuses;

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
        'id'          => 'integer',
        'lecturer_id' => 'integer',
        'library_id'  => 'integer',
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
        $this->addMediaCollection('main')
             ->singleFile()
             ->useFallbackUrl(asset('img/einundzwanzig-cover-lesestunde.png'));
        $this->addMediaCollection('single_file')
             ->acceptsMimeTypes(['application/pdf'])
             ->singleFile();
        $this->addMediaCollection('images')
             ->useFallbackUrl(asset('img/einundzwanzig-cover-lesestunde.png'));
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lecturer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function episode(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Episode::class);
    }

    public function libraries(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Library::class);
    }
}
