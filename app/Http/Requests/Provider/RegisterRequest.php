<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users|unique:providers',
            'phone' => 'required|numeric|digits:10|unique:users|unique:providers',
            'regions' => 'required|array',
            'regions.*' => 'required|exists:regions,id,deleted_at,NULL',
            'commercial_register' => 'required|numeric',
            'tax_number' => 'required|numeric',
            'password' => 'required|min:6|max:15|same:password_confirmation',
            'password_confirmation' => 'required|min:6|max:15',
            'image' => 'required|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
