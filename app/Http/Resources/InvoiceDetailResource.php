<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceDetailResource extends JsonResource
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
        $res['number'] = $this->number;
        $res['discount'] = $this->discount;
        $res['warranty_period'] = $this->warranty_period;
        $res['order'] = OrderResource::make($this->order);
        return $res;
    }
}
