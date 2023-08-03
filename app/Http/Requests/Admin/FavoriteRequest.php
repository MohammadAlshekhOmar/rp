<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FavoriteRequest extends FormRequest
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
        if (!isset($this->type)) {
            return [
                'type' => 'required',
            ];
        }

        if ($this->type == 'service') {
            return [
                'id' => 'required|exists:services,id',
            ];
        } elseif ($this->type == 'provider') {
            return [
                'id' => 'required|exists:providers,id',
            ];
        } else {
            return [
                'type' => Rule::in(['service', 'provider']),
            ];
        }
    }
}
