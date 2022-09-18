<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Helpers\UserWallet\WalletHelper;
use App\Models\User;
use Support;
use VRoute;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->redirectTo = 'account';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function switchRegister($request, $route, $link)
    {
        if (Auth::check()) {
            return Support::sendResponse(200,'Bạn đang đăng nhập rồi',\VRoute::get("home"));
        }
        if ($request->isMethod('post')) {
            return $this->register($request);
        } else {
            Support::URLPrevious();
            $currentItem = $route;
            return view('auth.register', compact('currentItem'));
        }
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required'],
            'email' => ['required','email','unique:users'],
            'phone' => ['required','unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'min' => ':attribute tối thiểu :min kí tự',
            'unique' => ':attribute đã tồn tại trong hệ thống',
            'confirmed' => 'Mật khẩu và mật xác nhận lại phải giống nhau',
        ], [
            'name' => 'Họ và tên',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'password' => 'Mật khẩu',
        ]);
    }
    public function register($request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return Support::sendResponse(100,$validator->errors()->first(),\VRoute::get("register"));
        }
        $user = $this->createUser($request->all());
        WalletHelper::create($user);

        $code = \Str::random(6);
        session()->put('EMAIL_CURRENT_REGISTER', $user->email);
        event('sendmail.static', [[
            'title' => 'Tạo tài khoàn thành công và mã xác nhận kích hoạt tài khoản',
            'data' => [
                'link' => url('kich-hoat-tai-khoan') . "?token=$code&email=$user->email",
                'user' => $user,
            ],
            'email' => $user->email,
            'type' => 'user_create',
        ]]);

        return response()->json([
            'code' => 200,
            'token' => $code,
            'message' => 'Đăng ký tài khoản thành công. Vui lòng kiểm tra email để kích hoạt tài khoản ' . Support::show($user, 'name'),
            'redirect_url' => Support::URLPrevious(false),
        ]);
    }
    protected function createUser($data){
        $user = new User;
        $user->password = Hash::make($data['password']);
        $user->name = isset($data['name']) ? $data['name']:'';
        $user->email = isset($data['email']) ? $data['email']:'';
        $user->phone = isset($data['phone']) ? $data['phone']:'';
        $user->uslug = \Support::generateSlug('users', \Str::slug($user->name,'-'),'uslug');
        $user->last_login_time = now();
        $user->created_at = now();
        $user->updated_at = now();
        $user->save();
        return $user;
    }


    public function activeAccount(Request $request)
    {
        if (!$request->input('token', false) || !$request->input('email', false)) {
            return redirect()->to('/')->with('messageNotify', 'Yêu cầu không hợp lệ')->with('typeNotify', 100);
        }
        $user = User::where('email', $request->input('email'))->first();
        if ($user == null) {
            return redirect()->to('/')->with('messageNotify', 'Email không tồn tại')->with('typeNotify', 100);
        }
        if (!Hash::check($request->input('token'), $user->token)) {
            return redirect()->to('/')->with('messageNotify', 'Mã xác nhận không hợp lệ')->with('typeNotify', 100);
        }
        $user->act = 1;
        $user->save();
        return redirect()->to(\VRoute::get('login'))->with('messageNotify', 'Kích hoạt tài khoản thành công vui lòng đăng nhập')->with('typeNotify', 200);
    }

    public function checkToken(Request $request)
    {
        if ($request->input('phone', false)) {
            $user = User::where('phone', $request->input('phone'))->first();
            $user->act = 1;
            $user->save();
            return response([
                'code' => 200,
                'message' => 'Tài khoản của bạn đã được kích hoạt thành công, bạn có thể đăng nhập ngay!',
                'redirect_url' => \VRoute::get('login'),
            ]);
        }

        $email = session()->get('EMAIL_CURRENT_REGISTER');
        $user = User::where('email', $email)->first();
        if ($user == null) {
            return response([
                'code' => 100,
                'message' => 'Yêu cầu không hợp lệ vui lòng thử lại sau',
            ]);
        }

        session()->forget('EMAIL_CURRENT_REGISTER');
        if (Hash::check($request->otp, $user->token)) {
            $user->act = 1;
            $user->save();
            if ($request->input('social') == 1) {
                Auth::login($user);
                return response([
                    'code' => 200,
                    'message' => 'Kích hoạt tài khoản và đăng nhập thành công',
                    'redirect_url' => Support::URLPrevious(false),
                ]);
            }
            return response([
                'code' => 200,
                'message' => 'Tài khoản của bạn đã được xác nhận thành công, bạn có thể đăng nhập ngay!',
                'redirect_url' => \VRoute::get('login'),
            ]);
        }

        return response([
            'code' => 100,
            'message' => 'Token không hợp lệ!',
        ]);
    }

    public function sendTokenAgain()
    {
        $email = session()->get('EMAIL_CURRENT_REGISTER');
        if ($email == null) {
            return response([
                'code' => 100,
                'message' => 'Email không tồn tại trong hệ thống',
            ]);
        }
        $user = User::where('email', $email)->first();
        if ($user == null) {
            return response([
                'code' => 100,
                'message' => 'Email không hợp lệ vui lòng thử lại sau',
            ]);
        }
        $code = \Str::random(6);
        $user->token = Hash::make($code);
        $user->save();
        event('sendmail.static', [[
            'title' => 'Mã xác nhận kích hoạt tài khoản',
            'data' => [
                'link' => url('kich-hoat-tai-khoan') . "?token=$code&email=$user->email",
                'user' => $user,
            ],
            'email' => $user->email,
            'type' => 'user_create',
        ]]);

        return response([
            'code' => 200,
            'token' => $code,
            'message' => "Gửi yêu cầu nhận lại mã xác nhận tài khoản thành công. Hãy kiểm tra email $email",
        ]);
    }

}
