<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
            'email' => 'required|email|unique:providers|unique:users,email,' . auth('api')->user()->id,
            'phone' => 'required|numeric|digits:10|unique:providers|unique:users,phone,' . auth('api')->user()->id,
            'region_id' => 'nullable|exists:regions,id,deleted_at,NULL',
            'image' => 'nullable|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
