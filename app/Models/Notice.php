<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notice extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'details'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function getExcerpt($str, $startPos = 0, $maxLength = 250) {
        if(strlen($str) > $maxLength) {
            $excerpt   = substr($str, $startPos, $maxLength - 6);
            $lastSpace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastSpace);
            $excerpt  .= ' ... ';
        } else {
            $excerpt = $str;
        }

        return $excerpt;
    }
}
