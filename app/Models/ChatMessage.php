<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ChatMessage extends Model implements HasMedia
{
    use CreatedAtTrait, UpdatedAtTrait;
    use InteractsWithMedia;

    protected $fillable = ['room_participant_id', 'content'];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    public function sender()
    {
        return $this->belongsTo(RoomPartisipant::class, 'room_participant_id');
    }

    public function receivers()
    {
        return $this->belongsToMany(RoomPartisipant::class, 'chat_message_receivers', 'chat_message_id', 'room_participant_id');
    }

    public function room_participant()
    {
        return $this->belongsTo(RoomPartisipant::class, 'room_participant_id');
    }

    public function getFileAttribute()
    {
        if ($this->getFirstMediaUrl('ChatMessage')) {
            return $this->getMedia('ChatMessage');
        } else {
            return null;
        }
    }
}
