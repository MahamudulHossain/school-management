<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectClassExamCriteriaMapping extends Model
{
    protected $fillable = [
        'school_class_id',
        'subject_id',
        'exam_criteria_id'
    ];

    public function exam_criteria()
    {
        return $this->belongsTo(ExamCriteria::class, 'exam_criteria_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
}
