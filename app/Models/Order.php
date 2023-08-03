<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use CreatedAtTrait, UpdatedAtTrait;
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'service_id',
        'order_status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
