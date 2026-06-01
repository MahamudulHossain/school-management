<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;
    protected $fillable=[
        'pre_house','pre_road','pre_state','pre_post','pre_thana','pre_district','pre_division',
        'per_house','per_road','per_state','per_post','per_thana','per_district','per_division',
        'emergency_contract'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
