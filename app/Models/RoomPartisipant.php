<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Illuminate\Database\Eloquent\Model;

class RoomPartisipant extends Model
{
    use CreatedAtTrait, UpdatedAtTrait;

    protected $fillable = ['participantable_id', 'participantable_type', 'room_id'];
    protected $table = 'rooms_participants';

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'room_participant_id');
    }

    public function participantable()
    {
        return $this->morphTo('participantable');
    }
}
