<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

class ProviderEditRequest extends FormRequest
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
            'name' => 'nullable|string',
            'email' => 'required|email|unique:users|unique:providers,email,' . auth('provider')->user()->id,
            'phone' => 'required|numeric|digits:10|unique:users|unique:providers,phone,' . auth('provider')->user()->id,
            'regions' => 'nullable|array',
            'regions.*' => 'nullable|exists:regions,id,deleted_at,NULL',
            'commercial_register' => 'nullable|numeric',
            'tax_number' => 'nullable|numeric',
            'image' => 'nullable|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
            'previous_jobs' => 'nullable|array',
            'previous_jobs.*' => 'nullable|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
