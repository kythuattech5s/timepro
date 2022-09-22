<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCombo;
use App\Models\CourseComboTimePackage;
use App\Models\CourseTimePackage;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\UserCourseCombo;
use App\Models\UserWalletTransactionType;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Support;
use Tech5s\Voucher\Helpers\VoucherCheck;
use Tech5sCart;

class OrderController extends Controller
{
    protected $cartInstance = ['course','vip'];
    protected function _resetCartInfo()
    {
        $hasChangePrice = false;
        foreach ($this->cartInstance as $itemCartInstance) {
            Tech5sCart::instance($itemCartInstance);
            foreach (Tech5sCart::content() as $item) {
                if (isset($newItem) && $item->id == $newItem->id && $item->rowId != $newItem->rowId && $newItem->instance == $itemCartInstance) {
                    Tech5sCart::update($item->rowId, 0, false);
                } else {
                    Tech5sCart::update($item->rowId, 1, false);
                    if ($itemCartInstance == 'course') {
                        $itemTimePackage = CourseTimePackage::find($item->options->id ?? 0);
                        if (isset($itemTimePackage)) {
                            $itemTimePackagePriceInfo = $itemTimePackage->getPriceInfo();
                            if ($itemTimePackagePriceInfo->price != $item->price) {
                                $hasChangePrice = true;
                                Tech5sCart::update($item->rowId, 0, false);
                                $dataTimePackage = [];
                                $dataTimePackage['id'] = $itemTimePackage->id;
                                $dataTimePackage['course_id'] = $itemTimePackage->course_id;
                                $dataTimePackage['name'] = $itemTimePackage->name;
                                $dataTimePackage['number_day'] = $itemTimePackage->number_day;
                                $dataTimePackage['is_forever'] = $itemTimePackage->is_forever;
                                $dataTimePackage['price'] = $itemTimePackagePriceInfo->price;
                                $dataTimePackage['price_old'] = $itemTimePackagePriceInfo->price_old;
                                Tech5sCart::add($item->id, $item->name, 1, $itemTimePackagePriceInfo->price, 0, $dataTimePackage);
                            }
                        }
                    }
                }
            }
            Tech5sCart::store();
        }
        return $hasChangePrice;
    }
    protected function validatorSendPayment(array $data)
    {
        return Validator::make($data, [
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['required','email'],
            'payment_method' => ['required',Rule::exists('payment_methods', 'id')->where('act', 1)]
        ], [
            'required' => 'Vui lòng nhập :attribute',
            'email' => 'Vui lòng nhập đúng định dạng Email',
            'payment_method.exists' => 'Không tìm thấy phương thức thanh toán',
        ], [
            'name' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'payment_method' => 'Phương thức thanh toán',
        ]);
    }
    public function sendPayment(Request $request)
    {
        if (!Auth::check()) {
            session()->flash('typeNotify',200);
            session()->flash('messageNotify','Vui lòng đăng nhập để xác nhận thanh toán đơn hàng');
            return response()->json([
                'code' => 200,
                'redirect_url' => \VRoute::get("login")
            ]);
        }
        $user = Auth::user();
        $userOrerData = $request->all();
        $validator = $this->validatorSendPayment($request->all());
        if ($validator->fails()) {
            return response()->json([
                'code' => 100,
                'message' => $validator->errors()->first()
            ]);
        }
        $changePriceStatus = $this->_resetCartInfo();
        if ($changePriceStatus) {
            session()->flash('typeNotify',200);
            session()->flash('messageNotify','Một số sản phẩm trong giỏ hàng đã cập nhật lại giá. Vui lòng kiểm tra lại trước khi thanh toán.');
            return response()->json([
                'code' => 200,
                'redirect_url' => \VRoute::get("viewCart")
            ]);
        }
        $listItems = [];
        $totalMoney = 0;
        foreach ($this->cartInstance as $itemCartInstance) {
            Tech5sCart::instance($itemCartInstance);
            $instanceContent = Tech5sCart::content();
            foreach ($instanceContent as $item) {
                switch ($itemCartInstance) {
                    case 'course':
                        $realItem = Course::baseView()->with('category')->find($item->id);
                        $itemTimePackage = CourseTimePackage::find($item->options->id ?? 0);
                        if ($realItem->isOwnForever($user)) {
                            Tech5sCart::update($item->rowId,0);
                            return Support::redirectTo(\VRoute::get("viewCart"),200,vsprintf('Khóa học %s của bạn đã được kích hoạt vĩnh viễn. Giỏ hàng đã tự cập nhật lại',[$realItem->name]));
                        }
                        break;
                    case 'vip':
                        $realItem = CourseCombo::baseView()->find($item->id);
                        $itemTimePackage = CourseComboTimePackage::find($item->options->id ?? 0);
                        $foreverUserCourse = UserCourseCombo::where('user_id',$user->id)
                                    ->where('is_forever',1)
                                    ->where('course_combo_id',$realItem->id)
                                    ->first();
                        if ($foreverUserCourse) {
                            Tech5sCart::update($item->rowId,0);
                            return Support::redirectTo(\VRoute::get("viewCart"),200,vsprintf('Gói Vip %s của bạn đã được kích hoạt vĩnh viễn. Giỏ hàng đã tự cập nhật lại',[$realItem->name]));
                        }
                        break;
                    default:
                        $realItem = null;
                        break;
                }
                if (isset($realItem) && isset($itemTimePackage)) {
                    $item->instance = $itemCartInstance;
                    $item->realItem = $realItem;
                    $item->itemTimePackage = $itemTimePackage;
                    $totalMoney += $item->price;
                    array_push($listItems,$item);
                }
            }
        }
        $voucherCheck = new VoucherCheck();
        $totalFinal = $totalMoney;
        if($voucherCheck->voucher != null){
            $totalFinal -= $voucherCheck->discount;
        }
        if (count($listItems) == 0) {
            return response()->json([
                'code' => 100,
                'message' => 'Bạn tạm thời không có sản phẩm nào trong giỏ hàng'
            ]);
        }
        if ($userOrerData['payment_method'] == PaymentMethod::PAY_WALLET) {
            if ($user->getAmountAvailable() < $totalFinal) {
                return response()->json([
                    'code' => 100,
                    'message' => 'Số dư ví của bạn không đủ'
                ]);
            }
        }
        $order = $this->createOrder($listItems,$totalMoney,$totalFinal,$userOrerData,$user,$voucherCheck);
        if ($userOrerData['payment_method'] == PaymentMethod::PAY_WALLET) {
            $reason = vsprintf('Thanh toán đơn hàng %s',[$order->code]);
            $user->minusAmountAvailable($totalFinal,UserWalletTransactionType::PAYMENT_ORDER,$reason,$order->id);
            $order->orderSuccess();
        }
        foreach ($this->cartInstance as $itemCartInstance) {
            Tech5sCart::instance($itemCartInstance);
            Tech5sCart::destroy();
        }
        // Xóa voucher
        $voucherCheck->destroy();
        return response()->json([
            'code' => 200,
            'message' => 'Đặt hàng thành công',
            'redirect_url' => \VRoute::get("paymentSucess").'?order='.$order->code
        ]);
    }
    public function createOrder($listItems,$totalMoney,$totalFinal,$userOrerData,$user,$voucherCheck)
    {
        $order = new Order;
        $order->user_id = $user->id;
        if($voucherCheck->voucher != null){
            $order->voucher_info = $voucherCheck->voucher->toJson();
        }
        $order->name = $userOrerData['name'] ?? '';
        $order->phone = $userOrerData['phone'] ?? '';
        $order->email = $userOrerData['email'] ?? '';
        $order->content = $userOrerData['note'] ?? '';
        $order->order_status_id = OrderStatus::WAIT_PAYMENT;
        $order->payment_method_id = $userOrerData['payment_method'];
        $order->total = $totalMoney;
        $order->total_final = $totalFinal;
        $order->save();
        $order->code = 'TPORD_'.$order->id;
        $order->save();
        foreach ($listItems as $item) {
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->type = $item->instance;
            $orderDetail->user_id = $user->id;
            $orderDetail->map_id = $item->realItem->id;
            $orderDetail->name = $item->realItem->name;
            $orderDetail->slug = $item->realItem->slug ?? '';
            $orderDetail->img = $item->realItem->img;
            $orderDetail->time_package_id = $item->itemTimePackage->id;
            $orderDetail->name_time_package = $item->itemTimePackage->name;
            $orderDetail->description = $item->itemTimePackage->description;
            $orderDetail->number_day = $item->itemTimePackage->number_day;
            $orderDetail->is_forever = $item->itemTimePackage->is_forever;
            $orderDetail->price = $item->itemTimePackage->price;
            $orderDetail->price_old = $item->itemTimePackage->price_old;
            $orderDetail->qty = 1;
            $orderDetail->save();
        }
        return $order;
    }
    public function orderSuccess(Request $request,$route)
    {
        if (!Auth::check()) {
            return Support::redirectTo(\VRoute::get("home"),100,'Không tìm thấy thông tin đơn hàng');
        }
        $order = Order::with('user','paymentMethod','orderStatus','orderDetail')
                        ->where('user_id',Auth::id())
                        ->where('code',$request->order ?? '')
                        ->first();
        if (!isset($order)) {
            return Support::redirectTo(\VRoute::get("home"),100,'Không tìm thấy thông tin đơn hàng');
        }
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route:\vanhenry\manager\model\VRoute::find($route->id ?? 0);
        return view('carts.order_success',compact('currentItem','order'));
    }
}
