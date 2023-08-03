<?php

namespace App\Models;

use App\Traits\CreatedAtTrait;
use App\Traits\UpdatedAtTrait;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use CreatedAtTrait, UpdatedAtTrait;

    public function room_participants()
    {
        return $this->hasMany(RoomPartisipant::class, 'room_id');
    }

    public function messages()
    {
        return $this->hasManyThrough(ChatMessage::class, RoomPartisipant::class, 'room_id', 'room_participant_id');
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'participantable', 'rooms_participants')->withPivot('room_id', 'participantable_id', 'participantable_type');
    }

    public function providers()
    {
        return $this->morphedByMany(Provider::class, 'participantable', 'rooms_participants')->withPivot('room_id', 'participantable_id', 'participantable_type');
    }

    public static function check_room_exists($provider_id, $user_id)
    {
        $roomPartisipantUser = RoomPartisipant::where('participantable_id', $user_id)->where('participantable_type', User::class)->pluck('room_id')->toArray();
        $roomPartisipantProvider = RoomPartisipant::where('participantable_id', $provider_id)->where('participantable_type', Provider::class)->pluck('room_id')->toArray();
        foreach ($roomPartisipantUser as $userRoom) {
            foreach ($roomPartisipantProvider as $providerRoom) {
                if ($userRoom == $providerRoom) {
                    return $userRoom;
                }
            }
        }
        return false;
    }
}
