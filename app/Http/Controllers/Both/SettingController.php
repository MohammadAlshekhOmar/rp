<?php

namespace App\Http\Controllers\Both;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use App\Helpers\MyHelper;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    public function privacyPolicy(SettingService $settingService)
    {
        $setting = $settingService->privacyPolicy();
        if ($setting) {
            $setting = SettingResource::make($setting);
            return MyHelper::responseJSON(__('api.settingExists'), 200, $setting);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function termsConditions(SettingService $settingService)
    {
        $setting = $settingService->termsConditions();
        if ($setting) {
            $setting = SettingResource::make($setting);
            return MyHelper::responseJSON(__('api.settingExists'), 200, $setting);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }

    public function aboutUs(SettingService $settingService)
    {
        $setting = $settingService->aboutUs();
        if ($setting) {
            $setting = SettingResource::make($setting);
            return MyHelper::responseJSON(__('api.settingExists'), 200, $setting);
        } else {
            return MyHelper::responseJSON(__('api.unknownError'), 500);
        }
    }
}
