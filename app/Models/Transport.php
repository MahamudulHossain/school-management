<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $fillable = [
        'title',
        'route_info',
        'vehicle_info',
        'driver_info',
        'fare',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
