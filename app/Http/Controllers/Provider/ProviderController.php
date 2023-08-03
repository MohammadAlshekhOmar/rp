<?php

namespace App\Http\Controllers\Provider;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\RegisterRequest;
use App\Http\Requests\Provider\ProviderEditRequest;
use App\Http\Resources\ProviderDetailResource;
use App\Services\ProviderService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function add(RegisterRequest $request, ProviderService $providerService)
    {
        $provider = $providerService->add($request->only('name', 'email', 'phone', 'password', 'image', 'regions', 'commercial_register', 'tax_number'));
        if ($provider) {
            return MyHelper::responseJSON(__('api.addSuccessfully'), 201, $provider);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function edit(ProviderEditRequest $request, ProviderService $providerService)
    {
        $provider = $providerService->editApi($request->only('name', 'email', 'phone', 'regions', 'commercial_register', 'tax_number', 'text', 'image', 'previous_jobs'), auth('provider')->user()->id);
        if ($provider) {
            $provider = ProviderDetailResource::make($provider);
            return MyHelper::responseJSON(__('api.updateInformationSuccessfully'), 200, $provider);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
