<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClassSubject extends Model
{
    protected $fillable = [
        'school_class_id',
        'subject_id',
    ];

    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'id', 'subject_id');
    }
}
