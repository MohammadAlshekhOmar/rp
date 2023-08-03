<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRateRequest;
use App\Http\Requests\User\ServiceIdRequest;
use App\Http\Resources\ServiceDetailResource;
use App\Http\Resources\ServiceRateResource;
use App\Http\Resources\ServiceResource;
use App\Services\ServiceService;

class ServiceController extends Controller
{
    public function all(ServiceService $serviceService)
    {
        $services = $serviceService->all(null, 0);
        if ($services) {
            $services = ServiceResource::collection($services);
            return MyHelper::responseJSON(__('api.serviceExists'), 200, $services);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function details(ServiceIdRequest $request, ServiceService $serviceService)
    {
        $service = $serviceService->find($request->id);
        if ($service) {
            $service = ServiceDetailResource::make($service);
            return MyHelper::responseJSON(__('api.serviceExists'), 200, $service);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function rate(ServiceRateRequest $request, ServiceService $serviceService)
    {
        $rate = $serviceService->rate($request->only('id', 'rate', 'text'), auth('api')->user()->id);
        if ($rate) {
            $rate = ServiceRateResource::make($rate);
            return MyHelper::responseJSON(__('api.rateSuccessfully'), 200, $rate);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
