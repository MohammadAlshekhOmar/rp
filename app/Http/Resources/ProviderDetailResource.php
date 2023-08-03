<?php

namespace App\Http\Resources;

use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderDetailResource extends JsonResource
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
        $res['email'] = $this->email;
        $res['phone'] = $this->phone;
        $res['text'] = $this->text;
        $res['commercial_register'] = $this->commercial_register;
        $res['tax_number'] = $this->tax_number;
        $res['text'] = $this->text;
        $res['image'] = $this->image;
        $res['previous_jobs'] = $this->previous_jobs;
        $region_ids = $this->regions->pluck('region_id');
        $regions = Region::whereIn('id', $region_ids)->get();
        $res['regions'] = RegionResource::collection($regions);
        $res['services'] = ServiceResource::collection($this->services);

        if (auth('api')->check()) {
            $user = User::find(auth('api')->user()->id);
            if ($user->hasProviderFavorite($this->id)) {
                $res['favorite'] = true;
            } else {
                $res['favorite'] = false;
            }
        }
        return $res;
    }
}
