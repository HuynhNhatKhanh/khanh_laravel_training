<?php
/**
 * Customer Controller
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

use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\AddCustomerRequest;
use App\Repositories\Customer\CustomerRepositoryInterface;

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
            return $this->errorResponse(__('MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
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
            Log::error($e);
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
    public function edit(Request $request)
    {
        $id = implode('', $request->customer_id);
        $rules = [
            'customer_name' => 'required|min:5',
            'email' => 'required|max:255|email:rfc,dns|unique:customers,email,' .$id. ',customer_id',
            'tel_num' => 'required|regex:/^([0-9]*)$/|min:7|max:13',
            'address' => 'required|max:255',
        ];
        $messages = [
            "customer_name.required" => "Vui lòng nhập tên khách hàng",
            "customer_name.min" => "Tên phải lớn hơn 5 ký tự",

            "email.required" => "Email không được để trống",
            "email.email" => "Email không đúng định dạng",
            "email.exists" => "Email không tồn tại",
            "email.unique" => "Email đã được đăng ký",
            "email.max" => "Email quá dài",

            "tel_num.required" => "Điện thoại không được để trống",
            "tel_num.regex" => "Điện thoại không đúng định dạng",
            "tel_num.min" => "Điện thoại không đúng định dạng",
            "tel_num.max" => "Điện thoại không đúng định dạng",

            "address.required" => "Địa chỉ không được để trống",
            "address.max" => "Địa chỉ quá dài",
        ];
        $validator  = Validator::make($request->data[$id], $rules, $messages)->validate();

        try {
            $this->customerRepository->edit($id, $request);
            return $this->successResponse('', __('MESSAGE_UPDATE_USER_SUCCESS'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
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
            Log::error($e);
            return $this->errorResponse(__('MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
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
            Log::error($e);
            return $this->errorResponse(__('MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function export(Request $request)
    {
        try {
            return Excel::download(new CustomersExport($request), 'customers.xlsx');
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function import(Request $request)
    {
        $validator = Validator::make(
            [
                'file'      => $request->customersFile,
                'extension' => strtolower($request->customersFile->getClientOriginalExtension()),
            ],
            [
                'file'          => 'required',
                'extension'      => 'required|in:csv,xlsx,xls',
            ],
            [
                "file.required" => "Chưa chọn file",

                "extension.required" => "Lỗi extention",
                "extension.in" => "File phải thuộc csv,xlsx,xls",

            ]
        )->validate();
        try {
            $import = new CustomersImport;
            dd($request->customersFile->getClientOriginalExtension());
            Excel::import($import, $request->customersFile);
            return $this->successResponse(['errors' => $import->getErrorsInsert(), 'rowsInsert' => $import->getDataInsert()], ('MESSAGE_ADD_CUSTOMER_SUCCESS'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
