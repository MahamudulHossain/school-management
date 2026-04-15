<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_title',
        'country_code',
        'flag',
        'phone_code',
        'language_code',
        'currency_title',
        'currency_code',
        'currency_major',
        'currency_minor',
        'currency_symbol',
        'status',
    ];

    // In Country.php
    public function setting()
    {
        return $this->hasOne(\App\Models\Setting::class, 'country_id');
    }

}
