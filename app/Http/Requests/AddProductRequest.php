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
            'product_name'  => 'required|min:5',
            'product_price' => 'required|min:0|numeric',
            'is_sales'      => 'in:0,1',
            'product_image' => 'image|sometimes|mimes:jpeg,jpg,png|max:2048|dimensions:max_width=1024,max_height=1024',
        ];
    }

    public function messages()
    {
        return [

            "product_name.required"    => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Tên']),
            "product_name.min"         => __('message.MESSAGE_VALIDATE_MIN5_CHAR', ['attribute' => 'Tên']),

            "product_price.required"   => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Giá']),
            "product_price.numeric"    => __('message.MESSAGE_VALIDATE_NUMBER', ['attribute' => 'Giá']),
            "product_price.min"        => __('message.MESSAGE_VALIDATE_MIN0_NUM', ['attribute' => 'Giá']),

            "is_sales.in"              => __('message.MESSAGE_VALIDATE_SELECT_STATUS_DIFFERENT_DEFAULT', ['attribute' => 'Trạng thái']),

            "product_image.image"      => __('message.MESSAGE_VALIDATE_IMAGE', ['attribute' => 'Ảnh']),
            "product_image.mimes"      => __('message.MESSAGE_VALIDATE_IMAGE_MIMES', ['attribute' => 'Ảnh']),
            "product_image.max"        => __('message.MESSAGE_VALIDATE_IMAGE_MAX_SIZE_2MB', ['attribute' => 'Ảnh']),
            "product_image.dimensions" => __('message.MESSAGE_VALIDATE_IMAGE_MAX_LENGTH', ['attribute' => 'Ảnh']),

        ];
    }
}
