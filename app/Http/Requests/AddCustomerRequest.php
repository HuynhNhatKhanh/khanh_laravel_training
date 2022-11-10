<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCustomerRequest extends FormRequest
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
        return [
            'customer_name' => 'required|min:5',
            'email'         => 'required|max:255|regex:/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/|unique:customers',
            'tel_num'       => 'required|regex:/^([0-9]*)$/|min:7|max:13',
            'address'       => 'required|max:255',
            'is_active'     => 'required|in:"1","0"',
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

            "customer_name.required" => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Tên']),
            "customer_name.min"      => __('message.MESSAGE_VALIDATE_MIN5_CHAR', ['attribute' => 'Tên']),

            "email.required"         => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Email']),
            "email.regex"            => __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Email']),
            "email.exists"           => __('message.MESSAGE_VALIDATE_EXISTS', ['attribute' => 'Email']),
            "email.unique"           => __('message.MESSAGE_VALIDATE_UNIQUE', ['attribute' => 'Email']),
            "email.max"              => __('message.MESSAGE_VALIDATE_MAX_STRING', ['attribute' => 'Email']),

            "tel_num.required"       => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Điện thoại']),
            "tel_num.regex"          => __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Điện thoại']),
            "tel_num.min"            => __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Điện thoại']),
            "tel_num.max"            => __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Điện thoại']),

            "address.required"       => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Địa chỉ']),
            "address.max"            => __('message.MESSAGE_VALIDATE_MAX_STRING', ['attribute' => 'Địa chỉ']),

            "is_active.required"     => __('message.MESSAGE_VALIDATE_SELECT_STATUS', ['attribute' => 'Trạng thái']),
            "is_active.in"           => __('message.MESSAGE_VALIDATE_SELECT_STATUS_DIFFERENT_DEFAULT', ['attribute' => 'Trạng thái']),

        ];
    }
}
