<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'expense_type_id',
        'expense_date',
        'expense_amount',
        'comments',
    ];

    public function expense_type()
    {
        return $this->belongsTo('App\Models\ExpenseType');
    }
}
