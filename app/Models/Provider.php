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

class Provider extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;
    use CreatedAtTrait, UpdatedAtTrait;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $table = 'providers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'text',
        'verification_code',
        'password',
        'language_id',
        'commercial_register',
        'tax_number',
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

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function regions()
    {
        return $this->hasMany(ProviderRegion::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function rates()
    {
        return $this->hasMany(ProviderRate::class);
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
        $filteredCollection = $this->getMedia('Provider', function (Media $media) {
            return !isset($media->custom_properties['previous_jobs']);
        });

        if ($filteredCollection->first()) {
            return $filteredCollection->first()->original_url;
        } else {
            return url('images/logo.jpg');
        }
    }

    public function getPreviousJobsAttribute()
    {
        if ($this->getMedia('Provider', ['previous_jobs' => true])->first()) {
            return $this->getMedia('Provider', ['previous_jobs' => true])->pluck('original_url');
        } else {
            return [];
        }
    }
}
