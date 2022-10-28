<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\User\UserRepositoryInterface;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request)
    {
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                $this->userRepository->login($request);
                return $this->successResponse('', __('MESSAGE_CHECK_LOGIN_SUCCESS'));
            } else {
                return $this->errorResponse(__('MESSAGE_CHECK_LOGIN_ERROR'));
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi', 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
