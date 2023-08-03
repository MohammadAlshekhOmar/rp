<?php

namespace App\Http\Requests\Both;

use App\Rules\Exist;
use Illuminate\Foundation\Http\FormRequest;

class AuthEmailRequest extends FormRequest
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
            'email' => ['required', 'email', new Exist('email', $this->type)],
            'password' => 'required',
            'fcm_token' => 'required',
        ];
    }
}
