<?php

namespace App\Models;

use App\Support\CustomFeedItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cookie;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Feed\Feedable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class LibraryItem extends Model implements HasMedia, Sortable, Feedable
{
    use InteractsWithMedia;
    use HasTags;
    use SortableTrait;
    use HasStatuses;
    use HasSlug;

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

    public static function getFeedItems()
    {
        return self::query()
                   ->with([
                       'media',
                       'lecturer',
                   ])
                   ->where('news', true)
                   ->where('approved', true)
                   ->orderByDesc('created_at')
                   ->get();
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->created_by) {
                $model->created_by = auth()->id();
            }
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom(['name'])
                          ->saveSlugsTo('slug')
                          ->usingLanguage(Cookie::get('lang', config('app.locale')));
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
        $this->addMediaConversion('seo')
             ->fit(Manipulations::FIT_CROP, 1200, 630)
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
             ->useFallbackUrl(asset('img/einundzwanzig.png'));
        $this->addMediaCollection('single_file')
             ->acceptsMimeTypes([
                 'application/pdf', 'application/zip', 'application/octet-stream', 'application/x-zip-compressed',
                 'multipart/x-zip',
             ])
             ->singleFile();
        $this->addMediaCollection('images')
             ->useFallbackUrl(asset('img/einundzwanzig.png'));
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function episode(): BelongsTo
    {
        return $this->belongsTo(Episode::class);
    }

    /*
     * This string will be used in notifications on what a new comment
     * was made.
     */

    public function libraries(): BelongsToMany
    {
        return $this->belongsToMany(Library::class);
    }

    public function toFeedItem(): CustomFeedItem
    {
        return CustomFeedItem::create()
                             ->id('news/'.$this->slug)
                             ->title($this->name)
                             ->content($this->value)
                             ->enclosure($this->getFirstMediaUrl('main'))
                             ->enclosureLength($this->getFirstMedia('main')->size)
                             ->enclosureType($this->getFirstMedia('main')->mime_type)
                             ->summary($this->excerpt)
                             ->updated($this->updated_at)
                             ->image($this->getFirstMediaUrl('main'))
                             ->link(url()->route('article.view', ['libraryItem' => $this]))
                             ->authorName($this->lecturer->name);
    }

    public static function searchLibraryItems($type, $value = null)
    {
        $query = self::query()
            ->where('type', $type)
            ->latest('id');

        if ($value) {
            $query->where('name', 'ilike', "%{$value}%");
        }

        return $query->get();
    }
}
