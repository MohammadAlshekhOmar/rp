<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
        $res['text'] = $this->text;
        $res['image'] = $this->image;
        $res['status'] = AdStatusResource::make($this->ad_status);
        if (!auth()->guard('provider')->check()) {
            $res['provider'] = ProviderResource::make($this->provider);
        }
        return $res;
    }
}
