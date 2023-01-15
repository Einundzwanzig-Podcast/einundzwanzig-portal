<?php

namespace App\Models;

use App\Gamify\Points\BookCaseOrangePilled;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrangePill extends Model
{
    use HasFactory;

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
        'id'           => 'integer',
        'user_id'      => 'integer',
        'book_case_id' => 'integer',
        'date'         => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user->givePoint(new BookCaseOrangePilled($model));
        });
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
