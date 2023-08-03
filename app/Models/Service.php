<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Service extends Model implements HasMedia
{
    use Translatable;
    use HasFactory;
    use CreatedAtTrait, UpdatedAtTrait;
    use InteractsWithMedia;
    use SoftDeletes;

    public $translatedAttributes = ['name', 'text'];
    protected $hidden = ['translations'];
    protected $table = 'services';

    protected $fillable = [
        'price',
        'has_detail',
        'payment_method_id',
        'category_id',
        'provider_id',
    ];

    protected $casts = [
        'has_detail' => 'boolean',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function rates()
    {
        return $this->hasMany(ServiceRate::class);
    }

    public function getImageAttribute()
    {
        if ($this->getFirstMediaUrl('Service')) {
            return $this->getFirstMediaUrl('Service');
        } else {
            return url('images/logo.jpg');
        }
    }

    public function getImagesAttribute()
    {
        if ($this->getFirstMediaUrl('Service')) {
            return $this->getMedia('Service')->pluck('original_url');
        } else {
            return [];
        }
    }
}
