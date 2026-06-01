<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guardian extends Model
{
    use HasFactory;
    protected $fillable = [
        'father_first_name',
        'father_middle_name',
        'father_last_name',
        'father_phone',
        'father_nid',
        'mother_first_name',
        'mother_middle_name',
        'mother_last_name',
        'mother_phone',
        'mother_nid',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class,'student_guardians','guardian_id','student_id');
    }
}
