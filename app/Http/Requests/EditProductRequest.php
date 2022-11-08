<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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

        ];
    }
}
