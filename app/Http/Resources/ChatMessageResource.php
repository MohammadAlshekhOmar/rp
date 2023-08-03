<?php

namespace App\Http\Resources;

use App\Models\Provider;
use App\Models\RoomPartisipant;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $res['id'] = $this->id;
        $res['content'] = $this->content;
        if (auth('api')->check()) {
            $roomPartisipant = RoomPartisipant::find($this->room_participant_id);
            if ($roomPartisipant->participantable_id == auth('api')->user()->id && $roomPartisipant->participantable_type == User::class) {
                $res['sender'] = 'me';
            } else {
                $res['sender'] = 'another';
            }
        } else if (auth('provider')->check()) {
            $roomPartisipant = RoomPartisipant::find($this->room_participant_id);
            if ($roomPartisipant->participantable_id == auth('provider')->user()->id && $roomPartisipant->participantable_type == Provider::class) {
                $res['sender'] = 'me';
            } else {
                $res['sender'] = 'another';
            }
        }
        if ($this->file) {
            $res['file'] = $this->file->first()->original_url;
            $res['type'] = $this->file->first()->getCustomProperty('type');
        } else {
            $res['file'] = null;
            $res['type'] = 'text';
        }

        $res['created_at'] = $this->created_at;
        return $res;
    }
}
