<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventHoliday extends Model
{
    protected $fillable = ['title', 'start_date', 'end_date', 'type'];
}
