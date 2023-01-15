<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwitterAccount extends Model
{
    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];
}
