<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;

class FcmToken extends Model
{
    use CreatedAtTrait, UpdatedAtTrait;
    protected $fillable = [
        'token',
        'tokenable_type',
        'tokenable_id'
    ];

    public function tokenable()
    {
        return $this->morphTo();
    }
}
