<?php

namespace App\Imports;

use DB;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
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
    private $dataInsert = [];
    private $errorsInsert = [];
    public $transactions = null;

    public function collection(Collection $customerCollections)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'ten_khach_hang' => 'required|min:5',
                'email'          => 'required|max:255|email:rfc,dns|unique:customers,email',
                'telnum'         => 'required|regex:/^([0-9]*)$/|min:7|max:13',
                'dia_chi'        => 'required|max:255',
            ];
            $messages = [
                "ten_khach_hang.required" => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Tên']),
                "ten_khach_hang.min"      => __('message.MESSAGE_VALIDATE_MIN5', ['attribute' => 'Tên']),

                "email.required"          => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Email']),
                "email.email"             => __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Email']),
                "email.exists"            => __('message.MESSAGE_VALIDATE_EXISTS', ['attribute' => 'Email']),
                "email.unique"            => __('message.MESSAGE_VALIDATE_UNIQUE', ['attribute' => 'Email']),
                "email.max"               => __('message.MESSAGE_VALIDATE_MAX_STRING', ['attribute' => 'Email']),

                "tel_num.required"        => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Điện thoại']),
                "tel_num.regex"           => __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Điện thoại']),
                "tel_num.min"             => __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Điện thoại']),
                "tel_num.max"             => __('message.MESSAGE_VALIDATE_FORMAT', ['attribute' => 'Điện thoại']),

                "dia_chi.required"        => __('message.MESSAGE_VALIDATE_REQUIRED', ['attribute' => 'Địa chỉ']),
                "dia_chi.max"             => __('message.MESSAGE_VALIDATE_MAX_STRING', ['attribute' => 'Địa chỉ']),
            ];
            foreach ($customerCollections as $key => $customer) {
                $validator  = Validator::make($customer->toArray(), $rules, $messages);
                if ($validator->fails()) {
                    $arrErrors = $validator->messages()->all();
                    $this->errorsInsert[$key] = implode(", ", $arrErrors);
                    continue;
                }
                $this->dataInsert[] = [
                    'customer_name' => $customer['ten_khach_hang'],
                    'email' =>  $customer['email'],
                    'tel_num' =>  $customer['telnum'],
                    'address' =>  $customer['dia_chi'],
                ];
            }

            DB::table('customers')->insert($this->dataInsert);
            DB::commit();
            $this->transactions = true;
        } catch (Exception $e) {
            DB::rollBack();
            $this->transactions = false;
            return $e;
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function getDataInsert()
    {
        return $this->dataInsert;
    }

    public function getErrorsInsert()
    {
        return $this->errorsInsert;
    }

    public function getTransections()
    {
        return $this->transactions;
    }
}
