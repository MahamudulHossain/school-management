<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingSinvoice extends Model
{
    protected $fillable = [
        'student_id','accounting_sfee_id',
        'amount', 'due_date','academic_year_id',
        'fine_amount', 'discount_amount', 'collect_amount', 'collect_date', 'is_status'
    ];

//    public function student()
//    {
//        return $this->belongsTo('App\Student');
//    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function accounting_sfee()
    {
        return $this->belongsTo('App\Models\AccountingSfee');
    }
}
