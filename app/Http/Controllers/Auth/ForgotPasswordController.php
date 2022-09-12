<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
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
        } else {
            $currentItem = $route;
            return view('auth.forgot_password', compact('currentItem'));
        }
    }
    protected function validator($request)
    {
        return Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users'],
        ], [
            'required' => 'Vui lòng nhập :attribute.',
            'email' => 'Vui lòng nhập :attribute đúng định dạng.',
            'exists' => ':attribute không tồn tại trong hệ thống.'
        ],[
            'email' => 'Email'
        ]);
    }
    public function sendResetLinkEmail(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return Support::sendResponse(100,$validator->errors()->first(),\VRoute::get("forgot-password"));
        }
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
        if ($response == Password::RESET_LINK_SENT) {
            return Support::sendResponse(200,'Gửi yêu cầu lấy lại mật khẩu thành công. Hãy kiểm tra email của bạn và làm theo hướng dẫn.',\VRoute::get("sendForgetPasswordSuccess"));
        } else {
            return Support::sendResponse(100,'Không thể gửi Email vui lòng thử lại sau');
        }
    }
}