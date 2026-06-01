<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingTransport extends Model
{
    protected $fillable = [
        'user_id',
        'transport_id',
        'fare_amount',
        'month',
        'due_date',
        'academic_year_id',
        'fine_amount',
        'discount_amount',
        'collect_amount',
        'collect_date',
        'is_status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function transport()
    {
        return $this->belongsTo('App\Models\Transport');
    }
}
