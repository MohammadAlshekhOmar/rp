<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WarrantyDetailResource extends JsonResource
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
        if ($this->file) {
            $res['file'] = $this->file;
            $res['contract_value'] = null;
            $res['contract_date'] = null;
            $res['expiry_date'] = null;
            $res['user'] = null;
            $res['service'] = null;
        } else {
            $res['file'] = null;
            $res['contract_value'] = $this->contract_value;
            $res['contract_date'] = $this->contract_date;
            $res['expiry_date'] = $this->expiry_date;
            if (auth('api')->check()) {
                $res['user'] = null;
                $res['service'] = ServiceResource::make($this->invoice?->order?->service);
            }
            if (auth('provider')->check()) {
                $res['user'] = UserResource::make($this->invoice?->order?->user);
                $res['service'] = ServiceResource::make($this->invoice?->order?->service);
            }
        }
        $res['invoice'] = InvoiceResource::make($this->invoice);
        return $res;
    }
}
