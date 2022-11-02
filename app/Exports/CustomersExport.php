<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    protected $request;
    protected $customer;
    public function __construct($request)
    {
        $this->request = $request;
        $this->customer = new Customer();
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = $this->customer;
        if ($this->request->load == 'index') {
            $query = $query->orderBy('customer_id', 'desc');
            $query = $query->take($this->request->numRows)->get();
            $results = $query;
        }
        if ($this->request->load == 'search') {
            if (isset($this->request->name)) {
                $query = $query->where("customer_name", "LIKE", '%' . $this->request->name . '%');
            }
            if (isset($this->request->email)) {
                $query = $query->where("email", "LIKE", '%' . $this->request->email . '%');
            }
            if (isset($this->request->address)) {
                $query = $query->where("address", "LIKE", '%' . $this->request->address . '%');
            }
            if (isset($this->request->status) && $this->request->status != 'default') {
                $query = $query->where("is_active", '=', $this->request->status);
            }
            $query = $query->orderBy('customer_id', 'desc')->get();
            $results = $query;
        }
        return $results;
    }

    public function headings(): array
    {
        return [
            'Tên khách hàng',
            'Email',
            'TelNum',
            "Địa chỉ",
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->customer_name,
            $customer->email,
            $customer->tel_num,
            $customer->address,
        ];
    }
}
