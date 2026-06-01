<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShiftPeriod extends Model
{
    use HasFactory;
    protected $fillable = [
        'shift_id',
        'period_number',
        'type',
        'title',
        'start_time',
        'end_time',
    ];
}
