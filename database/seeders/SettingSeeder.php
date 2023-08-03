<?php

namespace Database\Seeders;

use App\Enums\SettingEnum;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'type' => SettingEnum::PrivacyPolicy->value,
            'ar' => [
                'value' => 'سياسة الخصوصية',
            ],
            'en' => [
                'value' => 'privacy policy',
            ],
        ]);

        Setting::create([
            'type' => SettingEnum::TermsConditions->value,
            'ar' => [
                'value' => 'الشروط والأحكام',
            ],
            'en' => [
                'value' => 'terms conditions',
            ],
        ]);

        Setting::create([
            'type' => SettingEnum::AboutUs->value,
            'ar' => [
                'value' => 'معلومات عنا',
            ],
            'en' => [
                'value' => 'about us',
            ],
        ]);

        Setting::create([
            'type' => SettingEnum::Brand->value,
            'ar' => [
                'value' => 'اسم المشروع',
            ],
            'en' => [
                'value' => 'ProjectName',
            ],
        ]);
    }
}
