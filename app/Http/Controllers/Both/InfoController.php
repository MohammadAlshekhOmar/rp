<?php

namespace App\Http\Controllers\Both;

use App\Http\Controllers\Controller;
use App\Helpers\MyHelper;
use App\Http\Resources\InfoResource;
use App\Services\InfoService;

class InfoController extends Controller
{
    public function all(InfoService $infoService)
    {
        $infos = $infoService->first();
        if ($infos) {
            $infos = InfoResource::make($infos);
            return MyHelper::responseJSON(__('api.infoExists'), 200, $infos);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
