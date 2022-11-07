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
use App\Http\Requests\EditCustomerRequest;
use App\Repositories\Customer\CustomerRepositoryInterface;

/**
 * CustomerController class
 *
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @author Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 */
class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param $customerRepository
     *
     * @return void
     */
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
            return $this->errorResponse(__('message.MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return $this->successResponse('', __('message.MESSAGE_ADD_CUSTOMER_SUCCESS'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('message.MESSAGE_ERROR'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(EditCustomerRequest $request)
    {
        try {
            $data = $this->customerRepository->edit($request);
            return $this->successResponse($data, __('message.MESSAGE_UPDATE_CUSTOMER_SUCCESS'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('message.MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Export data customer.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        try {
            return Excel::download(new CustomersExport($request), 'customers.xlsx');
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('message.MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * Import data customer.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            return $this->errorResponse(__('message.MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
