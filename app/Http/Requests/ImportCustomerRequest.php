<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportCustomerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // dd();
        return [
            'customersFile' => 'required|mimes:csv,xlsx,xls',
        ];
    }

    public function messages()
    {
        return [

            "customersFile.required" => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'File']),
            "customersFile.mimes"    => __('message.MESSAGE_VALIDATE_EXCEL_MIMES', ['attribute' => 'Ảnh']),

        ];
    }
}
