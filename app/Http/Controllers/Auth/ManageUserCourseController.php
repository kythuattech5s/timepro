<?php
<<<<<<< HEAD

namespace App\Http\Controllers\Auth;

=======
namespace App\Http\Controllers\Auth;
>>>>>>> 8987cf32eaf6f50223a7f73fa5445b2696d4cf2e
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCombo;
use App\Models\OrderStatus;
use App\Models\UserType;
use Auth;
use Illuminate\Http\Request;
use Support;
<<<<<<< HEAD

=======
>>>>>>> 8987cf32eaf6f50223a7f73fa5445b2696d4cf2e
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
<<<<<<< HEAD
            } else {
=======
            }else{
>>>>>>> 8987cf32eaf6f50223a7f73fa5445b2696d4cf2e
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
<<<<<<< HEAD
            } else {
=======
            }else{
>>>>>>> 8987cf32eaf6f50223a7f73fa5445b2696d4cf2e
                return redirect()->to(\VRoute::get("home"))->with('messageNotify', 'Tài khoản của bạn không có chức năng này')->with('typeNotify', 100)->send();
            }
        }
    }
<<<<<<< HEAD
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
    public function myOrder(Request $request, $route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route : \vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $action = \FCHelper::getSegment($request, 2);
        $activeOrderStatus = OrderStatus::where('action', $action)->first();
        $activeStatus = isset($activeOrderStatus) ? $activeOrderStatus->id : OrderStatus::WAIT_PAYMENT;
        $listOrderStatus = OrderStatus::get();
        $listItems = $user->orders()->with('orderDetail', 'paymentMethod', 'orderStatus')->where('order_status_id', $activeStatus)->paginate(6);
        return view('auth.account.my_order', compact('user', 'currentItem', 'listOrderStatus', 'activeStatus', 'listItems'));
=======
    public function myCourse(Request $request,$route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route:\vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $listUserCourseId = $user->userAllCourseId();
        $listItems = Course::baseView()->whereIn('id',$listUserCourseId)
                                        ->paginate(6);
        return view('auth.account.my_course',compact('user','listItems','currentItem'));
    }
    public function upgradeVip(Request $request,$route){
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route:\vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $listCourseCombo = CourseCombo::act()->get();
		return view('auth.account.upgrade_vip',compact('user','listCourseCombo','currentItem'));
	}
    public function myOrder (Request $request,$route)
    {
        $currentItem = $route instanceof \vanhenry\manager\model\VRoute ? $route:\vanhenry\manager\model\VRoute::find($route->id ?? 0);
        $user = Auth::user();
        $action = \FCHelper::getSegment($request, 2);
        $activeOrderStatus = OrderStatus::where('action',$action)->first();
        $activeStatus = isset($activeOrderStatus) ? $activeOrderStatus->id:OrderStatus::WAIT_PAYMENT;
        $listOrderStatus = OrderStatus::get();
        $listItems = $user->orders()->with('orderDetail','paymentMethod','orderStatus')->where('order_status_id',$activeStatus)->paginate(6);
		return view('auth.account.my_order',compact('user','currentItem','listOrderStatus','activeStatus','listItems'));
>>>>>>> 8987cf32eaf6f50223a7f73fa5445b2696d4cf2e
    }
    public function restoreOrder(Request $request)
    {
        $user = Auth::user();
        $order = $user->orders()->with('orderDetail')->find($request->order);
        if (!isset($order)) {
            return response()->json([
                'code' => 100,
                'message' => 'Không có thông '
            ]);
        }
    }
}
