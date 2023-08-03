<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (isset($this->ar['text'])) {
            $this->merge([
                'text_ar' => $this->ar['text'],
            ]);
        }
        if (isset($this->en['text'])) {
            $this->merge([
                'text_en' => $this->en['text'],
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text_ar' => 'nullable|string|max:1000',
            'text_en' => 'nullable|string|max:1000',
            'image' => 'required|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
