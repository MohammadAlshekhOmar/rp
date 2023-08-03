<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProviderRateRequest;
use App\Http\Requests\User\ProviderIdRequest;
use App\Http\Resources\ProviderDetailResource;
use App\Http\Resources\ProviderRateResource;
use App\Services\ProviderService;

class ProviderController extends Controller
{
    public function details(ProviderIdRequest $request, ProviderService $providerService)
    {
        $provider = $providerService->find($request->id);
        if ($provider) {
            $provider = ProviderDetailResource::make($provider);
            return MyHelper::responseJSON(__('api.providerExists'), 200, $provider);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function rate(ProviderRateRequest $request, ProviderService $providerService)
    {
        $rate = $providerService->rate($request->only('id', 'rate', 'text'), auth('api')->user()->id);
        if ($rate) {
            $rate = ProviderRateResource::make($rate);
            return MyHelper::responseJSON(__('api.rateSuccessfully'), 200, $rate);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
