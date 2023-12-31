<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'id' => 'required|exists:categories,id,deleted_at,NULL',
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
            'regions' => 'nullable|array',
            'regions.*' => 'nullable|exists:regions,id,deleted_at,NULL',
        ];
    }
}
