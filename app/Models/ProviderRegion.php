<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderRegion extends Model
{
    use HasFactory;
    use CreatedAtTrait, UpdatedAtTrait;

    protected $table = 'provider_regions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'provider_id',
        'region_id',
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
