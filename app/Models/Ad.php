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

class Ad extends Model implements HasMedia
{
    use Translatable;
    use HasFactory;
    use CreatedAtTrait, UpdatedAtTrait;
    use InteractsWithMedia;
    use SoftDeletes;

    public $translatedAttributes = ['text'];
    protected $hidden = ['translations'];
    protected $table = 'ads';

    protected $fillable = [
        'provider_id',
        'ad_status_id',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function ad_status()
    {
        return $this->belongsTo(AdStatus::class);
    }

    public function getImageAttribute()
    {
        if ($this->getFirstMediaUrl('Ad')) {
            return $this->getFirstMediaUrl('Ad');
        } else {
            return url('images/logo.jpg');
        }
    }
}
