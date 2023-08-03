<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InfoRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
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
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'facebook' => 'required',
            'instagram' => 'required',
            'twitter' => 'required',
            'whatsapp' => 'required',
            'youtube' => 'required',
        ];
    }
}
