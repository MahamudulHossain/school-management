<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioTag extends Model
{
    protected $fillable = [
        'title',
        'tag',
        'status',
    ];
}
