<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use App\Models\PasswordReset;
use Support;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    protected $redirectTo = RouteServiceProvider::HOME;
    public function __construct()
    {
        parent::__construct();
    }
    public function switchForgot($request, $route, $link)
    {
        if ($request->isMethod('post')) {
            return $this->sendResetLinkEmail($request);
        }
        else {
            $currentItem = $route;
            return view('auth.forgot_password', compact('currentItem'));
        }
    }
    
    public function sendResetLinkEmail(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return response()->json(['code'=>100,'message'=>$validator->errors()->first()]);
        }
        
        $token = PasswordReset::createToken($request->input('email'));
        session()->put('EMAIL_CURRENT_FORGOT', $request->input('email'));

        return response()->json([
            'code' => 200,
            'message' => 'Gửi yêu cầu lấy lại mật khẩu thành công. Hãy kiểm tra email của bạn và làm theo hướng dẫn.',
        ]);
    }

    protected function validator($request)
    {
        return Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users'],
        ],[
            'required' => 'Vui lòng nhập :attribute.',
            'email' => 'Vui lòng nhập :attribute đúng định dạng.',
            'exists' => ':attribute không tồn tại trong hệ thống.'
        ],[
            'email' => 'Email'
        ]);
    }
}