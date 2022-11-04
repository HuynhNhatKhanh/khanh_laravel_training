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

    public function edit($id, $request)
    {
        $dataUpdate = [];
        if (isset($request->data)) {
            if (isset($request->data[$id]['customer_name'])) {
                $dataUpdate['customer_name'] = $request->data[$id]['customer_name'];
            }
            if (isset($request->data[$id]['email'])) {
                $dataUpdate['email'] = $request->data[$id]['email'];
            }
            if (isset($request->data[$id]['address'])) {
                $dataUpdate['address'] = $request->data[$id]['address'];
            }
            if (isset($request->data[$id]['tel_num'])) {
                $dataUpdate['tel_num'] = $request->data[$id]['tel_num'];
            }
            return $this->customer->where('customer_id', $id)->update($dataUpdate);
        }
    }

    // public function delete($requestAll)
    // {
    //     $requestAll['delete'] = ($requestAll['delete'] == 1) ? 0 : 1;
    //     return $this->user->where('id', $requestAll['id'])->update(['is_delete' => $requestAll['delete']]);
    // }

    // public function getCustomer($requestAll)
    // {
    //     return $this->user->where('id', $requestAll['id'])->first();
    // }
}
