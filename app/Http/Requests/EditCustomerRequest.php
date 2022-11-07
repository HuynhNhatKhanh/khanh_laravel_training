<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCustomerRequest extends FormRequest
{
    /**
     * Determine if the customer is authorized to make this request.
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
            'dataEdit.customer_name' => 'required|min:5',
            'dataEdit.email' => 'required|max:255|email:rfc,dns|unique:customers,email,' .$this->customer_id. ',customer_id',
            'dataEdit.tel_num' => 'required|regex:/^([0-9]*)$/|min:7|max:13',
            'dataEdit.address' => 'required|max:255',
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

            "dataEdit.customer_name.required" => ['customer_name', "Vui lòng nhập tên khách hàng"],
            "dataEdit.customer_name.min"      => ['customer_name',"Tên phải lớn hơn 5 ký tự"],

            "dataEdit.email.required" => ['email', "Email không được để trống"],
            "dataEdit.email.email"    => ['email', "Email không đúng định dạng"],
            "dataEdit.email.exists"   => ['email', "Email không tồn tại"],
            "dataEdit.email.unique"   => ['email'," Email đã được đăng ký"],
            "dataEdit.email.max"      => ['email', "Email quá dài"],

            "dataEdit.tel_num.required" => ['tel_num', "Điện thoại không được để trống"],
            "dataEdit.tel_num.regex"    => ['tel_num', "Điện thoại không đúng định dạng"],
            "dataEdit.tel_num.min"      => ['tel_num', "Điện thoại không đúng định dạng"],
            "dataEdit.tel_num.max"      => ['tel_num', "Điện thoại không đúng định dạng"],

            "dataEdit.address.required" => ['address', "Địa chỉ không được để trống"],
            "dataEdit.address.max"      => ['address', "Địa chỉ quá dài"],

        ];
    }
}
