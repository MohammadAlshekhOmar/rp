<?php

namespace App\Traits;

trait UpdatedAtTrait
{
    public function getUpdatedAtAttribute()
    {
        if (auth()->guard('admin')->check()) {
            $date = \Carbon\Carbon::parse($this->attributes['updated_at']);
            return $date->diffForHumans(\Carbon\Carbon::now());
        } else {
            return date('Y-m-d H:i:s', strtotime($this->attributes['updated_at']));
        }
    }
}
