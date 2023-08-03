<?php

namespace App\Services;

use App\Models\Service;
use App\Models\ServiceRate;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ServiceService
{
    public function all($provider_id = null, $withTrashed = 1)
    {
        if ($withTrashed) {
            return Service::withTrashed()->with(['media', 'provider', 'category', 'orders'])->get();
        } else {
            if ($provider_id) {
                return Service::with(['media', 'provider', 'category'])->whereHas('category')->where('provider_id', $provider_id)->get();
            } else {
                return Service::with(['media', 'provider', 'category'])->whereHas('category')->get();
            }
        }
    }

    public function getByCategory($category_id)
    {
        return Service::with(['media', 'provider', 'category'])->where('category_id', $category_id)->get();
    }

    public function find($id)
    {
        return Service::withTrashed()->with(['media', 'provider', 'category'])->find($id);
    }

    public function add($request, $provider_id)
    {
        DB::beginTransaction();
        if (auth('admin')->check()) {
            if (isset($request['has_detail'])) {
                $request['has_detail'] = 1;
            }
        }
        $request['provider_id'] = $provider_id;
        $service = Service::create($request);
        foreach ($request['images'] as $image) {
            $service->addMedia($image)->toMediaCollection('Service');
        }
        DB::commit();
        return $service;
    }

    public function edit($request)
    {
        DB::beginTransaction();
        if (auth('admin')->check()) {
            if (isset($request['has_detail'])) {
                $request['has_detail'] = 1;
            } else {
                $request['has_detail'] = 0;
            }
        }
        $service = Service::withTrashed()->find($request['id']);
        if (isset($request['images'])) {
            foreach ($request['images'] as $image) {
                $service->addMedia($image)->toMediaCollection('Service');
            }
        }
        $service->update($request);
        DB::commit();
        return $service;
    }

    public function deleteImage($url)
    {
        $array = explode('/', $url);
        $id = $array[count($array) - 2];
        $media = Media::find($id);
        $media->delete();
        return true;
    }

    public function rates($service_id)
    {
        $service = Service::with(['rates' => function ($q) {
            $q->with(['user']);
        }])->find($service_id);
        return $service->rates;
    }

    public function rate($request, $user_id)
    {
        return ServiceRate::updateOrCreate([
            'user_id' => $user_id,
            'service_id' => $request['id']
        ], [
            'rate' => $request['rate'],
            'text' => $request['text']
        ]);
    }
}
