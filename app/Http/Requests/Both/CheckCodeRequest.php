<?php

namespace App\Http\Requests\Both;

use App\Rules\Exist;
use Illuminate\Foundation\Http\FormRequest;

class CheckCodeRequest extends FormRequest
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
        $type = (preg_match("/^[^@]*@[^@]*\.[^@]*$/", $this->username)) ? 'email' : 'phone';
        if ($type == 'email') {
            return [
                'username' => ['required', 'email', new Exist('email', $this->type)],
                'verification_code' => 'required'
            ];
        } else {
            return [
                'username' => ['required', 'numeric', new Exist('phone', $this->type)],
                'verification_code' => 'required'
            ];
        }
    }
}
