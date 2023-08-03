<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithServicesResource extends JsonResource
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
        $res['text'] = $this->text;
        $res['image'] = $this->image;
        $res['min_price_range'] = (int)$this->services()->min('price');
        $res['max_price_range'] = (int)$this->services()->max('price');
        $res['services'] = ServiceResource::collection($this->services);
        $res['no_providers'] = $this->services->pluck('provider_id')->unique()->count();
        return $res;
    }
}
