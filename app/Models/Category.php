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

class Category extends Model implements HasMedia
{
    use Translatable;
    use HasFactory;
    use CreatedAtTrait, UpdatedAtTrait;
    use InteractsWithMedia;
    use SoftDeletes;

    public $translatedAttributes = ['name', 'text'];
    protected $hidden = ['translations'];
    protected $table = 'categories';
    protected $fillable = ['name', 'text'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function getImageAttribute()
    {
        if ($this->getFirstMediaUrl('Category')) {
            return $this->getFirstMediaUrl('Category');
        } else {
            return url('images/logo.jpg');
        }
    }
}
