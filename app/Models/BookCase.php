<?php

namespace App\Models;

use Akuechler\Geoly;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Comments\Exceptions\CannotCreateComment;
use Spatie\Comments\Models\Comment;
use Spatie\Comments\Models\Concerns\HasComments;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;
use Spatie\Comments\Support\Config;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BookCase extends Model implements HasMedia
{
    use HasFactory;
    use HasComments;
    use InteractsWithMedia;
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
        'id'          => 'integer',
        'lat'         => 'double',
        'lon'         => 'array',
        'digital'     => 'boolean',
        'deactivated' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->created_by) {
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
        $this->addMediaCollection('images');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function orangePills(): HasMany
    {
        return $this->hasMany(OrangePill::class);
    }

    /*
     * This string will be used in notifications on what a new comment
     * was made.
     */
    public function commentableName(): string
    {
        return __('Bookcase');
    }

    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string
    {
        return url()->route('bookCases.comment.bookcase', ['bookCase' => $this->id]);
    }

    public function comment(string $text, CanComment $commentator = null): Comment
    {
        // $commentator ??= auth()->user();

        if (! config('comments.allow_anonymous_comments')) {
            if (! $commentator) {
                throw CannotCreateComment::userIsRequired();
            }
        }

        $parentId = ($this::class === Config::getCommentModelName())
            ? $this->getKey()
            : null;

        $comment = $this->comments()->create([
            'commentator_id' => $commentator?->getKey() ?? null,
            'commentator_type' => $commentator?->getMorphClass() ?? null,
            'original_text' => $text,
            'parent_id' => $parentId,
        ]);

        if ($comment->shouldBeAutomaticallyApproved()) {
            Config::approveCommentAction()->execute($comment);

            return $comment;
        }

        Config::sendNotificationsForPendingCommentAction()->execute($comment);

        return $comment;
    }
}
