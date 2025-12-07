<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDamageReport extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
    ];
}
