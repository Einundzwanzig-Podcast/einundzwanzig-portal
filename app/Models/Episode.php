<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Tags\HasTags;

class Episode extends Model
{
    use HasFactory;
    use HasTags;

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
        'podcast_id' => 'integer',
        'data'       => 'array',
    ];

    public function podcast(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Podcast::class);
    }

    public function libraryItem(): HasOne
    {
        return $this->hasOne(LibraryItem::class);
    }
}