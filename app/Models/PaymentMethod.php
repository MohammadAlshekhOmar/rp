<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use Translatable;
    use HasFactory;
    use CreatedAtTrait, UpdatedAtTrait;
    use SoftDeletes;

    public $translatedAttributes = ['name'];
    protected $table = 'payment_methods';
    protected $fillable = ['created_at'];
}
