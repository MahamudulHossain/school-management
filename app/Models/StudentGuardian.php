<?php

namespace App\Models;

use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Database\Eloquent\Model;

class StudentGuardian extends Model
{
    public function students()
    {
        return $this->belongsToMany(Student::class,'student_guardians','guardian_id','student_id');
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class,'guardian_id');
    }
}
