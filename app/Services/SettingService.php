<?php

namespace App\Services;

use App\Enums\SettingEnum;
use App\Models\Setting;

class SettingService
{
    public function all()
    {
        return [
            'privacy_policy' => Setting::where('type', SettingEnum::PrivacyPolicy->value)->first(),
            'terms_conditions' => Setting::where('type', SettingEnum::TermsConditions->value)->first(),
            'about_us' => Setting::where('type', SettingEnum::AboutUs->value)->first(),
            'brand' => Setting::where('type', SettingEnum::Brand->value)->first(),
        ];
    }

    public function edit($request)
    {
        foreach ($request['ar'] as $key => $value) {
            $setting = Setting::where('type', $value['key'])->first();
            $setting->update([
                'ar' => [
                    'value' => $value['value'],
                ],
                'en' => [
                    'value' => $request['en'][$key]['value'],
                ],
            ]);
        }

        return true;
    }

    public function privacyPolicy()
    {
        return Setting::where('type', SettingEnum::PrivacyPolicy->value)->first();
    }

    public function termsConditions()
    {
        return Setting::where('type', SettingEnum::TermsConditions->value)->first();
    }

    public function aboutUs()
    {
        return Setting::where('type', SettingEnum::AboutUs->value)->first();
    }
}
