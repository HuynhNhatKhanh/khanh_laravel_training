<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCustomerRequest extends FormRequest
{
    /**
     * Determine if the customer is authorized to make this request.
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
        return [
            'dataEdit.customer_name' => 'required|min:5',
            'dataEdit.email' => 'required|max:255|email:rfc,dns|unique:customers,email,' .$this->customer_id. ',customer_id',
            'dataEdit.tel_num' => 'required|regex:/^([0-9]*)$/|min:7|max:13',
            'dataEdit.address' => 'required|max:255',
        ];
    }

     /**
     * Return validation error message
     *
     * @return array
     */
    public function messages()
    {
        return [

            "dataEdit.customer_name.required" => ['customer_name',  __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Tên'])],
            "dataEdit.customer_name.min"      => ['customer_name', __('message.MESSAGE_VALIDATE_MIN5_CHAR', ['attribute' => 'Tên'])],

            "dataEdit.email.required"         => ['email', __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Email'])],
            "dataEdit.email.email"            => ['email', __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Email'])],
            "dataEdit.email.exists"           => ['email', __('message.MESSAGE_VALIDATE_EXISTS', ['attribute' => 'Email'])],
            "dataEdit.email.unique"           => ['email', __('message.MESSAGE_VALIDATE_UNIQUE', ['attribute' => 'Email'])],
            "dataEdit.email.max"              => ['email', __('message.MESSAGE_VALIDATE_MAX_STRING', ['attribute' => 'Email'])],

            "dataEdit.tel_num.required"       => ['tel_num', __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Điện thoại'])],
            "dataEdit.tel_num.regex"          => ['tel_num', __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Điện thoại'])],
            "dataEdit.tel_num.min"            => ['tel_num', __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Điện thoại'])],
            "dataEdit.tel_num.max"            => ['tel_num', __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Điện thoại'])],

            "dataEdit.address.required"       => ['address', __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Địa chỉ'])],
            "dataEdit.address.max"            => ['address', __('message.MESSAGE_VALIDATE_MAX_STRING', ['attribute' => 'Địa chỉ'])],

        ];
    }
}
