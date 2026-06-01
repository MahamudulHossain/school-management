<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingSfee extends Model
{
    protected $fillable = [
        'school_class_id',
        'fee_name',
        'description',
        'amount',
    ];
    public function student_class()
    {
        return $this->belongsTo('App\Models\SchoolClass', 'school_class_id');
    }
    public function accounting_sinvoices()
    {
        return $this->hasMany('App\Models\Accounting_sinvoices');
    }
}
