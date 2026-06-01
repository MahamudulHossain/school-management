<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'school_class_id',
        'school_section_id',
        'academic_year_id',
        'attendance_by',
        'roll',
        'date',
        'attendance',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
    public function teachers()
    {
        return $this->hasMany('App\Models\Teacher');
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
