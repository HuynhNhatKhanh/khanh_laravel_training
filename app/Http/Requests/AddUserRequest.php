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
            'name'             => 'required|min:5',
            'email'            => 'required|max:255|regex:/^(([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+([;.](([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5}){1,25})+)*$/|unique:users',
            'password'         => 'required|min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirm' => 'required|min:5|same:password',
            'group_role'       => 'required|in:admin,reviewer,editor',
            'is_active'        => 'required|in:"1","0"',
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

            "name.required"             => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Tên']),
            "name.min"                  => __('message.MESSAGE_VALIDATE_MIN5_CHAR', ['attribute' => 'Tên']),

            "group_role.required"       => __('message.MESSAGE_VALIDATE_SELECT_STATUS', ['attribute' => 'Nhóm']),
            "group_role.in"             => __('message.MESSAGE_VALIDATE_SELECT_STATUS_DIFFERENT_DEFAULT', ['attribute' => 'Nhóm']),

            "is_active.required"        => __('message.MESSAGE_VALIDATE_SELECT_STATUS', ['attribute' => 'Trạng thái']),
            "is_active.in"              => __('message.MESSAGE_VALIDATE_SELECT_STATUS_DIFFERENT_DEFAULT', ['attribute' => 'Trạng thái']),

            "email.required"            => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Email']),
            "email.regex"               => __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Email']),
            "email.exists"              => __('message.MESSAGE_VALIDATE_EXISTS', ['attribute' => 'Email']),
            "email.unique"              => __('message.MESSAGE_VALIDATE_UNIQUE', ['attribute' => 'Email']),
            "email.max"                 => __('message.MESSAGE_VALIDATE_MAX_STRING', ['attribute' => 'Email']),

            "password.required"         => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Mật khẩu']),
            "password.min"              => __('message.MESSAGE_VALIDATE_MIN6_CHAR', ['attribute' => 'Mật khẩu']),
            "password.regex"            => __('message.MESSAGE_VALIDATE_FORMAT_PASSWORD', ['attribute' => 'Mật khẩu']),

            "password_confirm.required" => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Xác nhận mật khẩu']),
            "password_confirm.min"      => __('message.MESSAGE_VALIDATE_MIN6_CHAR', ['attribute' => 'Xác nhận mật khẩu']),
            "password_confirm.same"     => __('message.MESSAGE_VALIDATE_SAME', ['attribute' => 'Xác nhận mật khẩu']),

        ];
    }
}
