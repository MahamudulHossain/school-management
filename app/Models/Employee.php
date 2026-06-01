<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'personnel_id',
        'card_number',
        'first_name',
        'middle_name',
        'last_name',
        'designation',
        'father_name',
        'father_phone',
        'father_email',
        'father_nid',
        'mother_name',
        'mother_phone',
        'mother_email',
        'mother_nid',
        'emergency_contact',
        'blood_group',
        'marital_status',
        'religion',
        'spouse_name',
        'status',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
