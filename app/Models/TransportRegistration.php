<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'transport_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transport()
    {
        return $this->belongsTo('App\Models\Transport');
    }

}
