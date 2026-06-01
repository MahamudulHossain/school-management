<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveType extends Model
{
    use HasFactory;
    protected $fillable = ['leave_type_name','comments'];

    public function leave_track()
    {
        return $this->hasMany('App\Leave_track');
    }
}
