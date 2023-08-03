<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequestEdit extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $this->id,
            'phone' => 'required|numeric|digits:10|unique:admins,phone,' . $this->id,
            'password' => 'nullable|min:6|max:15|same:password_confirmation',
            'password_confirmation' => 'nullable|min:6|max:15',
			'role_id' => 'required|exists:roles,id',
            'image' => 'image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
