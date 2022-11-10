<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'    => 'required|regex:/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/|exists:users,email',
            'password' => 'required|min:6'
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

            "email.required"    => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Email']),
            "email.regex"       => __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Email']),
            "email.exists"      => __('message.MESSAGE_VALIDATE_EXISTS', ['attribute' => 'Email']),

            "password.required" => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Mật khẩu']),
            "password.min"      => __('message.MESSAGE_VALIDATE_MIN6_CHAR', ['attribute' => 'Mật khẩu']),

        ];
    }
}
