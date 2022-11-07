<?php

namespace App\Repositories\Customer;

use Carbon\Carbon;
use App\Models\Customer;
use Yajra\DataTables\DataTables;

class CustomerRepository implements CustomerRepositoryInterface
{
    protected $customer;
    protected $now;
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->now = date_format(Carbon::now('Asia/Ho_Chi_Minh'), 'Y/m/d:H-i-s');
    }

    public function getAllCustomer($request)
    {
        $query = $this->customer;

        if ($request->load == 'index') {
            $query = $query->orderBy('customer_id', 'desc')->get();
            $results = $query;
        }
        if ($request->load == 'search') {
            if (isset($request->name)) {
                $query = $query->where("customer_name", "LIKE", '%' . $request->name . '%');
            }
            if (isset($request->email)) {
                $query = $query->where("email", "LIKE", '%' . $request->email . '%');
            }
            if (isset($request->address)) {
                $query = $query->where("address", "LIKE", '%' . $request->address . '%');
            }
            if (isset($request->status) && $request->status != 'default') {
                $query = $query->where("is_active", '=', $request->status);
            }
            $query = $query->orderBy('customer_id', 'desc')->get();
            $results = $query;
        }

        return Datatables::of($results)
                ->addIndexColumn()
                // ->addColumn(
                //     'action',
                //     function ($results) {
                //         $xhtml = '<td class="text-center ">';
                //         $xhtml .= '<button type="button" value="'. $results->customer_id .'" class="rounded-circle btn btn-sm btn-info m-1 editbtn-user " title="Chỉnh sửa" data-id="'. $results->customer_id .'"><i class="fas fa-pencil-alt"></i></button> </td>';
                //         return $xhtml;
                //     }
                // )
                // ->editColumn(
                //     'is_active',
                //     function ($results) {
                //         $results->is_active === 1 ? $status = 'Đang hoạt động' : $status = 'Tạm khóa';
                //         return $status;
                //     }
                // )
                // ->rawColumns(['action'])
                ->make(true);
    }

    public function store($request)
    {
        $dataCreate = [
            'customer_name' => $request->customer_name,
            'email' => $request->email,
            'tel_num' => $request->tel_num,
            'address' => $request->address,
            'is_active' => $request->is_active,
        ];
        return $this->customer->create($dataCreate);
    }

    public function edit($request)
    {
        $dataUpdate = [];
        $data = $this->customer->where('customer_id', $request->customer_id)->first();

        if (isset($request->dataEdit['customer_name']) && $request->dataEdit['customer_name'] != $data['customer_name']) {
            $dataUpdate['customer_name'] = $request->dataEdit['customer_name'];
        }
        if (isset($request->dataEdit['email']) && $request->dataEdit['email'] != $data['email']) {
            $dataUpdate['email'] = $request->dataEdit['email'];
        }
        if (isset($request->dataEdit['address']) && $request->dataEdit['address'] != $data['address']) {
            $dataUpdate['address'] = $request->dataEdit['address'];
        }
        if (isset($request->dataEdit['tel_num']) && $request->dataEdit['tel_num'] != $data['tel_num']) {
            $dataUpdate['tel_num'] = $request->dataEdit['tel_num'];
        }

        if (!empty($dataUpdate)) {
            return $this->customer->where('customer_id', $request->customer_id)->update($dataUpdate);
        } else {
            return 0;
        }
    }
}
