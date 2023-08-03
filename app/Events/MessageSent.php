<?php

namespace App\Events;

use App\Models\ChatMessage;
use App\Models\Provider;
use App\Models\Room;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\ChatMessageResource;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user;
    private $room;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User | Provider $user, Room $room, ChatMessage $message)
    {
        $this->user = $user;
        $this->room = $room;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $channels = [];
        foreach ($this->room->room_participants as $user) {
            if ($user->participantable_type == Provider::class && get_class($this->user) != Provider::class) {
                array_push($channels, new PrivateChannel('provider.' . $user->participantable_id));
            } else if ($user->participantable_type == User::class && get_class($this->user) != User::class) {
                array_push($channels, new PrivateChannel('user.' . $user->participantable_id));
            } else if ($user->participantable_type == User::class && get_class($this->user) == User::class && $user->participantable_id != $this->user->id) {
                array_push($channels, new PrivateChannel('user.' . $user->participantable_id));
            }
        }

        return $channels;
    }

    public function broadcastAs()
    {
        return 'newmessage';
    }

    public function broadcastWith()
    {
        return ChatMessageResource::make($this->message)->resolve();
    }
}
