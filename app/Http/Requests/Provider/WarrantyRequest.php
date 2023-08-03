<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

class WarrantyRequest extends FormRequest
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
            'invoice_id' => 'required|exists:invoices,id,deleted_at,NULL',
            'contract_value' => 'required_without:file|numeric',
            'contract_date' => 'required_without:file|date',
            'expiry_date' => 'required_without:file|date',
            'file' => 'required_without:contract_value|mimes:pdf|max:10000',
        ];
    }
}
