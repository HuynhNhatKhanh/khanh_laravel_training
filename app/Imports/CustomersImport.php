<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CustomersImport implements ToCollection, WithBatchInserts, WithChunkReading, WithStartRow, WithHeadingRow
{
    use Importable;

    public $dataInsert = [];
    public $errorsImport = [];

    public function collection(Collection $customerCollections)
    {
        $rules = [
            'ten_khach_hang' => 'required|min:5',
            'email' => 'required|max:255|email:rfc,dns|unique:customers,email',
            'telnum' => 'required|regex:/^([0-9]*)$/|min:7|max:13',
            'dia_chi' => 'required|max:255',
        ];
        $messages = [
            "ten_khach_hang.required" => "Vui lòng nhập tên khách hàng",
            "ten_khach_hang.min" => "Tên phải lớn hơn 5 ký tự",

            "email.required" => "Email không được để trống",
            "email.email" => "Email không đúng định dạng",
            "email.exists" => "Email không tồn tại",
            "email.unique" => "Email đã được đăng ký",
            "email.max" => "Email quá dài",

            "telnum.required" => "Điện thoại không được để trống",
            "telnum.regex" => "Điện thoại không đúng định dạng",
            "telnum.min" => "Điện thoại không đúng định dạng",
            "telnum.max" => "Điện thoại không đúng định dạng",

            "dia_chi.required" => "Địa chỉ không được để trống",
            "dia_chi.max" => "Địa chỉ quá dài",
        ];
        foreach ($customerCollections as $key => $customer) {
            $validator  = Validator::make($customer->toArray(), $rules, $messages);
            if ($validator->fails()) {
                $arrErrors = $validator->messages()->all();
                $this->errorsImport[$key] = implode(", ", $arrErrors);
                continue;
            }
            dd($this->errorsImport);
            $this->dataInsert[] = [
                'customer_name' => $customer['ten_khach_hang'],
                'email' =>  $customer['email'],
                'tel_num' =>  $customer['telnum'],
                'address' =>  $customer['dia_chi'],
            ];
        }
        Customer::insert($this->dataInsert);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function startRow(): int
    {
        return 2;
    }
}
