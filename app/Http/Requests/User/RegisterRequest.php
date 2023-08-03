<?php

namespace App\Http\Requests\User;

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
            'email' => 'required|email|unique:providers|unique:users',
            'phone' => 'required|numeric|digits:10|unique:providers|unique:users',
            'region_id' => 'required|exists:regions,id,deleted_at,NULL',
            'password' => 'required|min:6|max:15|same:password_confirmation',
            'password_confirmation' => 'required|min:6|max:15',
            'image' => 'required|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
