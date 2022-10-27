<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
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
            'product_name' => 'required|min:5',
            'product_price' => 'required|min:0|numeric',
            'is_sales' => 'in:0,1',
            'product_image' => 'sometimes|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=1024,max_height=1024',
        ];
    }

    public function messages()
    {
        return [

            "product_name.required" => "Vui lòng nhập tên sản phẩm",
            "product_name.min" => "Sản phẩm phải lớn hơn 5 ký tự",

            "product_price.required" => "Giá bán không được để trống",
            "product_price.numeric" => "Giá bán chỉ được nhập số",
            "product_price.min" => "Giá bán không được nhỏ hơn 0",

            "is_sales.in" => "Vui lòng chọn trạng thái khác mặc định",

            "product_image.mimes" => "Chỉ chấp nhận file png, jpg, jpeg",
            "product_image.max" => "Dung lượng ảnh không được vượt quá 2Mb",
            "product_image.dimensions" => "Ảnh quá lớn",

        ];
    }
}
