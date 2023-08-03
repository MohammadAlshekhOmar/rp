<?php

namespace App\Http\Requests\Both;

use App\Rules\Exist;
use Illuminate\Foundation\Http\FormRequest;

class AuthPhoneRequest extends FormRequest
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
            'phone' => ['required', 'numeric', new Exist('phone', $this->type)],
        ];
    }
}
