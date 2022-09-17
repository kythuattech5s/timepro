<?php
namespace App\Http\Traits\Auth;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use App\Events\ConfirmDataSuccess;
use App\Events\RegisterSuccess;
use App\Helpers\CodeOtpHelper;
use App\Models\User;
use Auth;
use Session;
use App\Helpers\MediaHelper;
trait LoginSocial
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToSocial($request, $route, $link)
    {
        $urlRedirect = $request->input('redirect',url('/'));
        Session::put('_url_intended_',$urlRedirect);
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
        if ($link == 'callback-facebook') {
            try {
                $results = Socialite::driver('facebook')->stateless()->user();
            } catch (\Exception $ex) {
                return \Support::response([
                    'code' => 100,
                    'message' => trans("fdb::refuse_auth_fb"),
                    'redirect' => \VRoute::get('register')
                ]);
            }
            $infos['name'] = $results->user['name'];
            $infos['picture'] = $results->getAvatar();
            $infos['email'] = isset($results->user['email'])?$results->user['email']:$results->user['id'].'@fb.com';
            $infos['id'] = $results->user['id'];
        }
        if ($link == 'callback-google') {
            try {
                $results = Socialite::driver('google')->stateless()->user();
            }
            catch (\Exception $ex) {
                return response([
                    'code' => 100,
                    'message' => trans("fdb::refuse_auth_gg"),
                    'redirect' => \VRoute::get('register')
                ]);
            }
            $infos['name'] = $results->user['name'];
            $infos['picture'] = $results->user['picture'];
            $infos['email'] =  isset($results->user['email'])?$results->user['email']:$results->user['id'].'@google.com';
            $infos['email_verified'] = $results->user['email_verified'];
            $infos['locale'] = $results->user['locale'];
            $infos['id'] = $results->user['id'];
            $infos['verified_email'] = $results->user['verified_email'];
        }
        if ($infos['email'] == null) {
            return  response([
                'code' => 100,
                'message' => 'Tài khoản thiếu email',
                'redirect' => url('/dang-ky')
            ]);
        }
        $user = User::where('email', $infos['email'])->first();
        if ($user == null) {
            $user = new User;
            $user->name = $infos['name'];
            if ($infos['picture'] != null) {
                $user->img = MediaHelper::insertFileFromUrl('users', $infos['picture']);
            }
            $user->email = $infos['email'];
            $user->act = 1;
            $user->banned = 0;
            $user->created_at = new \DateTime;
            $user->updated_at = new \DateTime;
            $user->save();
            //event(new Registered($user));
        }
        else {
            if ($user->banned == 1) {
                return  response([
                    'code' => 101,
                    'message' => 'Tài khoản đã bị khóa',
                    'redirect' => url('/dang-ky')
                ]);
            }
            if ($user->act == 0) {
                return  response([
                    'code' => 102,
                    'message' => 'Tài khoản chưa được kích hoạt',
                    'redirect' => url('/dang-ky')
                ]);
            }
        }
        auth()->login($user, true);
        
        $url = Session::has('_url_intended_')?url(Session::get('_url_intended_')):'/';
        return redirect($url);
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
