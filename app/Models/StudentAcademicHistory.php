<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentAcademicHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',
        'section_id',
        'academic_year_id',
        'roll',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function student_class()
    {
        return $this->belongsTo('App\Models\SchoolClass', 'school_class_id');
    }
    public function academic_year()
    {
        return $this->belongsTo('App\Models\AcademicYear');
    }
    public function student_section()
    {
        return $this->belongsTo('App\Models\SchoolSection', 'school_section_id');
    }
}
