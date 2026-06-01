<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'portfolio_tag_id',
        'image',
    ];
    public function tag()
    {
        return $this->belongsTo(PortfolioTag::class, 'portfolio_tag_id');
    }
}
