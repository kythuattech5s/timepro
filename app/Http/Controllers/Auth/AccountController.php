<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Traits\Auth\{UpgradeVip,UserWallet};
use App\Models\{User,Province};
use Validator;
use Support;
class AccountController extends Controller
{
    use UserWallet;
    public function goLogin()
    {   
        if(request()->isMethod('GET')){
            return \Redirect::to(url('/'))->with('typeNotify',100)->with('messageNotify','Vui lòng đăng nhập');
        }
        else{
            return response()->json([ 'code' => 100, 'message' => 'Vui lòng đăng nhập','redirect' => \VRoute::get('login')]);
        }
    }
    public function profile(Request $request, $route)
    {
        if (!Auth::check()) {
            return $this->goLogin();
        }
        $user = Auth::user();
        if ($request->isMethod("POST")) {
            return $this->updateProfile($request, $user);
        }
        if(\Support::show($user,'user_type_id') == 1){
            $provinces = Province::all();
            return view('auth.account.profile', compact('user','provinces'));
        }
        else{
            $provinces = Province::all();
            return view('auth.teacher.profile', compact('user','provinces'));
        }
    }
    protected function validatorUpdateProfile(array $data)
    {
        return Validator::make($data, [
            'name' => ['required'],
            'phone' => ['unique:users,phone,' . Auth::id()],
            'email' => ['email', 'unique:users,email,' . Auth::id()]
        ], [
            'required' => 'Vui lòng chọn hoặc nhập :attribute',
            'unique' => ':attribute đã tồn tại trong hệ thống'
        ], [
            'phone' => 'Số điện thoại',
            'name' => 'Họ và tên',
            'email' => 'Email'
        ]);
    }
    public function updateProfile($request, $user)
    {
        if (!Auth::check()) {
            return $this->goLogin();
        }
        $validator = $this->validatorUpdateProfile($request->all());
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }
        if ($request->input('product_id','') != '' && ($request->input('district_id','') == '' || $request->input('ward_id','') == '')) {
            return response()->json([
                'code' => 100,
                'message' => 'Bạn cần điền đầy đủ Quận Huyện / Phường Xã',
            ]);
        }
        $user->name = $request->input('name', '');
        $user->gender = $request->input('gender', '');
        if (Support::show($user, 'phone') == '') {
            $user->phone = $request->input('phone', '');
        }
        if (Support::show($user, 'email') == '') {
            $user->email = $request->input('email', '');
        }
        if($request->input('product_id','') != ''){
            $user->product_id = $request->input('product_id','');
        }
        if($request->input('district_id','') != ''){
            $user->district_id = $request->input('district_id','');
        }
        if($request->input('ward_id','') != ''){
            $user->ward_id = $request->input('ward_id','');
        }
        if($request->input('address','') != ''){
            $user->address = $request->input('address','');
        }
        if ($request->input('birthday')) {
            $day = \DateTime::createFromFormat('d/m/Y', $request->input('birthday'));
            $validateDay = $day && $day->format('d/m/Y') === $request->input('birthday');
            if (!$validateDay) {
                return response(['code' => 100,'message' => 'Vui lòng nhập đúng định dạng ngày tháng']);
            }
            $user->birthday = $day;
        }
        $user->img = isset($request->avatar) ? \Support::uploadImg('avatar', 'avatar') : $user->img;
        $user->save();
        return response()->json([
            'code' => 200,
            'message' => 'Cập nhật thông tin thành công'
        ]);
    }
    public function switchChangePassword(Request $request, $route)
    {
        if (!Auth::check()) {
            return $this->goLogin();
        }
        if ($request->isMethod("POST")) {
            return $this->changePassWord($request);
        }
        if(\Support::show($user,'user_type_id') == 1){
            $user = Auth::user();
            return view('auth.account.change_password', compact('user'));
        }
        else{
            $provinces = Province::all();
            return view('auth.teacher.change_password', compact('user'));
        }
    }
    private function changePassWord($request)
    {
        $user = Auth::user();
        $validator = $this->validatorChangePassword($request, $user);
        if (empty($user->input('password'))) {
            $validator = $this->validatorPasswordNew($request);
        }
        else {
            $validator = $this->validatorChangePassword($request, $user);
        }
        if ($validator->fails()) {
            return response()->json(['code' => 100,'message' => $validator->errors()->first()]);
        }
        $user->password = \Hash::make($request->input('password'));
        $user->save();
        Auth::logout();
        return response()->json([
            'code' => 200,
            'message' => 'Thay đổi mật khẩu thành công. Vui lòng đăng nhập lại.',
            'redirect_url' => 'dang-nhap'
        ]);
    }
    private function validatorChangePassword($request, $user)
    {
        return \Validator::make($request->all(), [
            'current_password' => ['required', function ($attr, $v, $fail) use ($user) {
                if (!\Hash::check($v, $user->password)) {
                    return $fail('Mật khẩu hiện tại không đúng');
                }
            }],
            'password' => ['required', 'confirmed', 'min:8', 'different:current_password'],
        ], [
            'min' => ':attribute ít nhất :min ký tự',
            'required' => 'Vui lòng điền :attribute',
            'confirmed' => 'Mật khẩu mới khác mật khẩu xác nhận',
            'different' => 'Mật khẩu mới phải khác mật khẩu cũ',
        ], [
            'current_password' => 'Mật khẩu hiện tại',
            'password' => 'Mật khẩu mới',
            'password_confirmation' => 'Mật khẩu xác nhận',
        ]);
    }
    private function validatorPasswordNew($request)
    {
        return \Validator::make($request->all(), [
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'required' => 'Vui lòng điền :attribute',
            'min' => ':attribute ít nhất :min ký tự',
            'confirmed' => 'Mật khẩu mới khác mật khẩu xác nhận',
        ], [
            'password' => 'Mật khẩu mới',
            'password_confirmation' => 'Mật khẩu xác nhận',
        ]);
    }
}
