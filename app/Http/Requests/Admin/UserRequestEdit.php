<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequestEdit extends FormRequest
{
    protected $auth_id;

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
        if (auth()->guard('api')->check()) {
            $this->auth_id = auth()->user()->id;
        } else {
            $this->auth_id = $this->id;
        }

        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->auth_id,
            'phone' => 'numeric|digits:10|unique:users,phone,' . $this->auth_id,
            'password' => 'nullable|min:6|max:15|same:password_confirmation',
            'password_confirmation' => 'nullable|min:6|max:15',
            'image' => 'nullable|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
