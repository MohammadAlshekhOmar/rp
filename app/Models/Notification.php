<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use Translatable;
    use HasFactory;
    use CreatedAtTrait, UpdatedAtTrait;

    public $translatedAttributes = ['title', 'text'];
    protected $hidden = ['translations'];
    protected $fillable = ['type', 'order_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'notifiable')->withPivot('is_read');
    }

    public function providers()
    {
        return $this->morphedByMany(Provider::class, 'notifiable')->withPivot('is_read');
    }
}
