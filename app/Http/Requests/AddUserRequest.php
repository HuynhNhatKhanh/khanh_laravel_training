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
            'name' => 'required|min:5',
            'email' => 'required|max:255|email:rfc,dns|unique:users',
            'password' => 'required|min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirm' => 'required|min:5|same:password',
            'group_role' => 'required|in:admin,reviewer,editor',
            'is_active' => 'required|in:"1","0"',
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

            "name.required" => "Vui lòng nhập tên người sử dụng",
            "name.min" => "Tên phải lớn hơn 5 ký tự",

            "group_role.required" => "Vui lòng chọn nhóm",
            "group_role.in" => "Vui lòng chọn nhóm khác mặc định",

            "is_active.required" => "Vui lòng chọn trạng thái",
            "is_active.in" => "Vui lòng chọn trạng thái khác mặc định",

            "email.required" => "Email không được để trống",
            "email.email" => "Email không đúng định dạng",
            "email.exists" => "Email không tồn tại",
            "email.unique" => "Email đã được đăng ký",
            "email.max" => "Email quá dài",

            "password.required" => "Mật khẩu không được để trống",
            "password.min" => "Mật khẩu phải lớn hơn 5 ký tự",
            "password.regex" => "Phải bao gồm chữ thường, in hoa, số và kí tự đặc biệt",

            "password_confirm.required" => "Xác nhận mật khẩu",
            "password_confirm.min" => "Mật khẩu phải lớn hơn 5 ký tự",
            "password_confirm.same" => "Xác nhận mật khẩu không trùng khớp",

        ];
    }
}
