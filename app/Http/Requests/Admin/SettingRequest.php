<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'privacy_policy_ar' => $this->ar['privacy_policy']['value'],
            'privacy_policy_en' => $this->en['privacy_policy']['value'],
            'terms_conditions_ar' => $this->ar['terms_conditions']['value'],
            'terms_conditions_en' => $this->en['terms_conditions']['value'],
            'about_us_ar' => $this->ar['about_us']['value'],
            'about_us_en' => $this->en['about_us']['value'],
            'brand_ar' => $this->ar['brand']['value'],
            'brand_en' => $this->en['brand']['value'],
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'privacy_policy_ar' => 'required',
            'privacy_policy_en' => 'required',
            'terms_conditions_ar' => 'required',
            'terms_conditions_en' => 'required',
            'about_us_ar' => 'required',
            'about_us_en' => 'required',
            'brand_ar' => 'required',
            'brand_en' => 'required',
        ];
    }
}
