<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'product_name_detail' => 'required|min:5',
            'product_price_detail' => 'required',
        ];
    }

    public function messages()
    {
        return [

            "product_name_detail.required" => "Vui lòng nhập tên sản phẩm",
            "product_name_detail.min" => "Tên sản phẩm phải nhiều hơn 5 ký tự",

            "product_price_detail.required" => "Vui lòng nhập giá sản phẩm",
            //"passworproduct_price_detail.min" => "Tên sản phẩm phải nhiều hơn 5 ký tự",

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
