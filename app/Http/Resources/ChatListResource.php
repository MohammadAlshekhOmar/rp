<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatListResource extends JsonResource
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
        if (auth('api')->check()) {
            $res['provider'] = [
                'id' => $this->room?->provider?->id,
                'name' => $this->room?->provider?->name,
                'image' => $this->room?->provider?->image,
            ];
        } else {
            $res['user'] = [
                'id' => $this->room?->user?->id,
                'name' => $this->room?->user?->name,
                'image' => $this->room?->user?->image,
            ];
        }
        $lastMessage = $this->room?->messages->last();
        $res['created_at'] = $lastMessage ? $lastMessage->created_at : $this->created_at;
        $res['last_message'] = ChatMessageResource::make($lastMessage);
        return $res;
    }
}
