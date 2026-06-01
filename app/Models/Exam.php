<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'user_id',
        'exam_mark',
        'roll',
        'school_class_id',
        'school_section_id',
        'subject_id',
        'academic_year_id',
        'obtain_mark',
        'added_mark',
        'examtype_name',
        'exam_type_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function student()
    {
        return $this->belongsTo('App\Models\Student');
    }
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
    public function examType()
    {
        return $this->belongsTo('App\Models\ExamType');
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
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
    public function term()
    {
        return $this->belongsTo('App\Models\Term');
    }
}
