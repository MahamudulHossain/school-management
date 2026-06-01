<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamCriteria extends Model
{
    protected $fillable = [
        'criteria_name',
        'status',
    ];
}
