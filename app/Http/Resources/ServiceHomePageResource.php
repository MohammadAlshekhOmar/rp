<?php

namespace App\Http\Resources;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceHomePageResource extends JsonResource
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
        $res['name'] = $this->name;
        $res['image'] = $this->image;
        if (!auth('provider')->check()) {
            $res['provider'] = ProviderResource::make($this->provider);
        }

        $noPendingOrders = Order::where('service_id', $this->id)->where('order_status_id', OrderStatusEnum::PENDING)->count();

        $noAcceptedOrders = Order::where('service_id', $this->id)->whereHas('service', function ($q) {
            $q->where('provider_id', auth('provider')->user()->id);
        })->where('order_status_id', OrderStatusEnum::ACCEPTED)->count();

        $noRejectedOrders = Order::where('service_id', $this->id)->whereHas('service', function ($q) {
            $q->where('provider_id', auth('provider')->user()->id);
        })->where('order_status_id', OrderStatusEnum::REJECTED)->count();

        $noFinishedOrders = Order::where('service_id', $this->id)->whereHas('service', function ($q) {
            $q->where('provider_id', auth('provider')->user()->id);
        })->where('order_status_id', OrderStatusEnum::FINISHED)->count();

        $res['all'] = $noPendingOrders + $noAcceptedOrders + $noRejectedOrders + $noFinishedOrders;
        $res['pending'] = $noPendingOrders;
        $res['accepted'] = $noAcceptedOrders;
        $res['rejected'] = $noRejectedOrders;
        $res['finished'] = $noFinishedOrders;
        return $res;
    }
}
