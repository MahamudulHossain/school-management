<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'personnel_id',
        'card_number',
        'first_name',
        'middle_name',
        'last_name',
        'personal_phone',
        'gender',
        'emergency_contact',
        'blood_group',
        'religion',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function guardian()
    {
        return $this->belongsToMany(Guardian::class,'student_guardians','student_id','guardian_id');
    }
}
