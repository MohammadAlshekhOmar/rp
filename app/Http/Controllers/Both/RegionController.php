<?php

namespace App\Http\Controllers\Both;

use App\Http\Controllers\Controller;
use App\Helpers\MyHelper;
use App\Http\Resources\RegionResource;
use App\Services\RegionService;

class RegionController extends Controller
{
    public function all(RegionService $regionService)
    {
        $regions = $regionService->all();
        if ($regions) {
            $regions = RegionResource::collection($regions);
            return MyHelper::responseJSON(__('api.regionExists'), 200, $regions);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
