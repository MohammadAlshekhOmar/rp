<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Info extends Model implements HasMedia
{
    use CreatedAtTrait, UpdatedAtTrait;
    use InteractsWithMedia;

    protected $table = 'infos';
    protected $fillable = ['email', 'phone', 'facebook', 'instagram', 'twitter', 'whatsapp', 'youtube'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }
}
