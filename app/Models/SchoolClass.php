<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;
    protected $fillable = ['class_name', 'number_of_periods', 'numeric_no'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'school_class_subjects');
    }
}
