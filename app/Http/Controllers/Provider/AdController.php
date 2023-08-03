<?php

namespace App\Http\Controllers\Provider;

use App\Enums\DeleteActionEnum;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\AdRequest;
use App\Http\Requests\Provider\AdRequestCheckId;
use App\Http\Requests\Provider\AdRequestEdit;
use App\Http\Resources\AdResource;
use App\Services\AdService;
use App\Services\DeleteService;

class AdController extends Controller
{
    public function all(AdService $adService)
    {
        $ads = $adService->all(auth('provider')->user()->id, 0);
        if ($ads) {
            $ads = AdResource::collection($ads);
            return MyHelper::responseJSON(__('api.adExists'), 200, $ads);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function add(AdRequest $request, AdService $adService)
    {
        $ad = $adService->add($request->all(), auth('provider')->user()->id);
        if ($ad) {
            return MyHelper::responseJSON(__('api.addSuccessfully'), 201, $ad);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function edit(AdRequestEdit $request, AdService $adService)
    {
        $ad = $adService->edit($request->all());
        if ($ad) {
            return MyHelper::responseJSON(__('api.editSuccessfully'), 200, $ad);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function delete(AdRequestCheckId $request, DeleteService $deleteService)
    {
        $ad = $deleteService->delete('Ad', $request->id, DeleteActionEnum::SOFT_DELETE->value, null, null);
        if ($ad) {
            return MyHelper::responseJSON(__('api.deleteSuccessfully'), 200, $ad);
        } else {
            return MyHelper::responseJSON(__('api.noDataFound'), 400);
        }
    }
}
