<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureFlag extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'enabled',
        'conditions',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'conditions' => 'array',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
}
