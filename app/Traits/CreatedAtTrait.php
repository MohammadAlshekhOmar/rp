<?php

namespace App\Traits;

trait CreatedAtTrait
{
    function getCreatedAtAttribute()
    {
        if (auth()->guard('admin')->check()) {
            $date = \Carbon\Carbon::parse($this->attributes['created_at']);
            return $date->diffForHumans(\Carbon\Carbon::now());
        } else {
            return date('Y-m-d H:i:s', strtotime($this->attributes['created_at']));
        }
    }
}
