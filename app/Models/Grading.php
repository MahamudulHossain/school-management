<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
    protected $table = 'gradings';
    protected $fillable = ['starting_marks','ending_marks','letter_grade','grade_point','remarks'];
}
