<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequestEdit extends FormRequest
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
            'email' => 'required|email|unique:providers,email,' . $this->id,
            'phone' => 'required|numeric|digits:10|unique:providers,phone,' . $this->id,
            'password' => 'nullable|min:6|max:15|same:password_confirmation',
            'password_confirmation' => 'nullable|min:6|max:15',
            'regions' => 'nullable|array',
            'regions.*' => 'nullable|exists:regions,id',
            'commercial_register' => 'required|numeric',
            'tax_number' => 'required|numeric',
            'image' => 'nullable|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
            'previous_jobs' => 'nullable|array',
            'previous_jobs.*' => 'nullable|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
