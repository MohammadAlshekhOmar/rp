<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Warranty extends Model implements HasMedia
{
    use CreatedAtTrait, UpdatedAtTrait;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = 'warranties';
    protected $fillable = [
        'contract_value',
        'contract_date',
        'expiry_date',
        'invoice_id',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getFileAttribute()
    {
        if ($this->getFirstMediaUrl('Warranty')) {
            return $this->getFirstMediaUrl('Warranty');
        } else {
            return null;
        }
    }
}
