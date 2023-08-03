<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;

class Favorite extends Model
{
    use CreatedAtTrait, UpdatedAtTrait;

    protected $table = 'favorites';
    protected $fillable = ['service_id', 'provider_id', 'user_id'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
