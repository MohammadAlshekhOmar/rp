<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\WarrantyRequestCheckId;
use App\Http\Resources\WarrantyDetailResource;
use App\Http\Resources\WarrantyResource;
use App\Services\WarrantyService;

class WarrantyController extends Controller
{
    public function all(WarrantyService $warrantyService)
    {
        $warranties = $warrantyService->allUser(auth('api')->user()->id);
        if ($warranties) {
            $warranties = WarrantyResource::collection($warranties);
            return MyHelper::responseJSON(__('api.warrantyExists'), 200, $warranties);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function details(WarrantyRequestCheckId $warrantyRequestCheckId, WarrantyService $warrantyService)
    {
        $warranty = $warrantyService->details($warrantyRequestCheckId->id);
        if ($warranty) {
            $warranty = WarrantyDetailResource::make($warranty);
            return MyHelper::responseJSON(__('api.warrantyDetail'), 200, $warranty);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
