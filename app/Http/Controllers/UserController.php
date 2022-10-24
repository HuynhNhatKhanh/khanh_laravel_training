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
        $requestAll = $request->all();
        $items = $this->userRepository->getAllUser($requestAll);
        // $pagination = view('admin.pages.user.elements.pagination', ['items' => $items])->render();
        // // if ($request->ajax()) {
        //     return response()->json(
        //         [
        //             'users' => $items,
        //             'pagination' => $pagination
        //         ]
        //     );
        // // };
        // return view('admin.pages.user.dashboard');
        if ($request->ajax()) {
            return response()->json(['status' => 200, 'users' => $items]);
        }
        return view('admin.pages.user.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            return $this->successResponse('', $message = 'Thêm user thành công');
        } catch (\Exception $e) {
            return $this->errorResponse($message = 'Lỗi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id use for query
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        try {
            $requestAll = $request->all();
            $this->userRepository->edit($id, $requestAll);
            return $this->successResponse('', $message = 'Chỉnh sửa user thành công');
        } catch (\Exception $e) {
            Log::info($e);
            return $this->errorResponse($message = 'Lỗi');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Delte the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $requestAll = $request->all();
        $this->userRepository->delete($requestAll);
    }

    /**
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $requestAll = $request->all();
        $this->userRepository->status($requestAll);
    }

    /**
     *
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $requestAll = $request->all();
        return $this->userRepository->search($requestAll);
    }

    public function getUser(Request $request)
    {
        $requestAll = $request->all();
        // return $requestAll;
        return $this->userRepository->getUser($requestAll);
    }
}
