<?php
namespace App\Http\Traits\Auth;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use App\Events\ConfirmDataSuccess;
use App\Events\RegisterSuccess;
use App\Helpers\MediaHelper;
use App\Models\User;
use Session;
use Support;
use Auth;
trait LoginSocial
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToSocial($request, $route, $link)
    {
        Support::URLPrevious(true);
        $provider = $this->getProvider($request->segment(2));
        return $provider->redirect();
    }
    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($request, $route, $link)
    {
        $infos = [
            'name' => null, 
            'picture' => null, 
            'email' => null, 
            'email_verified' => null, 
            'locale' => null, 
            'id' => null, 
            'verified_email' => null
        ];
        try
        {
            $results = Socialite::driver(str_replace('callback-', '', $link))->stateless()->user();
        }
        catch (\Exception$ex) {
            if (request()->ajax()) {
                return response(
                    ['code' => 100, 'message' => 'Bạn đã từ chối ủy quyền cho Google xác thực', 'redirect' => \VRoute::get('register'),
                    ]);
            }
            else {
                return redirect()->to('/')->with('typeNotify', 100)->with('messageNotify', 'Bạn đã từ chối ủy quyền cho Google xác thực');
            }
        }
        if ($link == 'callback-facebook') {
            if (!isset($results->user['email'])) {
                return redirect()->to('/')->with("typeNotify", 100)->with("messageNotify", "Không thể đăng nhập, Không thể xác thực tài khoản email từ tài khoản facebook của bạn");
            }
            $infos['name'] = $results->user['name'] ?? '';
            $infos['picture'] = $results->getAvatar();
            $infos['email'] = $results->user['email'] ?? '';
            $infos['id'] = $results->user['id'];
        }
        if ($link == 'callback-google') {
            $infos['name'] = $results->user['name'];
            $infos['picture'] = $results->user['picture'];
            $infos['email'] = $results->user['email'];
            $infos['email_verified'] = $results->user['email_verified'];
            $infos['locale'] = $results->user['locale'];
            $infos['id'] = $results->user['id'];
            $infos['verified_email'] = $results->user['verified_email'];
        }

        $user = User::where('email', $infos['email'])->first();

        if ($user == null) {
            $user = new User;
            $user->name = $infos['name'];
            if ($infos['picture'] != null) {
                $user->img = \App\Helpers\MediaHelper::insertFileFromUrl('users', $infos['picture']);
            }
            $user->email = $infos['email'];
            $user->banned = 0;
            $user->act = 0;
            $user->created_at = new \DateTime;
            $user->updated_at = new \DateTime;
            $code = \Str::random(6);
            $user->token = Hash::make($code);
            $user->save();
            event('sendmail.static', [[
                'title' => 'Tạo tài khoàn thành công và mã xác nhận kích hoạt tài khoản',
                'data' => [
                    'link' => url('kich-hoat-tai-khoan') . "?token=$code&email=$user->email",
                    'user' => $user,
                ],
                'email' => $user->email,
                'type' => 'user_create',
            ]]);
            $user->save();
            event(new Registered($user));
            session()->put('EMAIL_CURRENT_REGISTER', $user->email);
            session()->put('REGISTER_SOCIAL_NOW', '1');
            return redirect()->to('xac-nhan-tai-khoan?token=' . $code)->with('messageNotify', 'Tài khoản của bạn đã được tạo vui lòng kiểm tra địa chỉ Email để xác nhận tại khoản')->with('typeNotify', 200);
        }
        else {
            if ($user->banned == 1) {
                return redirect()->to('/')->with('messageNotify', 'Tài khoản của bạn đã bị khóa')->with('typeNotify', 100);
            }
            if ($user->act == 0) {
                return redirect()->to('/')->with('messageNotify', 'Tài khoản của bạn chưa được kích hoạt vui lòng liên hệ với quản trị viên')->with('typeNotify', 100);
            }
            auth()->login($user, true);
        }
        if ($request->ajax()) {
            return response(['code' => 200, 'message' => 'Đăng nhập thành công', 'redirect' => Support::URLPrevious(false)]);
        }
        else {
            return redirect(Support::URLPrevious(false))->with('typeNotify', 200)->with('messageNotify', 'Đăng nhập thành công');
        }
    }
    public function setPasswordLoginSocial($request)
    {
        $validator = $this->validatorPassword($request->all());
        if ($validator->fails()) {
            return response()->json([ 'code' => 100, 'message' => $validator->errors()->first()]);
        }
        $dataUser = session('registerUserSocial');
        $data['name'] = $dataUser->getName();
        $data['email'] = $dataUser->getEmail();
        $data['password'] = Hash::make($request->input('password'));
        $data['act'] = 1;
        $data['created_at'] = new \DateTime;
        $data['updated_at'] = new \DateTime;
        $user = User::where('email', $data['email'])->first();
        if (!isset($user)) {
            $user = User::create($data);
        }
        event(new Registered($user));
        $this->guard('web')->login($user);
        RegisterSuccess::dispatch($user->id);
        return response()->json(['code'=>200,'message'=>trans("fdb::register_acc_success"),'redirect_url'=>\VRoute::get('my-profile')]);
    }
    public function getProvider($provider)
    {
        switch ($provider) {
            case 'facebook':
                $config = [
                    'client_id' => config('services.facebook.client_id'),
                    'client_secret' => config('services.facebook.client_secret'),
                    'redirect' => config('services.facebook.redirect')
                ];
                return $provider = Socialite::buildProvider(
                    \Laravel\Socialite\Two\FacebookProvider::class,
                    $config
                );
                break;
            case 'google':
                $config = [
                    'client_id' => config('services.google.client_id'),
                    'client_secret' => config('services.google.client_secret'),
                    'redirect' => config('services.google.redirect')
                ];
                return $provider = Socialite::buildProvider(
                    \Laravel\Socialite\Two\GoogleProvider::class,
                    $config
                );
                break;
        }
    }
    
    protected function validatorPassword(array $data)
    {
        return \Validator::make($data, [
            'password' => ['required', 'string', 'min:8', 'confirmed','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!*$#%@!^&()]).*$/'],
        ], [
            'max' => ':attribute tối đa là :max ký tự',
            'unique' => ':attribute đã được dùng',
            'numeric' => ':attribute Không hợp lệ',
            'min' => ':attribute tối thiểu là :min ký tự',
            'regex' => 'Mật khẩu cần ít nhất là 8 ký tự và phải bao gồm 1 ký tự in hoa 1 ký tự in thường 1 số và 1 ký tự đặc biệt',
            'confirmed' => 'Mật khẩu xác nhận không khớp',
        ], [
            'password' => 'Mật khẩu',
            'password_confirmation' => 'Xác nhận mật khẩu',
        ]);
    }
}
