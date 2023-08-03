<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;

class ServiceRate extends Model
{
    use CreatedAtTrait, UpdatedAtTrait;

    protected $table = 'service_rates';
    protected $fillable = ['rate', 'text', 'service_id', 'user_id'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
