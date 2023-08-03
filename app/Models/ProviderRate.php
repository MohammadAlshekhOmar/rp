<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;

class ProviderRate extends Model
{
    use CreatedAtTrait, UpdatedAtTrait;

    protected $table = 'provider_rates';
    protected $fillable = ['rate', 'text', 'provider_id', 'user_id'];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
