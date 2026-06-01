<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseType extends Model
{
    protected $fillable = [
        'expense_name',
    ];

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense');
    }
}
