<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:providers',
            'phone' => 'required|numeric|digits:10|unique:providers',
            'password' => 'required|min:6|max:15|same:password_confirmation',
            'password_confirmation' => 'required|min:6|max:15',
            'regions' => 'required|array',
            'regions.*' => 'required|exists:regions,id',
            'commercial_register' => 'required|numeric',
            'tax_number' => 'required|numeric',
            'image' => 'required|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
            'previous_jobs' => 'required|array',
            'previous_jobs.*' => 'required|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
