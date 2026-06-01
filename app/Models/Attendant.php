<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Attendant extends Model
{
    protected $fillable = [
        'name',
        'contact_no',
        'nid',
        'email',
        'address',
        'gender',
    ];

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'attendant_student', 'attendant_id', 'student_id');
    }
}
