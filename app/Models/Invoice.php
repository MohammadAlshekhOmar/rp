<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use CreatedAtTrait, UpdatedAtTrait;
    use SoftDeletes;

    protected $table = 'invoices';
    protected $fillable = [
        'number',
        'discount',
        'warranty_period',
        'order_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function warranties()
    {
        return $this->hasMany(Warranty::class);
    }
}
