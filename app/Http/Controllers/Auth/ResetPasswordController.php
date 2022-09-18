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
        else {
            $password_reset = \DB::table('password_resets')->where('email', $request->email)->first();
            if ($password_reset == null && $request->ajax()) {
                return response([
                    'code' => 100,
                    'message' => trans("fdb::data_not_exists"),
                ]);
            }
            if ($password_reset == null) {
                return redirect()->to(Support::URLPrevious(false))->with('messageNotify', 'Yêu cầu không còn tồn tại!')->with('typeNotify', 100);
            }
            if (\Hash::check($request->token, $password_reset->token)) {
                return view('auth.reset_password')->with(
                    ['token' => $request->token, 'email' => $request->email, 'route' => $route]
                );
            }
            else {
                return redirect(url('/'))->with('typeNotify', 100)->with('messageNotify', 'Token không hợp lệ');
            }
        }
    }

    public function reset(Request $request)
    {
        $validator = $this->validator($request);
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }

        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return response()->json([
                'code' => 200,
                'message' => 'Thay đổi mật khẩu thành công mời bạn đăng nhập',
                'redirect_url' => url('/'),
            ]);
        } else {
            if ($response == 'passwords.token') {
                return response()->json([
                    'code' => 101,
                    'message' => trans('fdb::token_invalid'),
                ]);
            }
            return response()->json([
                'code' => 102,
                'message' => trans('fdb::fail'),
            ]);
        }
    }

    protected function validator($request)
    {
        return \Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'required' => trans('fdb::required') . ' :attribute',
            'email' => 'email ' . trans('fdb::malformed'),
            'confirmed' => trans('fdb::confirmed'),
            'min' => ':attribute ' . trans('fdb::content_min') . ' :min',
        ], [
            'password' => trans('fdb::password'),
        ]);
    }

    public function checkToken(Request $request)
    {
        $email = session()->get('EMAIL_CURRENT_FORGOT');
        if (isset($request->phone)) {
            $user = User::where('phone', $request->input('phone'))->first();
            if ($user == null) {
                return response([
                    'code' => 100,
                    'message' => 'Tài khoản không tồn tại!',
                ]);
            }
            $email = $user->email;
            PasswordReset::where('email', $email)->delete();
            $password = new PasswordReset;
            $password->email = $user->email;
            $password->token = Hash::make($request->input('otp'));
            $password->save();
        }

        $checkOTP = PasswordReset::where('email', $email)->first();
        if ($checkOTP == null) {
            return response([
                'code' => 100,
                'message' => 'Yêu cầu không hợp lệ vui lòng thử lại sau',
            ]);
        }

        if (Hash::check($request->otp, $checkOTP->token)) {
            return response([
                'code' => 200,
                'message' => 'Token hợp lệ',
                'redirect_url' => \VRoute::get('reset-password') . "?email=$email&token=$request->otp",
            ]);
        }
        return response([
            'code' => 100,
            'message' => 'Token không hợp lệ!',
        ]);
    }

    public function sendTokenAgain()
    {
        $email = session()->get('EMAIL_CURRENT_FORGOT');
        if ($email == null) {
            return response([
                'code' => 100,
                'message' => 'Email không tồn tại trong hệ thống',
            ]);
        }
        $token = PasswordReset::createToken($email);
        return response([
            'code' => 200,
            'message' => "Gửi yêu cầu lấy lại mật khẩu thành công. Hãy kiểm tra email $email",
        ]);
    }
}
