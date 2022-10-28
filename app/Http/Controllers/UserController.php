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
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Repositories\User\UserRepositoryInterface;

/**
 * UserController class
 *
 * @copyright 2022 CriverCrane! Corporation. All Rights Reserved.
 * @author Huynh.Khanh <huynh.khanh.rcvn2012@gmail.com>
 */
class UserController extends Controller
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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
                return $this->userRepository->getAllUser($request);
            }
            return view('admin.pages.user.dashboard');
        } catch (\Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
        try {
            $requestAll = $request->all();
            $this->userRepository->store($requestAll);
            return $this->successResponse('', 'Thêm user thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi');
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
            return $this->successResponse('', 'Chỉnh sửa user thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi', 500);
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
            return $this->successResponse($data, 'Xoá người dùng thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi', 500);
        }
    }

    /**
     * Update status user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        try {
            $requestAll = $request->all();
            $data = $this->userRepository->status($requestAll);
            return $this->successResponse($data, 'Thay đổi trạng thái User thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi', 500);
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
            return $this->errorResponse('Đã xảy ra lỗi', 500);
        }
    }
}
