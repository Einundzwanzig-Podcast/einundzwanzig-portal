<?php

namespace App\Models;

use App\Gamify\Points\BookCaseOrangePilled;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class OrangePill extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

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
        'user_id' => 'integer',
        'book_case_id' => 'integer',
        'date' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user->givePoint(new BookCaseOrangePilled($model));
        });
        static::deleted(function ($model) {
            $model->user->undoPoint(new BookCaseOrangePilled($model));
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
        $this->addMediaCollection('images');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookCase(): BelongsTo
    {
        return $this->belongsTo(BookCase::class);
    }
}
