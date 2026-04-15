<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
   use HasFactory;
    protected $fillable = ['user_id','contact_no1','contact_no2','gender','address'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function company_name()
    {
        return $this->belongsTo(CompanyName::class);
    }
}
