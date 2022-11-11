<?php
/**
 * Customer Repository
 *
 * PHP version 8
 *
 * @category  Repositorys
 * @package   App
 * @author    Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://localhost/
 */
namespace App\Repositories\Customer;

use Carbon\Carbon;
use App\Models\Customer;
use Yajra\DataTables\DataTables;

/**
 * CustomerRepository class
 *
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @author Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 */
class CustomerRepository implements CustomerRepositoryInterface
{
    protected $customer;
    protected $now;

    /**
     * Create a new controller instance.
     *
     * @param $customer
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
        $this->now = date_format(Carbon::now('Asia/Ho_Chi_Minh'), 'Y/m/d:H-i-s');
    }

    /**
     * Get all customer
     *
     * @param $request
     *
     * @return mixed
     */
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
                ->addColumn('action', function () {
                })
                ->make(true);
    }

     /**
     * Create customer
     *
     * @param $request
     *
     * @return mixed
     */
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

    /**
     * Update customer
     *
     * @param $request
     *
     * @return mixed
     */
    public function edit($request)
    {
        $dataUpdate = [];
        $data = $this->customer->where('customer_id', $request->customer_id)->first();

        if (isset($request->customer_name) && $request->customer_name != $data['customer_name']) {
            $dataUpdate['customer_name'] = $request->customer_name;
        }
        if (isset($request->email) && $request->email != $data['email']) {
            $dataUpdate['email'] = $request->email;
        }
        if (isset($request->address) && $request->address != $data['address']) {
            $dataUpdate['address'] = $request->address;
        }
        if (isset($request->tel_num) && $request->tel_num != $data['tel_num']) {
            $dataUpdate['tel_num'] = $request->tel_num;
        }

        if (!empty($dataUpdate)) {
            return $this->customer->where('customer_id', $request->customer_id)->update($dataUpdate);
        } else {
            return 0;
        }
    }
}
