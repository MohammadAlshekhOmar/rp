<?php

namespace App\Http\Controllers\Provider;

use App\Enums\DeleteActionEnum;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\ServiceRequest;
use App\Http\Requests\Provider\ServiceRequestCheckId;
use App\Http\Requests\Provider\ServiceRequestEdit;
use App\Http\Resources\ServiceDetailResource;
use App\Services\DeleteService;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function all(ServiceService $serviceService)
    {
        $services = $serviceService->all(auth('provider')->user()->id, 0);
        if ($services) {
            $services = ServiceDetailResource::collection($services);
            return MyHelper::responseJSON(__('api.serviceExists'), 200, $services);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function add(ServiceRequest $request, ServiceService $serviceService)
    {
        $service = $serviceService->add($request->all(), auth('provider')->user()->id);
        if ($service) {
            return MyHelper::responseJSON(__('api.addSuccessfully'), 201, $service);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function edit(ServiceRequestEdit $request, ServiceService $serviceService)
    {
        $service = $serviceService->edit($request->all());
        if ($service) {
            return MyHelper::responseJSON(__('api.editSuccessfully'), 200, $service);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function delete(ServiceRequestCheckId $request, DeleteService $deleteService)
    {
        $service = $deleteService->delete('Service', $request->id, DeleteActionEnum::SOFT_DELETE->value, null, null);
        if ($service) {
            return MyHelper::responseJSON(__('api.deleteSuccessfully'), 200, $service);
        } else {
            return MyHelper::responseJSON(__('api.noDataFound'), 400);
        }
    }

    public function deleteImage(Request $request, ServiceService $serviceService)
    {
        $service = $serviceService->deleteImage($request->url);
        if ($service) {
            return MyHelper::responseJSON(__('api.deleteSuccessfully'), 200, $service);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
