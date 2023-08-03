<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_ar' => 'required|max:50',
            'title_en' => 'required|max:50',
            'text_ar' => 'required|max:200',
            'text_en' => 'required|max:200',
            'users' => 'required_without:providers',
            'providers' => 'required_without:users',
        ];
    }
}
