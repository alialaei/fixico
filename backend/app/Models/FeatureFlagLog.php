<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureFlagLog extends Model
{
    protected $fillable = [
        'flag_key',
        'user_identifier',
        'decision',
        'context',
    ];

    protected $casts = [
        'context' => 'array',
    ];
}
