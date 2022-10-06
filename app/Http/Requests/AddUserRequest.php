<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'username' => 'required|min:5',
            'password' => 'required|min:5',
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

            "username.required" => "Vui lòng nhập tên khách hàng",
            "customer_name.min" => "Tên phải lớn hơn 5 ký tự",

            "password.required" => "Vui lòng nhập mật khẩu",

            "email.required" => "Email không được để trống",
            "email.email" => "Email không đúng định dạng",
            "email.exists" => "Email không tồn tại",
            "email.unique" => "Email đã được đăng ký",
            "email.max" => "Email quá dài",

            "tel_num.required" => "Điện thoại không được để trống",
            "tel_num.regex" => "Điện thoại không đúng định dạng",
            "tel_num.min" => "Điện thoại không đúng định dạng",
            "tel_num.max" => "Điện thoại không đúng định dạng",

            "address.required" => "Địa chỉ không được để trống",
            "address.max" => "Địa chỉ quá dài",

        ];
    }
}
