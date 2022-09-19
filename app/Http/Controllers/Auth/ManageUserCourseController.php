<?php


namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCombo;
use App\Models\OrderStatus;
use App\Models\UserType;
use Auth;
use Illuminate\Http\Request;
use Support;
use Tech5sCart;

class ManageUserCourseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) {
            if (request()->ajax()) {
                echo json_encode([
                    'code' => 100,
                    'message' => 'Vui lòng đăng nhập',
                    'redirect_url' => \VRoute::get("login")
                ]);
                die();
            }else{
                return redirect()->to(\VRoute::get("login"))->with('messageNotify', 'Vui lòng đăng nhập')->with('typeNotify', 100)->send();
            }
        }
        $user = Auth::user();
        if ($user->user_type_id != UserType::NORMAL_ACCOUNT) {
            if (request()->ajax()) {
                echo json_encode([
                    'code' => 100,
                    'message' => 'Tài khoản của bạn không có chức năng này',
                    'redirect_url' => \VRoute::get("login")
                ]);
                die();
            } else{
                return redirect()->to(\VRoute::get("home"))->with('messageNotify', 'Tài khoản của bạn không có chức năng này')->with('typeNotify', 100)->send();
            }
        }
    }
    public function myCourse(Request $request, $route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route : \vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $listUserCourseId = $user->userAllCourseId();
        $listItems = Course::baseView()->whereIn('id', $listUserCourseId);


        $listItems->when(request()->input('type'), function ($q, $type) use ($user) {
            //Chưa học
            if ($type == 2) {
                $q->whereHas('videos', function ($q) use ($user) {
                    $q->whereDoesntHave('users');
                });
            }

            //Đang học
            if ($type == 3) {
                $q->whereHas('videos', function ($q) use ($user) {
                    $q->whereDoesntHave('users');
                });
            }

            //Đã hoàn thành
            if ($type == 4) {
                $q->whereHas('videos', function ($q) use ($user) {
                    $q->whereHas('users', function ($q) use ($user) {
                        $q->where('course_video_user.user_id', $user->id);
                    });
                });
            }
            //Đang học
        });


        $listItems = $listItems->paginate(6);
        return view('auth.account.my_course', compact('user', 'listItems', 'currentItem'));
    }
    public function upgradeVip(Request $request, $route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route : \vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $listCourseCombo = CourseCombo::act()->get();
        return view('auth.account.upgrade_vip', compact('user', 'listCourseCombo', 'currentItem'));
    }
    public function myOrder (Request $request,$route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route:\vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $action = \FCHelper::getSegment($request, 2);
        $activeOrderStatus = OrderStatus::where('action',$action)->first();
        $activeStatus = isset($activeOrderStatus) ? $activeOrderStatus->id:OrderStatus::WAIT_PAYMENT;
        $listOrderStatus = OrderStatus::get();
        $listItems = $user->orders()->orderBy('id','desc')->with('orderDetail','paymentMethod','orderStatus')->where('order_status_id',$activeStatus)->paginate(6);
		return view('auth.account.my_order',compact('user','currentItem','listOrderStatus','activeStatus','listItems'));
    }
    public function restoreOrder(Request $request)
    {
        $user = Auth::user();
        $order = $user->orders()->with('orderDetail')->find($request->order);
        if (!isset($order)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy thông tin đơn hàng'
            ]);
        }
        foreach ($order->orderDetail as $itemOrderDetail) {
            $dataTimePackage = [];
            $dataTimePackage['id'] = $itemOrderDetail->time_package_id;
            $dataTimePackage['name'] = $itemOrderDetail->name_time_package;
            $dataTimePackage['price'] = $itemOrderDetail->price;
            $dataTimePackage['price_old'] = $itemOrderDetail->price_old;
            $dataTimePackage['description'] = $itemOrderDetail->description;
            $dataTimePackage['number_day'] = $itemOrderDetail->number_day;
            $dataTimePackage['is_forever'] = $itemOrderDetail->is_forever;
            Tech5sCart::instance($itemOrderDetail->type);
            Tech5sCart::add($itemOrderDetail->map_id,$itemOrderDetail->name,1,$itemOrderDetail->price,0,$dataTimePackage);
        }
        session()->flash('typeNotify',200);
        session()->flash('messageNotify','Đã thêm tất cả sản phẩm vào giỏ hàng');
        return response()->json([
            'code' => 200,
            'redirect_url' => \VRoute::get("viewCart")
        ]);
    }
    public function cancelOrder (Request $request)
    {
        $user = Auth::user();
        $order = $user->orders()->with('orderDetail')->find($request->order);
        if (!isset($order)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không tìm thấy thông tin đơn hàng'
            ]);
        }
        $order->order_status_id = OrderStatus::CANCEL;
        $order->cancel_user_type = 'user';
        $order->user_cancel_id = $user->id;
        $order->save();
        session()->flash('typeNotify',200);
        session()->flash('messageNotify','Thay đổi trạng thái đơn hàng thành công.');
        return response()->json([
            'code' => 200,
        ]);
    }
}