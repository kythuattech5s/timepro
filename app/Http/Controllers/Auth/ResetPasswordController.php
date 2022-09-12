<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Support;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;
    protected $redirectTo = RouteServiceProvider::HOME;
    public function switchReset($request, $route, $link)
    {
        if ($request->isMethod('post')) {
            return $this->reset($request);
        }
        else{
            $password_reset = \DB::table('password_resets')->where('email', $request->email)->first();
            if ($password_reset == null) {
                return Support::sendResponse(100,'Yêu cầu không hợp lệ',\VRoute::get("home"));
            }
            if(\Hash::check($request->token,$password_reset->token)){
                $currentItem = $route;
                return view('auth.reset_password')->with(
                    ['token' => $request->token, 'email' => $request->email, 'currentItem' => $currentItem]
                );
            }else{
                return Support::sendResponse(100,'Yêu cầu không hợp lệ',\VRoute::get("home"));
            }
        }
    }
    protected function validator($request)
    {
        return \Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'required' => 'Vui lòng chọn hoặc nhập :attribute',
            'min' => ':attribute tối thiểu :min kí tự',
            'confirmed' => 'Mật khẩu và mật xác nhận lại phải giống nhau'
        ], [
            'password' => 'Mật khẩu',
        ]);
    }
    public function reset(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return Support::sendResponse(100,$validator->errors()->first(),\VRoute::get("reset-password"));
        }
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        if ($response == Password::PASSWORD_RESET) {
            return Support::sendResponse(200,'Thay đổi mật khẩu thành công',\VRoute::get("home"));
        }
        else{
            if ($response == 'passwords.token') {
                return Support::sendResponse(100,'Token không hợp lệ',\VRoute::get("reset-password"));
            }
            return Support::sendResponse(102,'Thay đổi mật khẩu không thành công');
        }
    }
}
