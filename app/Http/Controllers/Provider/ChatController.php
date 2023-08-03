<?php

namespace App\Http\Controllers\Provider;

use App\Events\MessageSent;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\SendMessageRequest;
use App\Http\Requests\User\UserRequestCheckId;
use App\Http\Resources\ChatListResource;
use App\Http\Resources\ChatMessageResource;
use App\Models\ChatMessage;
use App\Models\Provider;
use App\Models\Room;
use App\Models\RoomPartisipant;
use App\Models\User;
use App\Services\FirebaseNotification;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    protected $firebaseNotification;
    public function __construct()
    {
        $this->firebaseNotification = new FirebaseNotification();
    }

    public function chatList()
    {
        DB::beginTransaction();
        $provider = Provider::with(['rooms' => function ($q) {
            $q->with(['messages']);
        }])->find(auth('provider')->user()->id);
        $rooms = $provider->rooms()->paginate(8);

        $chats = [];
        foreach ($rooms as $room) {
            foreach ($room->room_participants()->get() as $room_participant) {
                if ($room_participant->participantable_id == $provider->id && $room_participant->participantable_type == Provider::class) {
                    continue;
                }
                // $room_participant->room->messages = $room_participant->room->messages->sortBy('id')->values()->all();
                $room_participant->room->user = $room_participant->room->users->first();
                $chats[] = $room_participant;
            }
        }

        $chats = ChatListResource::collection($chats)->resolve();
        usort($chats, function ($element1, $element2) {
            $datetime1 = strtotime($element1['created_at']);
            $datetime2 = strtotime($element2['created_at']);
            return $datetime2 - $datetime1;
        });

        DB::commit();
        return MyHelper::responseJSON(__('api.chatsExists'), 200, $chats);
    }

    public function chat(UserRequestCheckId $request)
    {
        DB::beginTransaction();
        $provider = Provider::find(auth('provider')->user()->id);
        $room = Room::with(['messages'])->whereIn('id', $provider->rooms->pluck('id')->toArray())->whereHas('room_participants', function ($query) use ($request) {
            $query->where('participantable_id', $request->id)->where('participantable_type', User::class);
        })->first();
        if ($room) {
            $room->messages = $room->messages()->orderByDesc('id')->paginate(8);
            $chat = ChatMessageResource::collection($room->messages);
            DB::commit();
            return MyHelper::responseJSON(__('api.chatExists'), 200, $chat);
        } else {
            return MyHelper::responseJSON(__('api.noDataFound'), 200, []);
        }
    }

    public function sendMessage(SendMessageRequest $request)
    {
        DB::beginTransaction();
        $provider = Provider::find(auth('provider')->user()->id);
        $user = User::find($request->id);

        $room_id = Room::check_room_exists($provider->id, $user->id);
        if ($room_id) {
            $room = Room::find($room_id);
        } else {
            $room = Room::create();
            RoomPartisipant::create([
                'participantable_id' => $provider->id,
                'participantable_type' => Provider::class,
                'room_id' => $room->id,
            ]);

            RoomPartisipant::create([
                'participantable_id' => $user->id,
                'participantable_type' => User::class,
                'room_id' => $room->id,
            ]);
        }

        $room_participant_id = RoomPartisipant::where('room_id', $room->id)
            ->where('participantable_type', Provider::class)
            ->where('participantable_id', $provider->id)?->first()?->id;

        $reciver = RoomPartisipant::where('room_id', $room->id)
            ->where('participantable_type', '!=', Provider::class)->first();

        $chatMessage = ChatMessage::create([
            'room_participant_id' => $room_participant_id,
            'content' => $request->content,
        ]);

        if (isset($request->file)) {
            $type = strtok($request->file->getClientMimeType(), '/');
            $chatMessage->addMedia($request->file)->withCustomProperties(['type' => $type])->toMediaCollection('ChatMessage');
        }

        broadcast(new MessageSent($provider, $room, $chatMessage))->toOthers();

        $reciver_id = $reciver->participantable->id;
        if ($reciver->participantable_type == User::class) {
            $data = [
                'type' => 'chat',
                'title_ar' => 'وصلتك رسالة جديدة',
                'title_en' => 'New Message',
                'text_ar' => $request->content,
                'text_en' => $request->content,
            ];
            $extra = [
                'type' => 'chat',
            ];
            $this->sendUserNotification($data, $reciver_id, $extra);
        }

        DB::commit();
        return MyHelper::responseJSON(__('api.sendMessageSuccessfully'), 200, $chatMessage);
    }
}
