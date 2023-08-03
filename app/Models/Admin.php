<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use CreatedAtTrait, UpdatedAtTrait;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $hidden = ['password', 'verification_code'];
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'verification_code',
    ];

    protected $table = 'admins';

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function fcmTokens()
    {
        return $this->morphMany(FcmToken::class, 'tokenable');
    }

    public function notifications()
    {
        return $this->morphToMany(Notification::class, 'notifiable')->withPivot('is_read');
    }

    public function getImageAttribute()
    {
        if ($this->getFirstMediaUrl('Admin')) {
            return $this->getFirstMediaUrl('Admin');
        } else {
            return url('images/logo.jpg');
        }
    }
}
