<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetupEvent extends Model
{
    use HasFactory;

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
        'meetup_id' => 'integer',
        'start' => 'datetime',
        'attendees' => 'array',
        'might_attendees' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->created_by) {
                $model->created_by = auth()->id();
            }
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function meetup(): BelongsTo
    {
        return $this->belongsTo(Meetup::class);
    }

    /*
    * This string will be used in notifications on what a new comment
    * was made.
    */
    public function commentableName(): string
    {
        return __('Meetup Event');
    }

    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string
    {
        return url()->route('meetup.event.landing', ['country' => $this->meetup->city->country, 'meetupEvent' => $this]);
    }
}
