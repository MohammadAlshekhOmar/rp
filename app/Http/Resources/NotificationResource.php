<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
        $res['type'] = $this->type;
        $res['title'] = $this->title;
        $res['text'] = $this->text;
        if (auth('api')->check()) {
            $order = Order::with(['user' => function ($q) {
                $q->with(['media']);
            }])->find($this->order_id);
            $res['image'] = $order?->user?->image;
        } else {
            $order = Order::with(['service' => function ($q) {
                $q->with(['provider' => function ($q1) {
                    $q1->with(['media']);
                }]);
            }])->find($this->order_id);
            $res['image'] = $order?->service?->provider?->image;
        }
        $res['service_id'] = (int)$this->order?->service_id;
        $res['is_read'] = (int)$this->pivot->is_read;
        $res['created_at'] = $this->created_at;
        return $res;
    }
}
