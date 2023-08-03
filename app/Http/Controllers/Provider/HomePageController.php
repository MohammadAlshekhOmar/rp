<?php

namespace App\Http\Controllers\Provider;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceHomePageResource;
use App\Services\ServiceService;

class HomePageController extends Controller
{
    public function homepage(ServiceService $serviceService)
    {
        $services = $serviceService->all(auth('provider')->user()->id, 0);
        if ($services) {
            $services = ServiceHomePageResource::collection($services);
            return MyHelper::responseJSON(__('api.serviceExists'), 200, $services);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
