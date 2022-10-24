<?php

namespace App\Http\Controllers\Auth;

use session;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddUserRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $now;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('guest')->except('logout');
        $this->now = date_format(Carbon::now('Asia/Ho_Chi_Minh'), 'Y/m/d:H-i-s');
    }

    public function login(LoginRequest $request)
    {
        // Attempt to log
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $request->session()->put('userInfo', $request->input());
            $this->user->where('email', $request->email)
                        ->update([
                            'last_login_at' => $this->now,
                            'last_login_ip' => $request->ip(),
                        ]);
            return $this->successResponse('', $message = 'Kiểm tra đăng nhập chính xác');
            // return redirect()->intended(route('user'));
        } else {
            return $this->errorResponse($message = 'Mật khẩu không chính xác');
        }
        // return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['password' => 'Mật khẩu không chính xác.']);
    }

    public function logout(Request $request)
    {
        session()->forget('userInfo');
        Auth::logout();
        return redirect()->route('login');
    }
}
