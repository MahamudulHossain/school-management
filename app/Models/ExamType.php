<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    protected $fillable = [
        'examtype_name',
        'school_class_id',
        'subject_id',
        'term_id',
        'exam_criteria_id',
        'full_marks',
        'pass_marks',
        'exam_code',
    ];

    public function term()
    {
        return $this->belongsTo('App\Models\Term');
    }
    public function schoolClass()
    {
        return $this->belongsTo('App\Models\SchoolClass');
    }
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
    public function exam(){
        return $this->hasMany('App\Models\Exam');
    }
    public function exam_criteria()
    {
        return $this->belongsTo(ExamCriteria::class, 'exam_criteria_id');
    }
}
