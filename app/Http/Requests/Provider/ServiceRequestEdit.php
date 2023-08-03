<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestEdit extends FormRequest
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
        $this->merge([
            'name_ar' => $this->ar['name'],
            'name_en' => $this->en['name'],
            'text_ar' => $this->ar['text'],
            'text_en' => $this->en['text'],
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:services,id,deleted_at,NULL',
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'text_ar' => 'required|string|max:1000',
            'text_en' => 'required|string|max:1000',
            'payment_method_id' => 'required|exists:payment_methods,id,deleted_at,NULL',
            'category_id' => 'required|exists:categories,id,deleted_at,NULL',
            'price' => 'required|numeric',
            'has_detail' => 'required',
            'images' => 'required|array',
            'images.*' => 'required|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
