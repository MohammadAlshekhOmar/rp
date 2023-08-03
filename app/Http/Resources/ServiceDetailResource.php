<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceDetailResource extends JsonResource
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
        $res['price'] = $this->price;
        $res['has_detail'] = $this->has_detail;
        $res['image'] = $this->image;
        $res['images'] = $this->images;
        $res['category'] = CategoryResource::make($this->category);
        $res['paymentMethod'] = PaymentMethodResource::make($this->payment_method);
        if (!auth('provider')->check()) {
            $res['provider'] = ProviderResource::make($this->provider);
        }
        if (auth('api')->check()) {
            $user = User::find(auth('api')->user()->id);
            if ($user->hasServiceFavorite($this->id)) {
                $res['favorite'] = true;
            } else {
                $res['favorite'] = false;
            }

            $res['rates'] = ServiceRateResource::collection($user->serviceRates()->get());
        }
        return $res;
    }
}
