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
            'email'    => 'required|email|exists:users,email',
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

            "email.required" => "Email không được để trống",
            "email.email"    => "Email không đúng định dạng",
            "email.exists"   => "Email không tồn tại",

            "password.required" => "Mật khẩu không được để trống",
            "password.min"      => "Mật khẩu phải lớn hơn 6 ký tự",

        ];
    }
}
