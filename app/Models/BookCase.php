<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Comments\Models\Concerns\HasComments;

class BookCase extends Model
{
    use HasFactory;
    use HasComments;

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
        'lat' => 'double',
        'lon' => 'array',
        'digital' => 'boolean',
        'deactivated' => 'boolean',
    ];

    /*
 * This string will be used in notifications on what a new comment
 * was made.
 */
    public function commentableName(): string
    {
        //
    }

    /*
     * This URL will be used in notifications to let the user know
     * where the comment itself can be read.
     */
    public function commentUrl(): string
    {

    }
}
