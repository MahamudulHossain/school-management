<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoutine extends Model
{
    protected $fillable = [
        'school_class_id',
        'school_section_id',
        'academic_year_id',
        'shift',
        'day_of_week',
        'period_number',
        'subject_id',
        'teacher_id',
    ];

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
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
