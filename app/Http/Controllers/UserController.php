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
use Illuminate\Http\Response;
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
    /**
     * Create a new controller instance.
     *
     * @param $userRepository
     *
     * @return void
     */
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
    public function store(AddUserRequest $request)
    {
        try {
            $requestAll = $request->all();
            $this->userRepository->store($requestAll);
            return $this->successResponse('', __('message.MESSAGE_ADD_USER_SUCCESS'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('message.MESSAGE_ERROR'));
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
            return $this->successResponse('', __('message.MESSAGE_UPDATE_USER_SUCCESS'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('message.MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return $this->successResponse($data, __('message.MESSAGE_DELETE_USER_SUCCESS'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('message.MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return $this->successResponse($data, __('message.message.MESSAGE_CHANGE_STATUS_USER_SUCCESS'));
        } catch (\Exception $e) {
            Log::error($e);
            return $this->errorResponse(__('message.MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return $this->errorResponse(__('message.MESSAGE_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
