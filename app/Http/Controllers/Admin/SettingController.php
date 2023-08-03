<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Services\SettingService;
use App\Helpers\MyHelper;

class SettingController extends Controller
{
    public function index(SettingService $settingService)
    {
        $settings = $settingService->all();
        return view('Admin.SubViews.Setting.index', [
            'settings' => $settings,
        ]);
    }

    public function edit(SettingRequest $request, SettingService $settingService)
    {
        $setting = $settingService->edit($request->all());
        if ($setting) {
            return MyHelper::responseJSON('تم التعديل بنجاح', 200, $setting);
        } else {
            return MyHelper::responseJSON('حدث خطأ أثناء تنفيذ العملية', 500);
        }
    }
}
