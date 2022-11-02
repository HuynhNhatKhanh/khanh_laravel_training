<?php
/**
 * Product Controller
 *
 * PHP version 8
 *
 * @category  Controllers
 * @package   App
 * @author    Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      http://localhost/
 */
namespace App\Http\Controllers;

use Datatables;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AddCustomerRequest;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * CustomerController class
 *
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @author Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 */
class CustomerController extends Controller
{
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->customerRepository->getAllCustomer($request);
            }
            return view('admin.pages.customer.dashboard');
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('MESSAGE_ERROR'), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCustomerRequest $request)
    {
        try {
            $this->customerRepository->store($request);
            return $this->successResponse('', __('MESSAGE_ADD_USER_SUCCESS'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('MESSAGE_ERROR'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id, EditUserRequest $request)
    {
        try {
            $requestAll = $request->all();
            $this->userRepository->edit($id, $requestAll);
            return $this->successResponse('', __('MESSAGE_UPDATE_USER_SUCCESS'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('MESSAGE_ERROR'), 500);
        }
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            $requestAll = $request->all();
            $data =  $this->userRepository->delete($requestAll);
            return $this->successResponse($data, __('MESSAGE_DELETE_USER_SUCCESS'));
        } catch (\Exception $e) {
            return $this->errorResponse(__('MESSAGE_ERROR'), 500);
        }
    }


     /**
     * Get data 1 user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUser(Request $request)
    {
        try {
            $requestAll = $request->all();
            return $this->userRepository->getUser($requestAll);
        } catch (\Exception $e) {
            return $this->errorResponse(__('MESSAGE_ERROR'), 500);
        }
    }

    public function export(Request $request)
    {
        try {
            return Excel::download(new CustomersExport($request), 'customers.xlsx');
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('MESSAGE_ERROR'), 500);
        }
    }

    public function import(Request $request)
    {
        // return  $request;
        try {
            Excel::import(new CustomersImport, $request->customersFile);
            return $this->successResponse('', __('MESSAGE_ADD_USER_SUCCESS'));
            //cần sửa lại mess
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            Log::error($e->failures());
            $failures = $e->failures();

            $errors = [];
            foreach ($failures as $failure) {
                $row = $failure->row(); // row that went wrong
                $attribute = $failure->attribute(); // either heading key (if using heading row concern) or column index
                $message = $failure->errors(); // Actual error messages from Laravel validator
                $errors[$row][$attribute] = $message[0];
            }

            return $this->errorResponse(__('MESSAGE_ERROR'), 500, $errors);
        }
    }
}
