<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AdService;
use App\Helpers\MyHelper;
use App\Http\Resources\AdResource;
use App\Enums\AdStatusEnum;

class AdController extends Controller
{
    public function all(AdService $adService)
    {
        $ads = $adService->getByStatus(AdStatusEnum::ACCEPTED->value);
        if ($ads) {
            $ads = AdResource::collection($ads);
            return MyHelper::responseJSON(__('api.adExists'), 200, $ads);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
