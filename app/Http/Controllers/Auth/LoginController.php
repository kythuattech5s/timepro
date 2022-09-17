<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;
use VRoute;
use Support;

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


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }
    public function switchLogin($request, $route, $link)
    {
        if (Auth::check()) {
            return Support::sendResponse(200,'Bạn đang đăng nhập rồi',\VRoute::get("home"));
        }
        if ($request->isMethod('post')) {
            return $this->login($request);
        } else {
            Support::URLPrevious();
            $currentItem = $route;
            return view('auth.login',compact('currentItem'));
        }
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required'],
            'password' => ['required'],
        ], [
            'required' => 'Vui lòng nhập :attribute',
        ], [
            'username' => 'Email hoặc số điện thoại',
            'password' => 'Vui lòng nhập mật khẩu',
        ]);
    }
    public function login($request)
    {   
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return Support::sendResponse(100,$validator->errors()->first(),\VRoute::get("login"));
        }
        $username = $request->username;
        $usernameField = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email':'phone';
        list($user,$infoCheck) = $this->checkInfoUser($usernameField,$username);
        if($infoCheck['code'] != 200){
            return Support::sendResponse(100,$infoCheck['message'],\VRoute::get("login"));
        }
        $credentials = [$usernameField => $username, 'password'=>$request->password];
        if (Auth::attempt($credentials, $request->input('remember'))) {
            return $this->authenticated($request,$user);
        }
        else{
            return Support::sendResponse(100,'Tài khoản hoặc mật khẩu đăng nhập không chính xác',\VRoute::get("login"));
        }
    }
    protected function checkInfoUser($usernameField,$username)
    {
        $user = User::where($usernameField,$username)->first();
        if (!isset($user)) {
            $infoCheck = [
                'code' => 100,
                'message' => 'Tài khoản hoặc mật khẩu đăng nhập không chính xác'
            ];
        }
        else if ($user->act == 0) {
            $infoCheck = [
                'code' => 100,
                'message' => 'Tài khoản chưa được kích hoạt. Vui lòng kích hoạt tài khoản'
            ];
        }
        else if ($user->banned == 1) {
            $infoCheck = [
                'code' => 100,
                'message' => 'Tài khoản đã bị cấm'
            ];
        }
        else{
            $infoCheck = [
                'code' => 200,
                'message' => ''
            ];
        }
        return [$user,$infoCheck];
    }
    protected function authenticated($request,$user)
    {
        $user->last_login_time = now();
        $user->save();
        \Tech5sCart::identifier($user->id);
        \Tech5sCart::restore($user->id);
        $url = Support::URLPrevious(false);
        return Support::sendResponse(200,'Đăng nhập thành công',$url);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect(VRoute::get("home"));
    }
}