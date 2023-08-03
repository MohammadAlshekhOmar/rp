<?php

namespace App\Services;

use App\Enums\AdStatusEnum;
use App\Models\Ad;
use Illuminate\Support\Facades\DB;

class AdService
{
    public function all($provider_id = null, $withTrashed = 1)
    {
        if ($withTrashed) {
            return Ad::withTrashed()->with(['media', 'provider', 'ad_status'])->get();
        } else {
            if ($provider_id) {
                return Ad::with(['media', 'provider', 'ad_status'])->where('provider_id', $provider_id)->get();
            } else {
                return Ad::with(['media', 'provider', 'ad_status'])->get();
            }
        }
    }

    public function getByStatus($status_id)
    {
        return Ad::with(['media', 'provider', 'ad_status'])->where('ad_status_id', $status_id)->get();
    }

    public function find($id)
    {
        $ad = Ad::withTrashed()->with(['media', 'provider', 'ad_status'])->find($id);
        $ad->image = $ad->image;
        $ad->ar = [
            'text' => $ad->translate('ar')->text,
        ];
        $ad->en = [
            'text' => $ad->translate('en')->text,
        ];
        return $ad;
    }

    public function add($request, $provider_id)
    {
        DB::beginTransaction();
        $request['provider_id'] = $provider_id;
        $ad = Ad::create($request);
        $ad->addMedia($request['image'])->toMediaCollection('Ad');
        $ad = Ad::with(['media', 'provider', 'ad_status'])->find($ad->id);
        $ad->image = $ad->image;
        DB::commit();
        return $ad;
    }

    public function edit($request)
    {
        DB::beginTransaction();
        $ad = Ad::withTrashed()->with(['media', 'provider'])->find($request['id']);
        if (isset($request['image'])) {
            $ad->clearMediaCollection('Ad');
            $ad->addMedia($request['image'])->toMediaCollection('Ad');
        }
        $ad->update($request);
        $ad = Ad::withTrashed()->with(['media', 'provider'])->find($ad->id);
        $ad->image = $ad->image;
        DB::commit();
        return $ad;
    }

    public function accept($id)
    {
        $ad = Ad::find($id);
        $ad->update([
            'ad_status_id' => AdStatusEnum::ACCEPTED->value,
        ]);
        return $ad;
    }

    public function reject($id)
    {
        $ad = Ad::find($id);
        $ad->update([
            'ad_status_id' => AdStatusEnum::REJECTED->value,
        ]);
        return $ad;
    }
}
