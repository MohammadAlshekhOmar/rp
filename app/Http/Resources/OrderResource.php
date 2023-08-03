<?php

namespace App\Http\Resources;

use App\Models\Invoice;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
        if (!auth()->guard('api')->check()) {
            $res['user'] = UserResource::make($this->user);
        }
        $res['service'] = ServiceDetailResource::make($this->service);
        $res['order_status'] = OrderStatusResource::make($this->order_status);
        if (Invoice::where('order_id', $this->id)->exists()) {
            $invoice = Invoice::where('order_id', $this->id)->first();
            $res['invoice'] = InvoiceResource::make($invoice);
            $res['total'] = $this->service->price - ($this->service->price * $invoice->discount / 100);
        } else {
            $res['invoice'] = null;
        }
        $res['created_at'] = $this->created_at;
        return $res;
    }
}
