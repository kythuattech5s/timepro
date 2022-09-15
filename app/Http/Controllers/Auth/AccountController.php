<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Http\Traits\Auth\UserAddress;
use App\Models\{Order, Product, User, UserProductFavourite};
use Validator;
use Support;
class AccountController extends Controller
{
    use UserAddress;
    public function goLogin()
    {
        return \Support::response([ 'code' => 100, 'message' => 'Vui lòng đăng nhập','redirect' => \VRoute::get('login')]);
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
        return view('auth.account.profile', compact('user'));
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
        $user->name = $request->input('name', '');
        $user->gender = $request->input('gender', '');
        if (Support::show($user, 'phone') == '') {
            $user->phone = $request->input('phone', '');
        }
        if (Support::show($user, 'email') == '') {
            $user->email = $request->input('email', '');
        }
        if ($request->input('birthday')) {
            $day = \DateTime::createFromFormat('d/m/Y', $request->input('birthday'));
            $validateDay = $day && $day->format('d/m/Y') === $request->input('birthday');
            if (!$validateDay) {
                return response([
                    'code' => 100,
                    'message' => 'Vui lòng nhập đúng định dạng ngày tháng'
                ]);
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
        $user = Auth::user();
        return view('auth.account.change_password', compact('user'));
    }
    private function changePassWord($request)
    {
        $user = Auth::user();
        $validator = $this->validatorChangePassword($request, $user);
        if (empty($user->password)) {
            $validator = $this->validatorPasswordNew($request);
        } else {
            $validator = $this->validatorChangePassword($request, $user);
        }
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first(),
            ]);
        }
        $user->password = \Hash::make($request->password);
        $user->save();
        Auth::logout();
        return response()->json([
            'code' => 200,
            'message' => 'Thay đổi mật khẩu thành công. Vui lòng đăng nhập lại.',
            'redirect_url' => 'dang-nhap'
        ]);
    }
    public function favouriteProducts($request, $route, $link)
    {
        if (!\Auth::check()) {
            return \Support::response(['code' => 100, 'message' => 'Bạn cần đăng nhập trước khi thực hiện tính năng này', 'count' => 0]);
        }
        $user = Auth::user();
        $favourites = $user->favouriteProducts()->act()
            ->orderBy('user_product_favourites.created_at', 'desc')
            ->orderBy('products.id', 'desc')
            ->paginate(10);
        return view('auth.account.favourite_product', compact('user', 'favourites', 'route', 'link'));
    }
    public function addAndRemoveFavouriteProduct($request, $route, $link)
    {
        if (!\Auth::check()) {
            return response()->json(['code' => 100, 'message' => 'Bạn cần đăng nhập trước khi thực hiện tính năng này', 'count' => 0]);
        }
        $product_id = $request->input('id');
        $check = $this->processAddAndRemoveFavouriteProduct($product_id);
        $count = UserProductFavourite::where(['user_id' => Auth::id()])->get()->count();
        if ($check) {
            return response()->json(['code' => 200, 'message' => 'Đã thêm sản phẩm vào danh sách yêu thích', 'count' => $count]);
        } else {
            return response()->json(['code' => 100, 'message' => 'Đã bỏ sản phẩm ra khỏi danh sách yêu thích', 'count' => $count]);
        }
    }
    public function addFavouriteProductCart($request, $route, $link)
    {
        if (!\Auth::check()) {
            return response()->json(['code' => 100, 'message' => 'Bạn cần đăng nhập trước khi thực hiện tính năng này', 'count' => 0]);
        }
        $items = $request->input('items');
        if (count($items) == 0) {
            return Support::response(['code' => 100, 'message' => 'Thiếu thông tin dữ liệu']);
        }
        foreach (collect(array_filter($items))->unique() as $item) {
            $favoriteCurrent = UserProductFavourite::where(['product_id' => $item, 'user_id' => Auth::id()])->first();
            if ($favoriteCurrent == null) {
                $favourites = new UserProductFavourite();
                $favourites->user_id = Auth::id();
                $favourites->product_id = $item;
                $favourites->save();
            }
        }
        $count = UserProductFavourite::where(['user_id' => Auth::id()])->get()->count();
        return response()->json(['code' => 200, 'message' => 'Đã thêm sản phẩm vào danh sách yêu thích', 'count' => $count]);
    }
    private function processAddAndRemoveFavouriteProduct($product_id)
    {
        $favoriteCurrent = UserProductFavourite::where(['product_id' => $product_id, 'user_id' => Auth::id()])->first();
        if ($favoriteCurrent == null) {
            $favourites = new UserProductFavourite();
            $favourites->user_id = Auth::id();
            $favourites->product_id = $product_id;
            $favourites->save();
            $check = true;
        } else {
            UserProductFavourite::where(['product_id' => $product_id, 'user_id' => Auth::id()])->delete();
            $check = false;
        }
        return $check;
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
    public function myNofifycation($request, $route, $link)
    {
        if (!Auth::check()) {
            return $this->goLogin();
        }
        $currentItem = \vanhenry\manager\model\VRoute::find($route->id);
        $user = Auth::user();
        $listItems = $user->notifications()->paginate(10);
        return view('auth.account.my_notifycation', compact('currentItem', 'listItems', 'user'));
    }
    public function showRating(Request $request, $route, $link)
    {
        $order = Order::with(['comments', 'orderProduct' => function ($q) {
            $q->with('product');
        }])->where('user_id', Auth::id())->where('id', $request->id)->first();
        $html = view('path.rating_order', compact('order'))->render();
        return response([
            'code' => 200,
            'html' => $html
        ]);
    }
    public function buyRepurchase(Request $request)
    {
        $order = Order::with(['orderProduct' => function ($q) {
            $q->with('product');
        }])->find($request->id);
        $items = [];
        foreach ($order->orderProduct as $orderProduct) {
            $items[$orderProduct->product_id] = [
                'properties' => $orderProduct->product->hash_properties == null ? [] : $orderProduct->product->hash_properties,
                'qty' => $orderProduct->qty,
            ];
        }
        $buyables = [];
        foreach ($items as $productId => $item) {
            $product = Product::select(Product::FIELD_SELECT_FOR_ADDCART)->act()->where('id', $productId)->first();
            if ($product == null) {
                return Support::response(['code' => 100, 'message' => 'Sản phẩm không tồn tại']);
            }
            $buyable = ['buyable' => $product, 'qty' => empty($item['qty']) ? 1 : $item['qty'], 'options' => []];
            if ($product->parent != null) {
                if ($product->quantity == 0) {
                    return Support::response([
                        'code' => 100,
                        'message' => 'Sản phẩm đã hết hàng'
                    ]);
                }
            } else {
                if ($product->variants()->count() > 0) {
                    $properties = $item['properties'] ?? [];
                    if (!is_array($properties) || count($properties) == 0) {
                        return Support::response([
                            'code' => 100,
                            'message' => 'Vui lòng chọn đầy đủ thuộc tính'
                        ]);
                    }
                    $propertyValue = [];
                    foreach ($properties as $key => $property) {
                        foreach ($property as $value) {
                            array_push($propertyValue, $value);
                        }
                    }
                    $variant = $product->variants()->select(Product::FIELD_SELECT_FOR_ADDCART);
                    foreach ($propertyValue as $propertyValueItem) {
                        $variant = $variant->where('hash_properties', 'like', "%" . $propertyValueItem . "%");
                    }
                    $variant =  $variant->first();
                    if ($variant == null) {
                        return Support::response([
                            'code' => 100,
                            'message' => 'Sản phẩm không tồn tại'
                        ]);
                    }
                    if ($variant->quantity == 0) {
                        return Support::response([
                            'code' => 100,
                            'message' => 'Sản phẩm đã hết hàng'
                        ]);
                    }
                    $buyable['buyable'] = $variant;
                    $buyable['options'] = $properties;
                } else {
                    if ($product->quantity == 0) {
                        return Support::response([
                            'code' => 100,
                            'message' => 'Sản phẩm đã hết hàng'
                        ]);
                    }
                }
            }
            $buyables[] = $buyable;
        }
        if (count($buyables) == 0) {
            return Support::response([
                'code' => 103,
                'message' => 'Bạn chưa chọn sản phẩm nào'
            ]);
        }
        $this->cartBuyProduct->setGlobalTax(0);
        foreach ($buyables as $buyable) {
            $this->cartBuyProduct->add($buyable['buyable'], $buyable['qty'], $buyable['options']);
        }
        return Support::response([
            'code' => 200,
            'message' => 'Đã thêm vào giỏ hàng',
            'count_cart' => $this->cartBuyProduct->countItems(),
            'redirect_url' => url('gio-hang')
        ]);
    }
}
