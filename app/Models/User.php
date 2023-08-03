<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;
    use CreatedAtTrait, UpdatedAtTrait;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'verification_code',
        'password',
        'region_id',
        'language_id',
    ];

    protected $hidden = ['password', 'verification_code', 'remember_token'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function rooms()
    {
        return $this->morphToMany(Room::class, 'participantable', "rooms_participants");
    }

    public function participantable()
    {
        return $this->morphMany(RoomPartisipant::class, 'participantable');
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function fcmTokens()
    {
        return $this->morphMany(FcmToken::class, 'tokenable');
    }

    public function notifications()
    {
        return $this->morphToMany(Notification::class, 'notifiable')->withPivot('is_read');
    }

    public function serviceRates()
    {
        return $this->hasMany(ServiceRate::class);
    }

    public function providerRates()
    {
        return $this->hasMany(ProviderRate::class);
    }

    public function service_favorites()
    {
        return $this->hasMany(Favorite::class)->whereHas('service');
    }

    public function provider_favorites()
    {
        return $this->hasMany(Favorite::class)->whereHas('provider');
    }

    public function hasServiceFavorite($service_id)
    {
        if (auth('api')->check()) {
            return $this->whereHas('service_favorites', function ($q) use ($service_id) {
                return $q->where('service_id', $service_id);
            })->exists();
        } else {
            return false;
        }
    }

    public function hasProviderFavorite($provider_id)
    {
        if (auth('api')->check()) {
            return $this->whereHas('provider_favorites', function ($q) use ($provider_id) {
                return $q->where('provider_id', $provider_id);
            })->exists();
        } else {
            return false;
        }
    }

    public function getImageAttribute()
    {
        if ($this->getFirstMediaUrl('User')) {
            return $this->getFirstMediaUrl('User');
        } else {
            return url('images/logo.jpg');
        }
    }
}
